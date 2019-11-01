<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        if (! Schema::hasTable('rbac_apis')) {
            Schema::create('rbac_apis', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->string('path')->comment('api地址');
                $table->char('name', 24)->comment('api名字');
                $table->enum('method', ['PUT','GET','POST','DELETE','ANYWAY'])->comment('允许方法');
                $table->string('module')->comment('api模块');
                $table->string('mark')->comment('api备注');
                $table->tinyInteger('enable')->default(0)->comment('是否允许启用');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }

        // 基础API
        DB::transaction(function () {
            DB::table('rbac_apis')->truncate();
            DB::table('rbac_apis')->insert($this->getApis());
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rbac_apis');
    }

    private function getApis()
    {
        return [
            [
                'id' => 1,
                'path' => 'rbac/api/menu',
                'name' => '获取菜单',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取菜单',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 2,
                'path' => 'rbac/api/menu/*',
                'name' => '获取菜单的子数据',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取菜单的子数据（API等',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 3,
                'path' => 'rbac/api/menu',
                'name' => '添加菜单',
                'method' => 'POST',
                'module' => 'RBAC',
                'mark' => '添加菜单',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 4,
                'path' => 'rbac/api/menu/*',
                'name' => '编辑菜单',
                'method' => 'PUT',
                'module' => 'RBAC',
                'mark' => '编辑菜单',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 5,
                'path' => 'rbac/api/menu/*',
                'name' => '删除菜单',
                'method' => 'DELETE',
                'module' => 'RBAC',
                'mark' => '删除菜单',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 6,
                'path' => 'rbac/api/api',
                'name' => '获取API',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取API（列表',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 7,
                'path' => 'rbac/api/api/*',
                'name' => '获取API的子数据',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取API的子数据（全部等',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 8,
                'path' => 'rbac/api/api',
                'name' => '添加API',
                'method' => 'POST',
                'module' => 'RBAC',
                'mark' => '添加API',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 9,
                'path' => 'rbac/api/api/*',
                'name' => '编辑API',
                'method' => 'PUT',
                'module' => 'RBAC',
                'mark' => '编辑API',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 10,
                'path' => 'rbac/api/api/*',
                'name' => '删除API',
                'method' => 'DELETE',
                'module' => 'RBAC',
                'mark' => '删除API',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 11,
                'path' => 'rbac/api/role',
                'name' => '获取角色',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取角色（列表',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 12,
                'path' => 'rbac/api/role/*',
                'name' => '获取角色的子数据',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取角色的子数据（全部等',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 13,
                'path' => 'rbac/api/role',
                'name' => '添加角色',
                'method' => 'POST',
                'module' => 'RBAC',
                'mark' => '添加角色',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 14,
                'path' => 'rbac/api/role/*',
                'name' => '编辑角色',
                'method' => 'PUT',
                'module' => 'RBAC',
                'mark' => '编辑角色',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 15,
                'path' => 'rbac/api/role/*',
                'name' => '删除角色',
                'method' => 'DELETE',
                'module' => 'RBAC',
                'mark' => '删除角色',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 16,
                'path' => 'rbac/api/user',
                'name' => '获取用户',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取用户（列表',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 17,
                'path' => 'rbac/api/user/*',
                'name' => '获取用户的子数据',
                'method' => 'GET',
                'module' => 'RBAC',
                'mark' => '获取用户的子数据（全部等',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 18,
                'path' => 'rbac/api/user',
                'name' => '添加用户',
                'method' => 'POST',
                'module' => 'RBAC',
                'mark' => '添加用户',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 19,
                'path' => 'rbac/api/user/*',
                'name' => '编辑用户',
                'method' => 'PUT',
                'module' => 'RBAC',
                'mark' => '编辑用户',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 20,
                'path' => 'rbac/api/user/*',
                'name' => '删除用户',
                'method' => 'DELETE',
                'module' => 'RBAC',
                'mark' => '删除用户',
                'enable' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
    }
}
