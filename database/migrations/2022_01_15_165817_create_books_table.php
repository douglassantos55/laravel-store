<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('excerpt');
            $table->string('isbn');
            $table->string('language');
            $table->unsignedDecimal('price');
            $table->unsignedTinyInteger('edition');
            $table->unsignedSmallInteger('pages');
            $table->foreignUuid('author_id')->references('id')->on('authors');
            $table->foreignUuid('publisher_id')->references('id')->on('publishers');
            $table->foreignUuid('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('books');
    }
}
