<?php

use Illuminate\Database\Migrations\Migration;

class AddStatisticsPermissions extends Migration
{
    /** @var array|string[]  */
    private array $permissions = [
        'statistics@index'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [];

        foreach ($this->permissions as $permission) {
            $permissions[] = \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        \Spatie\Permission\Models\Role::findByName('admin')->givePermissionTo($permissions);
        \Spatie\Permission\Models\Role::findByName('manager')->givePermissionTo($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Spatie\Permission\Models\Permission::whereIn('name', $this->permissions)->delete();
    }
}
