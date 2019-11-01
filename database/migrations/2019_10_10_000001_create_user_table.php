<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('rbac_user')) {
            Schema::create('rbac_user', function (Blueprint $table) {
                $table->increments('id')->comment('主键ID');
                $table->char('name', 50)->comment('用户名字');
                $table->char('nickname', 50)->default('')->comment('用户昵称');
                $table->char('mobile', 16)->comment('手机号');
                $table->string('email')->default('')->comment('邮箱');
                $table->string('password')->comment('密码');
                $table->string('avatar')->comment('头像');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->softDeletes();
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
        Schema::drop('rbac_user');
    }
}
