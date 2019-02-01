<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddIntroductions
     */
    class AddIntroductions extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('introductions', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('year_id');
                $table->date('reservations_open');
                $table->date('signup_open');
                $table->date('signup_close');
                $table->date('mail_reservations_at')->nullable();
                $table->timestamps();
                $table->float('price');
                $table->unsignedInteger('max_signups');
                $table->boolean('allow_reservations_after_limit');
            });
            Schema::table('intro_applications', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->dropColumn('transaction_status');
                $table->dropColumn('transaction_amount');
            });
            Schema::table('intro_applications', function (Blueprint $table) {
                $table->unsignedInteger('introduction_id')->nullable();
                $table->unsignedInteger('transaction_id')->change();
                $table->string('type')->default('reservation');
                $table->string('status')->default('email_unconfirmed');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('introductions');
        }
    }
