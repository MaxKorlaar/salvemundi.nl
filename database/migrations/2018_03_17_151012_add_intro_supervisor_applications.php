<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddIntroSupervisorApplications
     */
    class AddIntroSupervisorApplications extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('intro_supervisor_applications', function (Blueprint $table) {
                $table->increments('id');
                $table->string('member_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone');
                $table->string('email');
                $table->string('age_at_intro');
                $table->string('shirt_size');
                $table->string('preferred_partner_id')->nullable();
                $table->string('route_type');
                $table->boolean('remain_sober');
                $table->boolean('drivers_license');
                $table->boolean('first_aid_license');
                $table->boolean('company_first_response_license');
                $table->text('remarks')->nullable();
                $table->string('status');
                $table->string('ip_address');
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
            Schema::dropIfExists('intro_supervisor_applications');
        }
    }
