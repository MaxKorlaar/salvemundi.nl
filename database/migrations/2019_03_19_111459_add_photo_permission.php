<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
    use Spatie\Permission\Models\Permission;

    /**
     * Class AddPhotoPermission
     */
    class AddPhotoPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        Permission::create(['name' => 'view member photos']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public static function down()
    {
        //
    }
}
