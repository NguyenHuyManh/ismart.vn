<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public function customer()
	{
		return $this->belongsTo(Customer::class, 'customer_id');
	}

	public function order_details()
	{
		return $this->hasMany(Order_detail::class, 'order_id');
	}

    public function getTypePaymentAttribute($value)
    {
    	return $value === 1 ? 'Thanh toán tại nhà' : 'Thanh toán online';
    }    
}
