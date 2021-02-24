<?php

namespace App\Http\Controllers\Fontend;

use App\Product;
use App\Purchase_policy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('fontend.cart');
    }

    public function add(Request $request, $id)
    {
        if ($request->ajax()) {
            //=== Ktra user đăng nhập chưa
            if (!Auth::guard('customer')->check()) {
                return response()->json([
                    'status' => 'error'
                ]);
            }

            //=== Ktra sản phẩm còn số lượng k
            $product = Product::find($id);
            if ($product->amount == 0) {
                return response()->json([
                    'status' => false,
                    'message' => "Sản phẩm đã hết!"
                ]);
            }

            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->num_order ?? 1,
                'price' => $product->discount ? $product->discount : $product->price,
                'options' => [
                    'avatar' => $product->avatar,
                    'price_old' => $product->price,
                    'price_discount' => $product->discount,
                    'slug_category' => $product->category->slug,
                    'slug_product' => $product->slug
                ]
            ]);

            //Tổng số lượng sản phẩm
            $number_total = Cart::count();

            //Dropdown cart
            $dropdown_cart = view('fontend.compoments.dropdown-cart')->render();

            return response()->json([
                'product' => $product,
                'status' => 'ok',
                'message' => 'Thêm sản phẩm thành công!',
                'number_total' => $number_total,
                'dropdown_cart' => $dropdown_cart
            ]);
        }
    }

    public function buyNow(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product->amount == 0) {
            return back()->with('warning', 'Sản phẩm đã hết!');
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->discount ? $product->discount : $product->price,
            'options' => [
                'avatar' => $product->avatar,
                'price_old' => $product->price,
                'price_discount' => $product->discount,
                'slug_category' => $product->category->slug,
                'slug_product' => $product->slug
            ]
        ]);

        return redirect()->route('order.checkout');
    }

    public function remove(Request $request, $rowId)
    {
        if ($request->ajax()) {
            Cart::remove($rowId);

            //Tổng số lượng sản phẩm
            $number_total = Cart::count();

            //Tổng tiền đơn hàng
            $total_price = Cart::total();

            //Dropdown cart
            $dropdown_cart = view('fontend.compoments.dropdown-cart')->render();

            return response()->json([
                'status' => 'ok',
                'number_total' => $number_total,
                'dropdown_cart' => $dropdown_cart,
                'total_price' => $total_price
            ]);
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            Cart::update($request->rowId, $request->qty);
            //Tổng số tiền theo sản phẩm
            $sub_total = Cart::get($request->rowId)->total();

            //Tổng tiền đơn hàng
            $total_price = Cart::total();

            //Tổng số lượng sản phẩm
            $number_total = Cart::count();

            //Dropdown cart
            $dropdown_cart = view('fontend.compoments.dropdown-cart')->render();

            return response()->json([
                'status' => 'ok',
                'sub_total' => $sub_total,
                'total_price' => $total_price,
                'dropdown_cart' => $dropdown_cart,
                'number_total' => $number_total,
            ]);
        }
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart.index');
    }
}
