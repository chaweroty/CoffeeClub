<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->text('preferences');
            $table->date('start_date');
            $table->foreignId('product_car_id'); 
            $table->foreignId('method_of_payment_id'); 
            $table->timestamps();

            $table->foreign('product_car_id')->references('id')->on('product_cart')->onDelete('cascade');
            $table->foreign('method_of_payment_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};