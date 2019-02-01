<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateSupervisorApplications
     */
    class UpdateSupervisorApplications extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('intro_supervisor_applications', function (Blueprint $table) {
                $table->dropColumn('member_id');
                $table->dropColumn('status');
                $table->dropColumn('first_name');
                $table->dropColumn('last_name');
                $table->dropColumn('phone');
                $table->dropColumn('email');
            });
            Schema::table('intro_supervisor_applications', function (Blueprint $table) {
                $table->unsignedInteger('introduction_id')->nullable();
                $table->unsignedInteger('member_id')->nullable();
                $table->string('status')->default('email_unconfirmed');
                $table->string('type')->default('signup');
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
