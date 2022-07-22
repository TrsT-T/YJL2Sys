<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-07 10:37:13
 * @LastEditTime: 2022-07-08 16:48:18
 * @Description: 
 */

namespace Modules\FL2Sys\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FL2SysDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(FPlanTableSeederTableSeeder::class);
    }
}
