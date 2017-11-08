<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    /**
     * Class AddApplications
     */
    class AddApplications extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('member_applications', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pcn')->unique();
                $table->string('name');
                $table->string('address');
                $table->string('city');
                $table->string('postal');
                $table->date('birthday');
                $table->string('phone');
                $table->string('email')->unique();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('member_applications');
        }
    }
