<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingcartTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('cart.database.table.cart'), function (Blueprint $table) {
            $table->string('identifier');
            $table->string('instance');
            $table->longText('content');
            $table->nullableTimestamps();

            $table->primary(['identifier', 'instance']);
        });
		
		Schema::create(config('cart.database.table.coupon'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->enum('type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('uses')->nullable();
            $table->decimal('min_cart_total')->nullable();
            $table->decimal('max_discount_value')->nullable();
            $table->string('value');
            $table->dateTime('start')->nullable();
            $table->dateTime('expiry')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('cart.database.table.cart'));
        Schema::drop(config('cart.database.table.coupon'));
    }
}
