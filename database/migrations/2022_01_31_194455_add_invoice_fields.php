<?php

use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('total');
            $table->string('invoice_url');
            $table->string('payment_method');
            $table->date('due_date')->nullable();
            $table->decimal('discount')->nullable();

            $table->enum('status', [
                Invoice::STATUS_PAID,
                Invoice::STATUS_PENDING,
                Invoice::STATUS_CANCELED,
                Invoice::STATUS_REFUNDED
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'total',
                'invoice_url',
                'due_date',
                'discount',
                'payment_method',
                'status',
            ]);
        });
    }
}
