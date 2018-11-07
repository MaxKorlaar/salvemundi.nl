<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddCamps
     */
    class AddCamps extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('camps', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('year_id');
                $table->date('signup_open');
                $table->date('signup_close');
                $table->timestamps();
                $table->float('price');
            });
            Schema::table('camping_applications', function (Blueprint $table) {
                $table->unsignedInteger('camp_id')->nullable();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('camps');
        }
    }
