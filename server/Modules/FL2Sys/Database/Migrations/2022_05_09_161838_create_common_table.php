<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-05-09 16:18:38
 * @LastEditTime: 2022-07-18 10:11:49
 * @Description: 
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_class', function (Blueprint $table) {
            $table->comment = '班组表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('班组ID');
            $table->string('model_name', 10)->comment('产线代号');
            $table->string('class_name', 10)->comment('班组名称');
            $table->timestamps();
        });
        Schema::create('common_faults', function (Blueprint $table) {
            $table->comment = '故障停机表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('故障ID');
            $table->string('module_name', 20)->comment('产线名称');
            $table->string('content')->default('')->comment('故障描述');
            $table->string('duration')->comment('停机时间');
            $table->timestamp('end_at')->nullable()->comment('结束时间');
            $table->timestamps();
        });
        Schema::create('common_connects', function (Blueprint $table) {
            $table->comment = '连接记录表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('故障ID');
            $table->string('connect_name', 20)->default('')->comment('连接名称');
            $table->ipAddress('ip_no')->default('')->comment('ip来源');
            $table->string('port_no')->default('')->comment('端口号');
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
        Schema::dropIfExists('common_class');
        Schema::dropIfExists('common_fault');
        Schema::dropIfExists('common_trace');
    }
}
