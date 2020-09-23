<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('fname', 45)->nullable();
            $table->string('lname', 45)->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('address', 45)->nullable();
            $table->string('country', 45)->nullable();
            $table->string('state', 45)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('zipcode', 100)->nullable();
            $table->string('role', 20)->default('user');
            $table->string('type', 50)->nullable();
            $table->boolean('is_activated')->default(false);
            $table->boolean('suspend')->default(false);
            $table->string('password')->nullable();
            $table->string('phone_no', 45)->nullable();
             $table->string('account_type', 100)->nullable();
            $table->string('cin_number', 100)->nullable();
            $table->string('gstin_number', 100)->nullable();
            $table->string('company_name', 45)->nullable();
            $table->dateTime('access_date')->nullable();
            $table->string('token')->nullable();
             $table->string('remember_token')->nullable();
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
