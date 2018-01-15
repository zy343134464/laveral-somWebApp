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
            $table->increments('id')->unsigned();
            $table->string('account', 30)->comment('账号');
            $table->string('password', 30)->comment('密码');
            $table->char('name', 10)->default('')->comment('昵称');
            $table->tinyInteger('sex')->unsigned()->default(0)->comment('性别');
            $table->date('birthday')->default('2000-01-01')->comment('生日');
            $table->string('qq', 10)->default('')->comment('qq号');
            $table->string('email')->default('')->comment('邮箱');
            $table->tinyInteger('organ_id')->default(0)->comment('机构id');
            $table->string('role_type', 20)->default('guest')->comment('角色类型，默认guest游客');
            $table->integer('login')->unsigned()->default('0')->comment('登录次数');
            $table->bigInteger('reg_ip')->unsigned()->default('0')->comment('注册IP');
            $table->integer('reg_time')->unsigned()->default('0')->comment('注册时间');
            $table->string('last_login_ip')->unsigned()->default('0')->comment('最后登录IP');
            $table->integer('last_login_time')->unsigned()->default('0')->comment('最后登录时间');
            $table->tinyInteger('vip_level')->unsigned()->default(0)->comment('付费等级 默认0，根据套餐配置匹配对应等级');
            $table->integer('vip_start')->unsigned()->default('0')->comment('付费会员开始时间');
            $table->integer('vip_end')->unsigned()->default('0')->comment('付费会员结束时间');
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
