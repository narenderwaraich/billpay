<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name')->unique();
            $table->mediumText('item_description')->nullable();
            $table->float('price')->nullable();
            $table->float('sale')->nullable();
            $table->string('qty')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->integer('user_id')->unsigned();
            $table->index(["user_id"], 'items_user_id_idx');
            $table->foreign('user_id', 'items_user_id_idx')
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
        Schema::dropIfExists('items');
    }
}
