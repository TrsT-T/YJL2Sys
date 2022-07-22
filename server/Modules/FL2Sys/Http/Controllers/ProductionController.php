<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-05 15:12:16
 * @LastEditTime: 2022-07-12 11:06:48
 * @Description: 
 */

namespace Modules\FL2Sys\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FL2Sys\Services\production\ProductionService;
use Modules\FL2Sys\Http\Requests\PlanPageRequest;
use Modules\FL2Sys\Http\Requests\CommonIdArrRequest;
use Modules\FL2Sys\Http\Requests\CommonIdRequest;
use Modules\FL2Sys\Http\Requests\PlanStoreRequest;
use Modules\FL2Sys\Http\Requests\PlanOperateRequest;

class ProductionController extends Controller
{
    /**
     * @Name: 获取计划列表
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function getList(PlanPageRequest $request)
    {
        return (new ProductionService())->getList($request->only([
            'page',
            'limit',
            'PLAN_NO',
            'IN_MAT_NO',
            'created_at',
            'updated_at',
            'OUT_MAT_NO'
        ]));
    }

    /**
     * @Name: 删除计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function delAll(CommonIdArrRequest $request)
    {
        return (new ProductionService())->delAll($request->get('idArr'));
    }
}
