<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->collation('utf8_unicode_ci');
            $table->string('first_name',120)->collation('utf8_unicode_ci');
			$table->string('last_name',120)->collation('utf8_unicode_ci');
			$table->string('username',120)->collation('utf8_unicode_ci');
			$table->string('email')->unique()->collation('utf8_unicode_ci');
			$table->string('phone',120)->collation('utf8_unicode_ci');
			$table->string('address',250)->collation('utf8_unicode_ci');
			$table->string('city',60)->collation('utf8_unicode_ci');
			$table->string('state',60)->collation('utf8_unicode_ci');
			$table->string('zip',60)->collation('utf8_unicode_ci');
			$table->integer('confirm')->default('0')->collation('utf8_unicode_ci'); 
            $table->string('password')->collation('utf8_unicode_ci');
            $table->rememberToken()->collation('utf8_unicode_ci');
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
        Schema::dropIfExists('users');
    }
}
