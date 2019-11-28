<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('rbac_roles')) {
            Schema::create('rbac_roles', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->char('name', 24)->comment('菜单名字');
                $table->tinyInteger('level')->default(1)->comment('角色层级');
                $table->string('mark')->default('')->comment('备注');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }

        DB::table('rbac_roles')->truncate();
        DB::table('rbac_roles')->insert($this->getRoles());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rbac_roles');
    }

    public function getRoles()
    {
        return [
            [
                'id'   => 1,
                'name' => '系统管理员',
                'level' => 1,
                'mark' => '系统管理员',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
    }
}
