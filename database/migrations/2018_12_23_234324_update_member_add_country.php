<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateMemberAddCountry
     */
    class UpdateMemberAddCountry extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('members', function (Blueprint $table) {
                $table->string('country', 300)->nullable();
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
