<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddMembershipYear
     */
    class AddMembershipYear extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('years', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('year');
                $table->unsignedInteger('last_member_id')->default(1);
                $table->timestamps();
                $table->index(['year']);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('years');
        }
    }
