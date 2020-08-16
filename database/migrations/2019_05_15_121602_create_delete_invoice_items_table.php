<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delete_invoices_id')->unsigned()->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->mediumText('item_description')->nullable();
            $table->float('qty')->nullable();
            $table->float('rate')->nullable();
            $table->float('total')->nullable();

            $table->index(["delete_invoices_id"], 'delete_invoice_items_delete_invoices_id_idx');


            $table->foreign('delete_invoices_id', 'delete_invoice_items_delete_invoices_id_idx')
                ->references('id')->on('delete_invoices')
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
        Schema::dropIfExists('delete_invoice_items');
    }
}
