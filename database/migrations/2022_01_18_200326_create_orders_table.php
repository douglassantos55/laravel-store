<?php

use App\Models\Order;
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
            $table->uuid('id')->primary();

            $table->enum('status', [
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_CANCELED,
                Order::STATUS_REFUNDED
            ]);

            $table->string('payment_method');
            $table->string('delivery_method');
            $table->decimal('total');
            $table->decimal('subtotal');
            $table->decimal('discount')->nullable();
            $table->decimal('delivery_cost')->nullable();

            $table->foreignId('customer_id')->references('id')->on('users');
            $table->foreignUuid('voucher_id')->nullable()->references('id')->on('vouchers');

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
