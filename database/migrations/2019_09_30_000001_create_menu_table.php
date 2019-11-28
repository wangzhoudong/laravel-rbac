<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('rbac_menus')) {
            Schema::create('rbac_menus', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->unsignedInteger('pid', false)->default(0)->comment('父ID');
                $table->string('url')->default('')->comment('菜单URL');
                $table->char('name', 24)->comment('菜单名字');
                $table->string('path')->default('')->comment('菜单的层级关系');
                $table->unsignedTinyInteger('sort', false)->default(0)->comment('排序值');
                $table->unsignedTinyInteger('deep', false)->default(0)->comment('菜单层级');
                $table->unsignedInteger('root_id', false)->default(0)->comment('根ID');
                $table->char('ico', 32)->default('')->comment('图标');
                $table->unsignedTinyInteger('show', false)->default(1)->comment('是否展示');
                $table->string('remark')->default('')->comment('备注');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }

        DB::table('rbac_menus')->truncate();
        DB::table('rbac_menus')->insert($this->getMenus());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rbac_menus');
    }

    private function getMenus()
    {
        return [
            [
                'id' => '1',
                'pid' => '0',
                'url' => '',
                'name' => '权限管理',
                'path' => '1',
                'sort' => '0',
                'deep' => '0',
                'root_id' => '1',
                'ico' => 'tree',
                'show' => '1',
                'remark' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => '2',
                'pid' => '1',
                'url' => '/rbac/menu',
                'name' => '菜单管理',
                'path' => '1,2',
                'sort' => '0',
                'deep' => '0',
                'root_id' => '1',
                'ico' => 'tree',
                'show' => '1',
                'remark' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => '3',
                'pid' => '1',
                'url' => '/rbac/api',
                'name' => 'API管理',
                'path' => '1,3',
                'sort' => '0',
                'deep' => '0',
                'root_id' => '1',
                'ico' => 'table',
                'show' => '1',
                'remark' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => '4',
                'pid' => '1',
                'url' => '/rbac/role',
                'name' => '角色管理',
                'path' => '1,4',
                'sort' => '0',
                'deep' => '0',
                'root_id' => '1',
                'ico' => 'table',
                'show' => '1',
                'remark' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => '5',
                'pid' => '1',
                'url' => '/rbac/user',
                'name' => '用户管理',
                'path' => '1,5',
                'sort' => '0',
                'deep' => '0',
                'root_id' => '1',
                'ico' => 'table',
                'show' => '1',
                'remark' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
    }
}
