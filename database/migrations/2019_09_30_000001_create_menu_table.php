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
        if (! Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->unsignedInteger('pid', false)->default(0)->comment('父ID');
                $table->string('url')->default('')->comment('菜单URL');
                $table->char('name', 24)->comment('菜单名字');
                $table->string('path')->comment('菜单的层级关系');
                $table->unsignedTinyInteger('sort', false)->default(0)->comment('排序值');
                $table->unsignedTinyInteger('deep', false)->default(0)->comment('菜单层级');
                $table->unsignedInteger('root_id', false)->comment('根ID');
                $table->char('ico', 32)->default('')->comment('图标');
                $table->unsignedTinyInteger('show', false)->default(1)->comment('是否展示');
                $table->string('remark')->default('')->comment('备注');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
