<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-05 15:12:16
 * @LastEditTime: 2022-07-09 15:02:59
 * @Description: 
 */

namespace Modules\FL2Sys\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FL2Sys\Services\plan\PlanService;
use Modules\FL2Sys\Http\Requests\PlanPageRequest;
use Modules\FL2Sys\Http\Requests\CommonIdArrRequest;
use Modules\FL2Sys\Http\Requests\CommonIdRequest;
use Modules\FL2Sys\Http\Requests\PlanStoreRequest;
use Modules\FL2Sys\Http\Requests\PlanOperateRequest;

class PlanController extends Controller
{
    /**
     * @Name: 获取计划列表
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function getList(PlanPageRequest $request)
    {
        return (new PlanService())->getList($request->only([
            'page',
            'limit',
            'PLAN_NO',
            'IN_MAT_NO',
            'created_at',
            'OUT_MAT_NO'
        ]));
    }
    /**
     * @Name: 获取一条详细计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function getOne(PlanOperateRequest $request)
    {
        //
        return (new PlanService())->getOne($request->only('id', 'operateid'));
    }
    /**
     * @Name: 开卷
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function start(CommonIdRequest $request)
    {
        //
        return (new PlanService())->start($request->get('id'));
    }
    /**
     * @Name: 删除计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function delAll(CommonIdArrRequest $request)
    {
        return (new PlanService())->delAll($request->get('idArr'));
    }
    /**
     * @Name: 新增计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function store(PlanStoreRequest $request)
    {
        //
        return (new PlanService())->store($request->only(
            'PLAN_NO',
            'IN_MAT_NO',
            'OUT_MAT_NO',
            'IN_MAT_THICK',
            'IN_MAT_WIDTH',
            'IN_MAT_WT',
            'IN_MAT_LEN',
            'FILM_KIND_CODE',
            'DIVIDE_WT',
            // 'IN_MAT_IN_DIA',
            // 'IN_MAT_DIA',
            // 'IN_MAT_SLEEVE_FLAG',
            // 'IN_MAT_SLEEVE_TYPE',
            // 'SG_SIGN',
            // 'SG_STD',
            // 'IN_MAT_TYPE',
            // 'OUT_MAT_TARG_THICK',
            // 'ORDER_THICK',
            // 'OUT_THICK_TOL_MINUS',
            // 'OUT_THICK_TOL_PLUS',
            // 'OUT_MAT_TARG_WIDTH',
            // 'ORDER_WIDTH',
            // 'OUT_WIDTH_TOL_MINUS',
            // 'OUT_WIDTH_TOL_PLUS',
            // 'FILM_TYPE_CODE',

            // 'FILM_THICK',
            // 'SURFACE_STRUCT_CODE',
            // 'ROUGH',
            // 'SMOOTH',
            // 'ORIGIN_CODE',
            // 'DEST_CODE',
            // 'PONO_NO',
            // 'SALE_ORDER_SUB_NO',
            // 'APN',
            // 'DELIVY_DATE',
            // 'BASELEVEL_DIRECTION',
            // 'DIVIDE_TYPE',
            // 'DIVIDE_NUM',
            // 'ORD_UNIT_WT_MAX',
            // 'ORD_UNIT_WT_MIN',
            // 'DIVIDE_WT_1',
            // 'DIVIDE_WT_2',
            // 'DIVIDE_WT_3',
            // 'DIVIDE_WT_4',
            // 'DIVIDE_WT_5'
        ));
    }
    /**
     * @Name: 更新计划
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function update(PlanOperateRequest $request)
    {
        //
        return (new PlanService())->update($request->only(
            'id',
            'operateid',
            'status',
            'PLAN_NO',
            'SEQ_NO',
            'UNIT_CODE',
            'PLAN_TYPE',
            'FINAL_COIL_FLAG',
            'IN_MAT_KIND',
            'STOCK_CODE',
            'LOCATION_NO',
            'IN_MAT_NO',
            'ORIGIN_MAT_NO',
            'IN_MAT_THICK',
            'IN_MAT_WIDTH',
            'IN_MAT_WT',
            'IN_MAT_LEN',
            'IN_MAT_IN_DIA',
            'IN_MAT_DIA',
            'IN_MAT_SLEEVE_FLAG',
            'IN_MAT_SLEEVE_TYPE',
            'SG_SIGN',
            'SG_STD',
            'IN_MAT_TYPE',
            'OUT_MAT_TARG_THICK',
            'ORDER_THICK',
            'OUT_THICK_TOL_MINUS',
            'OUT_THICK_TOL_PLUS',
            'OUT_MAT_TARG_WIDTH',
            'ORDER_WIDTH',
            'OUT_WIDTH_TOL_MINUS',
            'OUT_WIDTH_TOL_PLUS',
            'FILM_TYPE_CODE',
            'FILM_KIND_CODE',
            'FILM_THICK',
            'SURFACE_STRUCT_CODE',
            'ROUGH',
            'SMOOTH',
            'ORIGIN_CODE',
            'DEST_CODE',
            'PONO_NO',
            'SALE_ORDER_SUB_NO',
            'APN',
            'DELIVY_DATE',
            'BASELEVEL_DIRECTION',
            'DIVIDE_TYPE',
            'DIVIDE_NUM',
            'ORD_UNIT_WT_MAX',
            'ORD_UNIT_WT_MIN',
            'DIVIDE_WT_1',
            'DIVIDE_WT_2',
            'DIVIDE_WT_3',
            'DIVIDE_WT_4',
            'DIVIDE_WT_5'
        ));
    }
}
