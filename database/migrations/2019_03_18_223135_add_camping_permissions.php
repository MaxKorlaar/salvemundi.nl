<?php

    use Illuminate\Database\Migrations\Migration;
    use Spatie\Permission\Models\Permission;

    /**
     * Class AddCampingPermissions
     */
    class AddCampingPermissions extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public static function up() {
            Permission::create(['name' => 'view camps']);
            Permission::create(['name' => 'edit camps']);
            Permission::create(['name' => 'delete camps']);
            Permission::create(['name' => 'view camp signups']);
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public static function down() {
            //
        }
    }
