<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_type', '20')->comment('角色类型索引');
            $table->tinyInteger('vip_level')->comment('付费等级，根据套餐配置匹配对应等级');
            $table->string('role_name', '20')->comment('角色名');
            $table->tinyInteger('organ_id')->unsigned()->default(0)->comment('机构id，默认0时为官方用户');
            $table->timestamps();


            $table->index('role_type');
            $table->index('organ_id');


            $table->engine='InnoDB';
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
