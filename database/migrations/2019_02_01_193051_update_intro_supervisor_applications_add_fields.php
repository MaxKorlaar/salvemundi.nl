<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateIntroSupervisorApplicationsAddFields
     */
    class UpdateIntroSupervisorApplicationsAddFields extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('intro_supervisor_applications', function (Blueprint $table) {
                $table->text('motivation');
                $table->string('previously_participated_as');
                $table->string('active_in_association');
                $table->string('first_aid_license')->change();
                $table->string('company_first_response_license')->change();
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
