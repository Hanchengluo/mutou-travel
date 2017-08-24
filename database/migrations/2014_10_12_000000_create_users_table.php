<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('name')->unique()->comment('用户名/昵称');
            $table->string('phone')->unique()->nullable()->comment('手机号码');
            $table->string('email')->unique()->comment('电子邮箱');
            $table->string('password')->comment('登录密码');
            $table->text('avatar')->nullable()->comment('头像地址');
            $table->tinyInteger('status')->default(1)->comment('用户状态,0:禁用,1:启用');
            $table->tinyInteger('is_admin')->default(0)->comment('是否为管理员,0:否,1:是');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
