<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('transaction_id')->nullable();
            $table->string('bank_name')->nullable();  
            $table->string('transaction_status')->default('Pending');
            $table->string('bank_transaction_id')->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->dateTime('payment_date')->nullable();
            $table->index(['user_id'], 'user_payments_user_id_idx');
            $table->foreign('user_id', 'user_payments_user_id_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->index(['invoice_id'], 'user_payments_invoice_id_idx');
            $table->foreign('invoice_id', 'user_payments_invoice_id_idx')
                ->references('id')->on('invoices')
                ->onDelete('no action')
                ->onUpdate('no action');
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
        Schema::dropIfExists('user_payments');
    }
}
