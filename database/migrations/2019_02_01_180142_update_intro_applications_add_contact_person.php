<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateIntroApplicationsAddContactPerson
     */
    class UpdateIntroApplicationsAddContactPerson extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('intro_applications', function (Blueprint $table) {
                $table->string('contact_name');
                $table->string('contact_relation');
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
