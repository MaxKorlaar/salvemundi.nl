<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

    /**
     * Class UpdateIntroApplicationsAddAddress
     */
    class UpdateIntroApplicationsAddAddress extends Migration
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
            $table->string('address');
            $table->string('city');
            $table->string('postal');
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
