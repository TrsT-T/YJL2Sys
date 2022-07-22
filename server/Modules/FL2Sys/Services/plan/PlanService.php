<?php
/*
 * @Name: 计划管理服务
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-04 17:11:21
 * @LastEditTime: 2022-07-12 10:46:43
 */

namespace Modules\FL2Sys\Services\plan;

use Modules\Admin\Services\BaseApiService;
use Modules\Admin\Services\auth\TokenService;
// use Modules\Admin\Models\SysAdmin;
use Modules\Admin\Models\FProduction as FProductionModel;
use Modules\Admin\Models\FBranchPlan as FBranchPlanModel;
use Modules\Admin\Models\FMainPlan as FMainPlanModel;
use Modules\Admin\Models\FL2toplc as FL2toplcModel;
use Illuminate\Support\Facades\DB;

class PlanService extends BaseApiService
{

    /** 
     * @name 获取计划列表
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
        $model = FMainPlanModel::query();
        $model = $this->queryCondition($model, $data, 'PLAN_NO');
        $model = $model->where('status', 0);
        if (!empty($data['IN_MAT_NO'])) {
            $model = $model->where('IN_MAT_NO', 'like', '%' . $data['IN_MAT_NO'] . '%');
        }
        if (!empty($data['OUT_MAT_NO'])) {
            $model = $model->where('OUT_MAT_NO', 'like', '%' . $data['OUT_MAT_NO'] . '%');
        }
        $list = $model->orderBy('sort', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }
    /** 
     * @name 删除计划
     * @description
     * @author trs
     * @date 2021/6/14 8:37
     * @param  data Array 删除相关参数
     * @param  dtat.idArr Int 计划idarray
     * @return JSON
     **/
    public function delAll(array $idArr)
    {
        return $this->commonDestroy(FMainPlanModel::query(), $idArr);
    }
    /** 
     * @name 开卷
     * @description 状态改为1
     * @author trs
     * @date 2021/6/14 8:37
     * @param  data Array 
     * @param  dtat.id Int 项目id
     * @return JSON
     **/
    public function start(int $id)
    {
        // $num = $model->where('status', 1)->first(
        //     array(
        //         DB::raw('SUM(status) as num'),
        //     )
        // )->toArray();
        DB::beginTransaction();
        try {
            $this->commonUpdate(FMainPlanModel::query(), $id, ['status' => 1]);
            $data = FMainPlanModel::query()->where('id', $id)->select([
                "IN_MAT_NO",
                'OUT_MAT_NO',
                'IN_MAT_THICK',
                'IN_MAT_WIDTH',
                'IN_MAT_WT',
                'IN_MAT_LEN',
                'DIVIDE_WT',
                'FILM_KIND_CODE'
            ])->get()->toArray();
            FL2toplcModel::query()->where('id', '1')->update($data[0]);
            $data = array_splice($data[0], 0, 2);
            $this->commonCreate(FProductionModel::query(), $data);
            DB::commit();
            return $this->apiSuccess('开卷成功', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiError('开卷失败');
            // return $e;
        }
    }
    /**
     * @Name: 新增计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function store(array $data)
    {
        // $model = $this->auth($data);
        // $sort = $model->pluck('sort')->max() + 1;
        // $data['sort'] = $sort;
        // $sqldata = array_diff_key($data, ['id' => []]);
        return $this->commonCreate(FMainPlanModel::query(), $data, '计划创建成功！', '计划创建失败！');
    }
    // /** 
    //  * @name 获取一条详细计划
    //  * @description
    //  * @author trs
    //  * @date 2021/6/14 8:37
    //  * @param  data Array 查询相关参数
    //  * @param  dtat.id Int 项目id
    //  * @param  dtat.operateid Int 要查询的id
    //  * @return JSON
    //  **/
    // public function getOne(array $data)
    // {
    //     $model = $this->auth($data);
    //     $list = $this->queryCondition($model, ['id' => $data['operateid']], 'id')->get()->toArray();
    //     return $this->apiSuccess('', $list[0]);
    // }


    // /**
    //  * @Name: 更新计划
    //  * @description: 
    //  * @param {*}
    //  * @return {*}
    //  */
    // public function update(array $data)
    // {
    //     $model = $this->auth($data);
    //     $id = $data['operateid'];
    //     $sqldata = array_diff_key($data, ['id' => [], 'operateid' => []]);
    //     $this->commonUpdate($model, $id, $sqldata);
    //     return $this->apiSuccess('数据更新成功！');
    // }
    // /**
    //  * @Name: 项目模型筛选
    //  * @description: 
    //  * @param id String 输入的项目id
    //  * @param message String 错误提示信息
    //  * @return {*}
    //  */
    // public function selectPlanModel(string $id, string $message = '')
    // {
    //     switch ($id) {
    //         case 1:
    //             $model = FPlanModel::query();
    //             break;
    //         case 11:
    //             $model = MPlanModel::query();
    //             break;
    //         default:
    //             return $this->apiError($message);
    //     }
    //     return $model;
    // }
    // /**
    //  * @Name: 验证操作权限
    //  * @description: 
    //  * @param {*}
    //  * @return {*}
    //  */
    // public function auth(array $data)
    // {
    //     $userInfo = (new TokenService())->my(); //获取账号的id，超级管理员为1，1号2，2号3
    //     if ($userInfo['group_id'] != 1) {
    //         $authorizes = SysAdmin::find($userInfo['id'])->group()->value('authorizes'); //权限为1或20
    //         $authorizes = explode('|', $authorizes);
    //         if (!array_intersect($authorizes, [$data['id']])) {
    //             return $this->apiError('账号权限错误！');
    //         }
    //     }
    //     //超级管理员
    //     $model = $this->selectPlanModel($data['id'], '项目id错误！');
    //     return $model;
    // }
    // /**
    //  * @Name: 更新产线跟踪数据
    //  * @description: 
    //  * @param {*}
    //  * @return {*}
    //  */
    // public function trace(array $data)
    // {
    //     $userInfo = (new TokenService())->my(); //获取账号的id，超级管理员为1，1号2，2号3
    //     if ($userInfo['group_id'] != 1) {
    //         $authorizes = SysAdmin::find($userInfo['id'])->group()->value('authorizes'); //权限为1或20
    //         $authorizes = explode('|', $authorizes);
    //         if (!array_intersect($authorizes, [$data['id']])) {
    //             return $this->apiError('账号权限错误！');
    //         }
    //     }
    //     //超级管理员
    //     $model = $this->selectPlanModel($data['id'], '项目id错误！');
    //     return $model;
    // }
}
