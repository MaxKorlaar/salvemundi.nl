<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

    /**
     * Class UpdateColumnSize
     */
    class UpdateColumnSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('family_name', 300)->change();
            $table->string('given_name', 300)->change();
            $table->string('official_name', 300)->change();
            $table->string('email', 300)->change();
        });
        Schema::table('members', function (Blueprint $table) {
            $table->string('first_name', 300)->change();
            $table->string('last_name', 300)->change();
            $table->string('address', 300)->change();
            $table->string('email', 300)->change();
            $table->string('city', 300)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
