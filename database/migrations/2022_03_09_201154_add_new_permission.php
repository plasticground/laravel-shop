<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = \Spatie\Permission\Models\Permission::findOrCreate('adminAccess');
        \Spatie\Permission\Models\Role::findByName('admin')->givePermissionTo($permission);
        \Spatie\Permission\Models\Role::findByName('manager')->givePermissionTo($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Spatie\Permission\Models\Permission::findByName('adminAccess')->delete();
    }
}
