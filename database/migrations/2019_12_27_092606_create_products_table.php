<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->decimal('discount_price', 10, 2)->default(0)->nullable();
            $table->integer('parentcategory_id')->unsigned();
            $table->integer('childcategory_id')->unsigned()->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->enum('is_featured',['yes','no'])->nullable();
            $table->enum('is_discountable',['yes','no'])->nullable();
            $table->enum('is_trending',['yes','no'])->nullable();
            $table->decimal('tax_percent', 10, 2)->default(0)->nullable();
            $table->longText('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumb_image')->nullable();
            $table->foreign('parentcategory_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('childcategory_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
