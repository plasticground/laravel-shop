<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /** @var array|string[]  */
    private array $permissions = [
        'orders@index',
        'orders@show',
        'orders@moderate',
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

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->default(DB::raw('(UUID())'));
            $table->string('state')->default(\App\Models\Order::STATE_ANEW);
            $table->foreignId('manager_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('customer_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_phone');
            $table->mediumText('comment')->nullable();
            $table->timestamp(\App\Models\Order::APPROVED_AT)->nullable();
            $table->timestamp(\App\Models\Order::REJECTED_AT)->nullable();
            $table->timestamps();

            $table->index(['state']);
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->uuid('order_uuid');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('count');
            $table->unsignedDouble('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Spatie\Permission\Models\Permission::whereIn('name', $this->permissions)->delete();

        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('manager_id');
            $table->dropConstrainedForeignId('customer_id');
        });

        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
    }
}
