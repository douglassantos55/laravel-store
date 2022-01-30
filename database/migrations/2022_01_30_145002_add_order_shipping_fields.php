<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderShippingFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
            $table->string('shipping_method')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_service')->nullable();
            $table->string('shipping_company_logo')->nullable();
            $table->unsignedDecimal('shipping_cost', 10, 2)->nullable();
            $table->unsignedTinyInteger('shipping_estimate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_method',
                'shipping_company',
                'shipping_service',
                'shipping_company_logo',
                'shipping_cost',
                'shipping_estimate'
            ]);
        });
    }
}
