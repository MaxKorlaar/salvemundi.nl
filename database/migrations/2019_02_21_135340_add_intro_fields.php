<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddIntroFields
     */
    class AddIntroFields extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('intro_applications', function (Blueprint $table) {
                $table->text('allergies')->nullable();
                $table->text('medication')->nullable();
                $table->text('diet_preferences')->nullable();
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
