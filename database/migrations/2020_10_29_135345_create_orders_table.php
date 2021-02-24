<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->integer('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 10);
            $table->string('address');
            $table->string('note')->nullable();
            $table->integer('total_money')->default(0);
            $table->integer('status')->default(1);
            $table->integer('type_payment')->default(1)->comment('1:Thanh toan tai nha; 2:Thanh toan online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
