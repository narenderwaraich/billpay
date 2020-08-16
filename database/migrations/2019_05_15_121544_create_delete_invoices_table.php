<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('due_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->float('disInFlat')->nullable();
            $table->float('taxInFlat')->nullable();
            $table->float('disInPer')->nullable()->default('0');
            $table->float('taxInPer')->nullable()->default('0');
            $table->string('invoice_number_token', 255)->nullable();
            $table->string('client_id')->nullable();
            $table->string('status', 45)->nullable()->default('DRAFT');
            $table->integer('user_id')->unsigned();
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_card_no', 45)->nullable();
            $table->float('deposit_amount')->default('0');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('discount')->nullable();
            $table->float('tax_rate')->nullable()->default('0');
            $table->float('net_amount')->nullable();
            $table->float('due_amount')->nullable();
            $table->index(["user_id"], 'delete_invoices_user_id_idx');

            $table->foreign('user_id', 'delete_invoices_user_id_idx')
                ->references('id')->on('users')
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
        Schema::dropIfExists('delete_invoices');
    }
}
