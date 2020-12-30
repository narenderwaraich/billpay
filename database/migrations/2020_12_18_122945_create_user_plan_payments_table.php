<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPlanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plan_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('plan_id')->unsigned()->nullable();
            $table->string('transaction_status')->default('Pending');
            $table->dateTime('transaction_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('user_id')->unsigned();
            $table->index(['user_id'], 'user_plan_payments_user_id_idx');
            $table->foreign('user_id', 'user_plan_payments_user_id_idx')
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
        Schema::dropIfExists('user_plan_payments');
    }
}
