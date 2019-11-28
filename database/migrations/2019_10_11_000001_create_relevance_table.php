<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelevanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rbac_menu_api')) {
            Schema::create('rbac_menu_api', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->integer('menu_id');
                $table->integer('api_id');
            });
        }

        if (!Schema::hasTable('rbac_role_menu')) {
            Schema::create('rbac_role_menu', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->integer('role_id');
                $table->integer('menu_id');
            });
        }

        if (!Schema::hasTable('rbac_user_role')) {
            Schema::create('rbac_user_role', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->integer('user_id');
                $table->integer('role_id');
            });
        }

        DB::transaction(function () {
            DB::table('rbac_menu_api')->truncate();
            DB::table('rbac_role_menu')->truncate();

            DB::table('rbac_menu_api')->insert($this->getMenuApis());
            DB::table('rbac_role_menu')->insert($this->getRoleMenus());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rbac_menu_api');
        Schema::drop('rbac_role_menu');
        Schema::drop('rbac_user_role');
    }

    private function getMenuApis()
    {
        return [
            [
                'menu_id' => '2',
                'api_id' => '1',
            ], [
                'menu_id' => '2',
                'api_id' => '2',
            ], [
                'menu_id' => '2',
                'api_id' => '3',
            ], [
                'menu_id' => '2',
                'api_id' => '4',
            ], [
                'menu_id' => '2',
                'api_id' => '5',
            ], [
                'menu_id' => '3',
                'api_id' => '6',
            ], [
                'menu_id' => '3',
                'api_id' => '7',
            ], [
                'menu_id' => '3',
                'api_id' => '8',
            ], [
                'menu_id' => '3',
                'api_id' => '9',
            ], [
                'menu_id' => '3',
                'api_id' => '10',
            ], [
                'menu_id' => '4',
                'api_id' => '11',
            ], [
                'menu_id' => '4',
                'api_id' => '12',
            ], [
                'menu_id' => '4',
                'api_id' => '13',
            ], [
                'menu_id' => '4',
                'api_id' => '14',
            ], [
                'menu_id' => '4',
                'api_id' => '15',
            ], [
                'menu_id' => '5',
                'api_id' => '16',
            ], [
                'menu_id' => '5',
                'api_id' => '17',
            ], [
                'menu_id' => '5',
                'api_id' => '18',
            ], [
                'menu_id' => '5',
                'api_id' => '19',
            ], [
                'menu_id' => '5',
                'api_id' => '20',
            ],
        ];
    }

    private function getRoleMenus()
    {
        return [
            [
                'menu_id' => '2',
                'role_id' => '1',
            ], [
                'menu_id' => '3',
                'role_id' => '1',
            ], [
                'menu_id' => '4',
                'role_id' => '1',
            ], [
                'menu_id' => '5',
                'role_id' => '1',
            ],
        ];
    }
}
