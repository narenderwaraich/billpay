<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invoice_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_due_days')->nullable();
            $table->text('invoice_terms')->nullable();
            $table->boolean('logo')->default(false);
            $table->boolean('logo_left')->default(false);
            $table->boolean('logo_center')->default(false);
            $table->boolean('logo_right')->default(false);
            $table->boolean('logo_bg')->default(false);
            $table->string('logo_opacity')->nullable();
            $table->string('logo_hight')->nullable();
            $table->string('logo_width')->nullable();
            $table->string('invoice_font_size')->nullable();
            $table->string('invoice_font_weight')->nullable();
            $table->string('invoice_font_size_1')->nullable();
            $table->string('invoice_font_size_2')->nullable();
            $table->string('invoice_font_size_3')->nullable();
            $table->string('invoice_font_weight_1')->nullable();
            $table->string('invoice_font_weight_2')->nullable();
            $table->string('invoice_heading_title_color')->nullable();
            $table->string('invoice_heading_date_color')->nullable();
            $table->string('invoice_heading_email_color')->nullable();
            $table->string('invoice_heading_gst_color')->nullable();
            $table->string('setPaper')->default('A4');
            $table->integer('user_id')->unsigned();
            $table->index(["user_id"], 'user_invoice_settings_user_id_idx');
            $table->foreign('user_id', 'user_invoice_settings_user_id_idx')
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
        Schema::dropIfExists('user_invoice_settings');
    }
}
