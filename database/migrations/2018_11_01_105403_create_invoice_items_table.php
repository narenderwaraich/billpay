<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->string('item_name')->nullable();
            $table->mediumText('item_description')->nullable();
            $table->float('qty')->nullable();
            $table->float('rate')->nullable();
            $table->float('total')->nullable();

            $table->index(["invoice_id"], 'invoice_items_invoice_id_idx');


            $table->foreign('invoice_id', 'invoice_items_invoice_id_idx')
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
        Schema::dropIfExists('invoice_items');
    }
}
