<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

    /**
     * Class UpdateCampingApplicationsRemoveHash
     */
    class UpdateCampingApplicationsRemoveHash extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         * @throws \Doctrine\DBAL\DBALException
         */
    public function up()
    {
        // Dit is een fix voor een probleem met de database classes die foutmeldingen geven als we iets willen veranderen aan deze table.
        // Deze table heeft namelijk een kolom met het type 'enum' en hij gaat er nogal slecht mee om als we ook maar iets willen veranderen aan de hele tabel!
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('camping_applications', function (Blueprint $table) {
            $table->dropColumn('application_hash');
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
