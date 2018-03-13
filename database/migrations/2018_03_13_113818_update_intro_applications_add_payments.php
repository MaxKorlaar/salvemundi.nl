<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateIntroApplicationsAddPayments
     */
    class UpdateIntroApplicationsAddPayments extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         * @throws \Doctrine\DBAL\DBALException
         */
        public function up() {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            Schema::table('intro_applications', function (Blueprint $table) {
                //$table->string('transaction_id');
                $table->string('transaction_status');
                $table->float('transaction_amount');
                //$table->dropColumn('application_hash');
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
