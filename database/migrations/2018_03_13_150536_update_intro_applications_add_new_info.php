<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

    /**
     * Class UpdateIntroApplicationsAddNewInfo
     */
    class UpdateIntroApplicationsAddNewInfo extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         * @throws \Doctrine\DBAL\DBALException
         */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('intro_applications', function (Blueprint $table) {
            $table->string('contact_phone');
            $table->string('gender');
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
