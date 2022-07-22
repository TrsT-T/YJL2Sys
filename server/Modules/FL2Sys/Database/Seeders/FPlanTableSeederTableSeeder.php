<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-08 16:44:10
 * @LastEditTime: 2022-07-18 10:15:18
 * @Description: 
 */

namespace Modules\FL2Sys\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FPlanTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /****************************班组表初始化******************************************/
        DB::table('common_class')->insertGetId([
            'model_name' => 'F',
            'class_name' => 'A',
        ]);
        /****************************故障表初始化******************************************/
        DB::table('common_faults')->insertGetId([
            'module_name' => 'F',
            'content' => '故障',
            'duration' => '故障',
            'end_at' => date('Y-m-d H:i:s')
        ]);
        /****************************plctol2初始化******************************************/
        DB::table('f_plctol2s')->insertGetId([]);
        /****************************l2toplc初始化******************************************/
        DB::table('f_l2toplcs')->insertGetId([]);
        /****************************计划管理（权限1）******************************************/
        DB::table('f_main_plans')->insertGetId([
            'sort' => 1,
            'PLAN_NO' => '0000000001',
            'branch_id' => '1',
            'IN_MAT_NO' => 'T0000000000000000123',
            'IN_MAT_THICK' => '052',
            'IN_MAT_WIDTH' => '5252',
            'IN_MAT_WT' => '52',
            'IN_MAT_LEN' => '5',
            'IN_MAT_IN_DIA' => '5',
            'IN_MAT_DIA' => '5',
            'SG_SIGN' => '5',
            'PLAN_TYPE' => '1',
        ]);
        DB::table('f_main_plans')->insertGetId([
            'sort' => 2,
            'PLAN_NO' => '00002',
            'branch_id' => '1',
            'IN_MAT_NO' => 'T0000000000000000123',
            'IN_MAT_THICK' => '052',
            'IN_MAT_WIDTH' => '5252',
            'IN_MAT_WT' => '52',
            'IN_MAT_LEN' => '5',
            'IN_MAT_IN_DIA' => '5',
            'IN_MAT_DIA' => '5',
            'SG_SIGN' => '5',
            'PLAN_TYPE' => '1',
        ]);
    }
}
