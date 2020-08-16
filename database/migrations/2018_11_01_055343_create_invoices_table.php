<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('invoice_number')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('issue_date')->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->string('status', 45)->nullable()->default('DRAFT');
            $table->integer('user_id')->unsigned();
            $table->dateTime('payment_date')->nullable();
            $table->date('deposit_date')->nullable();
            $table->string('payment_mode', 100)->nullable();
            $table->string('payment_status', 100)->nullable();
            $table->float('deposit_amount')->default('0');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('discount')->nullable();
            $table->float('tax_rate')->nullable()->default('0');
            $table->float('net_amount')->nullable();
            $table->float('due_amount')->nullable();
            $table->float('disInPer')->nullable()->default('0');
            $table->float('taxInPer')->nullable()->default('0');
            $table->float('disInFlat')->nullable();
            $table->float('taxInFlat')->nullable();
            $table->date('refund_date')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->string('invoice_number_token', 255)->nullable();
            $table->index(["user_id"], 'invoices_user_id_idx');
            $table->foreign('user_id', 'invoices_user_id_idx')
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
        Schema::dropIfExists('invoices');
    }
}
