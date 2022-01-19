<?php

use App\Models\Voucher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->date('expires_at')->nullable();
            $table->unsignedTinyInteger('discount');
            $table->unsignedInteger('usages')->default(0);
            $table->unsignedInteger('max_usages')->nullable();
            $table->enum('type', [Voucher::TYPE_FIXED, Voucher::TYPE_PERCENT]);
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
        Schema::dropIfExists('vouchers');
    }
}
