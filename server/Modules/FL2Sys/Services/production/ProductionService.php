<?php
/*
 * @Name: 计划管理服务
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-04 17:11:21
 * @LastEditTime: 2022-07-12 11:46:09
 */

namespace Modules\FL2Sys\Services\production;

use Modules\Admin\Services\BaseApiService;
use Modules\Admin\Services\auth\TokenService;
// use Modules\Admin\Models\SysAdmin;
use Modules\Admin\Models\FProduction as FProductionModel;
use Modules\Admin\Models\FBranchPlan as FBranchPlanModel;
use Modules\Admin\Models\FMainPlan as FMainPlanModel;
use Modules\Admin\Models\FL2toplc as FL2toplcModel;
use Illuminate\Support\Facades\DB;

class ProductionService extends BaseApiService
{

    /** 
     * @name 获取实绩列表
     * @description
     * @author trs
     * @date 2021/6/14 8:37
     * @param  data Array 查询相关参数
     * @param  dtat.page Int 页码
     * @param  dtat.limit Int 每页显示条数
     * @param  dtat.PLAN_NO Int 项目(产线)id
     * @param  dtat.IN_MAT_NO Int 计划id
     * @param  dtat.OUT_MAT_NO Int 状态:0=未生产,1=正在生产，2=已生产
     * @param  dtat.created_at String 创建时间间隔
     * @return JSON
     **/
    public function getList(array $data)
    {
        $model = FProductionModel::query();
        $model = $this->queryCondition($model, $data, 'PLAN_NO');
        if (!empty($data['IN_MAT_NO'])) {
            $model = $model->where('IN_MAT_NO', 'like', '%' . $data['IN_MAT_NO'] . '%');
        }
        if (!empty($data['OUT_MAT_NO'])) {
            $model = $model->where('OUT_MAT_NO', 'like', '%' . $data['OUT_MAT_NO'] . '%');
        }
        $list = $model->orderBy('created_at', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }
    /** 
     * @name 删除实绩
     * @description
     * @author trs
     * @date 2021/6/14 8:37
     * @param  data Array 删除相关参数
     * @param  dtat.idArr Int 计划idarray
     * @return JSON
     **/
    public function delAll(array $idArr)
    {
        return $this->commonDestroy(FProductionModel::query(), $idArr);
    }
}
