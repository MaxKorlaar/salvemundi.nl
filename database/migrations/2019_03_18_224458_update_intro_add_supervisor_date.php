<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    /**
     * Class UpdateIntroAddSupervisorDate
     */
    class UpdateIntroAddSupervisorDate extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public static function up() {
            Schema::table('introductions', function (Blueprint $table) {
                $table->date('supervisor_signup_close')->default('2019-01-01');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public static function down() {
            //
        }
    }
