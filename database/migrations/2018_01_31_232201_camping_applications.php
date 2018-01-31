<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class CampingApplications
     */
    class CampingApplications extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('camping_applications', function (Blueprint $table) {
                $table->increments('id');
                $table->string('pcn')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone')->unique();
                $table->string('email')->unique();
                $table->enum('status', ['approved', 'on_hold', 'new', 'denied', 'under_review', 'blocked', 'email_unconfirmed']);
                $table->string('ip_address');
                $table->string('application_hash');
                $table->string('email_confirmation_token')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('camping_applications');
        }
    }
