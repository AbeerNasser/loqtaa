<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->text('product');
            $table->string('image')->default('default.png');
            $table->double('price');
            $table->boolean('status')->default(0);
            $table->foreignId('store_id')->nullable()->constrained('stores');
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
        Schema::dropIfExists('offers');
    }
}
