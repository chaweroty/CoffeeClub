<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('flavor');
            $table->string('preparation_method');
            $table->double('price');
            $table->string('region');
            $table->integer('quantity')->default(1);
            $table->foreignId('producer_id')->nullable(); 
            $table->foreign('producer_id')->references('id')->on('producers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}