<?php

use Illuminate\Support\Facades\DB;
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
            $table->bigIncrements('id');
            $table->string('account',16)->comment('账号');
            $table->string('password')->comment('密码');
            $table->TinyInteger('role')->comment('身份，0超级管理员，1机构，2医生，3普通会员');
            $table->rememberToken();
            $table->TinyInteger('status')->default(1)->comment('冻结 1 正常 0 冻结');
            $table->nullableTimestamps();
        });
        DB::statement("ALTER TABLE `users` comment '用户表'");
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
