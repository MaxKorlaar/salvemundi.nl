<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class MakeHashUnique
     */
    class MakeHashUnique extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('member_applications', function (Blueprint $table) {
                $table->unique('application_hash');
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
