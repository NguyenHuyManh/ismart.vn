<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProPayToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('pro_pay')->after('highlight')->default(0);
            $table->string('meta_title')->after('pro_pay')->nullable();
            $table->string('meta_desc')->after('meta_title')->nullable();
            $table->string('meta_keyword')->after('meta_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_desc');
            $table->dropColumn('meta_keyword');
            $table->dropColumn('pro_pay');
        });
    }
}
