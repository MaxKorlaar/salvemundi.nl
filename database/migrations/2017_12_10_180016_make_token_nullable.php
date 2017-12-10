<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class MakeTokenNullable
     */
    class MakeTokenNullable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         * @throws \Doctrine\DBAL\DBALException
         */
        public function up() {
            // Dit is een fix voor een probleem met de database classes die foutmeldingen geven als we iets willen veranderen aan deze table.
            // Deze table heeft namelijk een kolom met het type 'enum' en hij gaat er nogal slecht mee om als we ook maar iets willen veranderen aan de hele tabel!
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            Schema::table('member_applications', function (Blueprint $table) {
                $table->string('email_confirmation_token')->nullable()->change();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            //
        }
    }
