<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_infos', function (Blueprint $table) {
            $table->bigIncrements('e_id');
            $table->unsignedBigInteger('user_id')->unique()->comment('用户id');
            $table->string('true_name', 64)->nullable()->comment('用户姓名');
            $table->string('phone', 16)->nullable()->comment('手机号码');
            $table->text('description')->nullable()->comment('个人简介');
            $table->string('nation', 100)->nullable()->comment('民族');
            $table->string('avatar', 200)->nullable()->comment('头像');
            $table->dateTime('birthday_at')->nullable()->comment('出生年月');
            $table->string('card_no')->nullable()->comment('身份证号码');
            $table->string('address')->nullable()->comment('地址');
            $table->string('company_id')->nullable()->comment('公司id');
            $table->string('position')->nullable()->comment('职位');
            $table->string('department')->nullable()->comment('部门');
            $table->string('email', 32)->nullable()->comment('邮箱');
            $table->string('qq', 16)->nullable()->comment('qq号码');
            $table->string('wechat', 32)->nullable()->comment('微信号码');
            $table->nullableTimestamps();
        });

        DB::statement("ALTER TABLE `user_infos` comment '公司职员信息表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_infos');
    }
}