<?php
/*
 * @Name: 
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-05 11:34:56
 * @LastEditTime: 2022-07-12 10:50:56
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_main_plans', function (Blueprint $table) {
            $table->comment = '8K计划主表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('计划ID');
            $table->integer('sort')->default('0')->comment('排序');
            $table->integer('formula_id')->default(0)->comment('配方id');
            $table->integer('branch_id')->comment('副表id');
            $table->tinyInteger('status')->default(0)->comment('状态:0=未生产,1=在生产,2=已完成');
            $table->string('PLAN_NO', 10)->default('')->comment('1计划号');
            $table->string('PLAN_TYPE', 1)->default('')->comment('4计划类型-0:正常计划,1:返修计划');
            $table->string('FINAL_COIL_FLAG', 1)->default('')->comment('5最终卷标记-0:分卷,1:最终卷');
            $table->string('IN_MAT_NO', 20)->default('')->comment('9入口钢卷号');
            $table->string('OUT_MAT_NO', 20)->default('')->comment('出口钢卷号');
            $table->string('IN_MAT_THICK', 6)->default('')->comment('11入口钢卷厚度mm');
            $table->string('IN_MAT_WIDTH', 7)->default('')->comment('12入口钢卷宽度mm');
            $table->string('IN_MAT_WT', 20)->default('')->comment('13入口钢卷重量t');
            $table->string('IN_MAT_LEN', 9)->default('')->comment('14入口钢卷长度m');
            $table->string('IN_MAT_IN_DIA', 6)->default('')->comment('15入口钢卷内径mm');
            $table->string('IN_MAT_DIA', 6)->default('')->comment('16入口钢卷外径mm');
            $table->string('SG_SIGN', 30)->default('')->comment('19入料钢卷钢种');
            $table->string('FILM_TYPE_CODE', 4)->default('')->comment('30覆膜方式代码');
            $table->string('FILM_KIND_CODE', 4)->default('')->comment('31覆膜种类代码');
            $table->string('FILM_THICK', 6)->default('')->comment('32覆膜厚度');
            $table->string('DIVIDE_WT', 6)->default('')->comment('47分卷重量');
            $table->timestamps();
            // $table->string('DIVIDE_TYPE', 1)->default('0')->comment('43分切类型-0:不分切,1:均分,2:自定义分切');
            // $table->string('DIVIDE_NUM', 1)->default('')->comment('44分切数量');
            // $table->string('DIVIDE_WT_1', 6)->default('')->comment('47分卷重量1');
            // $table->string('DIVIDE_WT_2', 6)->default('')->comment('48分卷重量2');
            // $table->string('DIVIDE_WT_3', 6)->default('')->comment('49分卷重量3');
            // $table->string('DIVIDE_WT_4', 6)->default('')->comment('50分卷重量4');
            // $table->string('DIVIDE_WT_5', 6)->default('')->comment('51分卷重量5');
        });

        Schema::create('f_branch_plans', function (Blueprint $table) {
            $table->comment = '8K计划副表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('计划ID');
            $table->string('SEQ_NO', 3)->default('')->comment('2序号');
            $table->string('UNIT_CODE', 4)->default('')->comment('3机组代码');
            $table->string('IN_MAT_KIND', 2)->default('')->comment('6入口物料种类-热卷来源,热轧:HR,外购:WG');
            $table->string('STOCK_CODE', 3)->default('')->comment('7库区代码');
            $table->string('LOCATION_NO', 15)->default('')->comment('8库位号');
            $table->string('ORIGIN_MAT_NO', 20)->default('')->comment('10外购钢卷号');
            $table->string('IN_MAT_SLEEVE_FLAG', 1)->default('')->comment('17入口钢卷套筒标记-0:无,1:有');
            $table->string('IN_MAT_SLEEVE_TYPE', 1)->default('')->comment('18入口钢卷套筒类型-N:无,Z: 纸套筒,C: 单轧钢套筒,W: 连轧钢套筒  L：六连轧钢套筒');
            $table->string('SG_STD', 30)->default('')->comment('20入料钢卷标准');
            $table->string('IN_MAT_TYPE', 1)->default('')->comment('21入口钢卷类型-0:虚拟钢卷,1:实物钢卷');
            $table->string('OUT_MAT_TARG_THICK', 6)->default('')->comment('22出口钢卷目标厚度');
            $table->string('ORDER_THICK', 7)->default('')->comment('23订货厚度');
            $table->string('OUT_THICK_TOL_MINUS', 4)->default('')->comment('24出口厚度负公差');
            $table->string('OUT_THICK_TOL_PLUS', 4)->default('')->comment('25出口厚度正公差');
            $table->string('OUT_MAT_TARG_WIDTH', 5)->default('')->comment('26出口钢卷目标宽度');
            $table->string('ORDER_WIDTH', 7)->default('')->comment('27订货宽度');
            $table->string('OUT_WIDTH_TOL_MINUS', 5)->default('')->comment('28出口宽度负公差');
            $table->string('OUT_WIDTH_TOL_PLUS', 5)->default('')->comment('29出口宽度正公差');
            $table->string('SURFACE_STRUCT_CODE', 2)->default('')->comment('33目标表面结构-H:H,D: NO.2D,B: NO.2B,N: NO.1,E: NO.2E,F:NO.8');
            $table->string('ROUGH', 5)->default('')->comment('34粗糙度');
            $table->string('SMOOTH', 5)->default('')->comment('35光洁度');
            $table->string('ORIGIN_CODE', 4)->default('')->comment('36来源代码');
            $table->string('DEST_CODE', 4)->default('')->comment('37去向代码');
            $table->string('PONO_NO', 10)->default('')->comment('38炉号');
            $table->string('SALE_ORDER_SUB_NO', 14)->default('')->comment('39销售订单子项号');
            $table->string('APN', 4)->default('')->comment('40产品最终用途码');
            $table->string('DELIVY_DATE', 14)->default('')->comment('41交货日期');
            $table->string('BASELEVEL_DIRECTION', 1)->default('0')->comment('42基准面朝向-0:好面向上,1:好面向下,2:双面保证');
            $table->string('ORD_UNIT_WT_MAX', 6)->default('')->comment('45单卷重量最大值');
            $table->string('ORD_UNIT_WT_MIN', 6)->default('')->comment('46单卷重量最小值');
            $table->string('BACK_COL_1', 10)->default('')->comment('52预留1');
            $table->string('SPARE_2', 20)->default('')->comment('53预留2');
            $table->string('SPARE_3', 20)->default('')->comment('54预留3');
            $table->string('SPARE_4', 20)->default('')->comment('55预留4');
            $table->timestamps();
        });
        Schema::create('f_l2toplcs', function (Blueprint $table) {
            $table->comment = '8Kl2toplc数据交互表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->string('IN_MAT_NO')->default('0')->comment('入口钢卷号');
            $table->string('IN_MAT_THICK')->default('0')->comment('入口钢卷厚度mm');
            $table->string('IN_MAT_WIDTH')->default('0')->comment('入口钢卷宽度mm');
            $table->string('IN_MAT_WT')->default('0')->comment('入口钢卷重量');
            $table->string('IN_MAT_LEN')->default('0')->comment('入口钢卷长度');
            $table->string('OUT_MAT_NO')->default('0')->comment('出口钢卷号');
            $table->string('DIVIDE_WT')->default('0')->comment('出口钢卷分卷重量');
            $table->string('FILM_KIND_CODE')->default('0')->comment('覆膜种类代码');
        });

        Schema::create('f_plctol2s', function (Blueprint $table) {
            $table->comment = '8Kplctol2数据交互表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->string('IN_MAT_NO')->default('0')->comment('入口钢卷号');
            $table->string('OUT_MAT_NO')->default('0')->comment('出口钢卷号');
            $table->float('OUT_MAT_THEORY_WT')->default('0')->comment('出口钢卷理论重量');
            $table->float('PRODUCTION')->default('0')->comment('工艺实绩');
            $table->boolean('COMPLETE')->default('0')->comment('完成标志位');
            $table->boolean('STATUS')->default('0')->comment('信号来源标志位');
            $table->boolean('STOP')->default('1')->comment('停机标志位');
        });
        Schema::create('f_formulas', function (Blueprint $table) {
            $table->comment = '8K配方表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('计划ID');
            $table->string('IN_MAT_NO')->default('0')->comment('入口钢卷号');
            $table->string('OUT_MAT_NO')->default('0')->comment('出口钢卷号');
            $table->float('OUT_MAT_THEORY_WT')->default('0')->comment('出口钢卷理论重量');
            $table->boolean('IN_MAT_TYPE')->default('0')->comment('入口钢卷类型-0:虚拟钢卷,1:实物钢卷');
            $table->boolean('LOCK')->default('0')->comment('已下卷标志位');
            $table->boolean('STATUS')->default('0')->comment('停机标志位');
        });
        Schema::create('f_productions', function (Blueprint $table) {
            $table->comment = '8K生产实绩表';
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->string('PLAN_NO', 10)->default('')->comment('计划号');
            $table->string('IN_MAT_NO')->default('0')->comment('入口钢卷号');
            $table->string('OUT_MAT_NO')->default('0')->comment('出口钢卷号');
            $table->string('formulas_id')->default('0')->comment('配方号');
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
        Schema::dropIfExists('f_main_plans');
        Schema::dropIfExists('f_branch_plans');
        Schema::dropIfExists('f_l2toplcs');
        Schema::dropIfExists('f_plctol2s');
        Schema::dropIfExists('f_formulas');
        Schema::dropIfExists('f_productions');
    }
}
