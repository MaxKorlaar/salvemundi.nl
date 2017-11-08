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
                $table->string('pcn')->unique();
                $table->string('name');
                $table->string('address');
                $table->string('city');
                $table->string('postal');
                $table->date('birthday');
                $table->string('phone')->unique();
                $table->string('email')->unique();
                $table->enum('status', ['approved', 'on_hold', 'new', 'denied', 'under_review', 'blocked', 'email_unconfirmed']);
                $table->string('ip_address');
                $table->string('application_hash');
                $table->string('email_confirmation_token');
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
