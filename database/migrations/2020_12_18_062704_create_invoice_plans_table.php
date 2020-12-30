<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->nullable();
            $table->float('amount')->default('0');
            $table->string('invoices')->default('0');
            $table->string('access_day')->default('1');
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
        Schema::dropIfExists('invoice_plans');
    }
}
