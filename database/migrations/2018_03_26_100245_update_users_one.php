<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class UpdateUsersOne
     */
    class UpdateUsersOne extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('name', 'username');
                $table->string('password')->nullable()->change();
                $table->string('family_name');
                $table->string('given_name');
                $table->string('official_name');
                $table->unsignedInteger('member_id');
                $table->index('member_id');
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
