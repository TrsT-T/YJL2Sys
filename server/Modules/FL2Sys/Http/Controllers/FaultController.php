<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-05 15:12:16
 * @LastEditTime: 2022-07-12 12:14:16
 * @Description: 
 */

namespace Modules\FL2Sys\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FL2Sys\Services\fault\FaultService;
use Modules\FL2Sys\Http\Requests\PlanPageRequest;
use Modules\FL2Sys\Http\Requests\CommonIdArrRequest;
use Modules\FL2Sys\Http\Requests\CommonIdRequest;
use Modules\FL2Sys\Http\Requests\PlanStoreRequest;
use Modules\FL2Sys\Http\Requests\PlanOperateRequest;

class FaultController extends Controller
{
    /**
     * @Name: 获取计划列表
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function getList(PlanPageRequest $request)
    {
        return (new FaultService())->getList($request->only([
            'page',
            'limit',
            'module_name',
            'created_at'
        ]));
    }
}
