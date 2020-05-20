<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('company_name')->nullable()->comment('公司名称');
            $table->text('description')->nullable()->comment('公司简介');
            $table->string('license_number', 20)->nullable()->comment('社会统一信用代码');
            $table->string('license_pic')->nullable()->comment('营业执照复印件');
            $table->string('contact_name', 32)->nullable()->comment('联系人姓名');
            $table->string('phone')->nullable()->comment('联系人电话');
            $table->string('address')->nullable()->comment('公司地址');
            $table->unsignedTinyInteger('audit_status')->default(1)->comment('状态：0，审核失败 1，待审核，2，审核通过，3，未提交审核');
            $table->string('reason')->nullable()->comment('审核通过不通过的理由');
            $table->dateTime('pass_at')->nullable()->comment('审核通过时间');
            $table->nullableTimestamps();
        });

        DB::statement("ALTER TABLE `company_infos` comment '机构信息表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_infos');
    }
}
