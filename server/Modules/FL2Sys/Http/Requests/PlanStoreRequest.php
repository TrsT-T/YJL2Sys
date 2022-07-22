<?php
/*
 * @Name: 获取计划验证规则
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-12 16:42:59
 * @LastEditTime: 2022-07-09 14:52:59
 */

namespace Modules\FL2Sys\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'IN_MAT_NO' => 'required|min:1|max:20',
            'OUT_MAT_NO' => 'required|min:1|max:20',
        ];
    }
    public function messages()
    {
        return [
            'IN_MAT_NO.required'                 => '缺少参数（IN_MAT_NO）！',
            'IN_MAT_NO.min'                     => '入口卷号必须1到20位！',
            'IN_MAT_NO.max'                     => '入口卷必须1到20位！',
            'OUT_MAT_NO.required'                 => '缺少参数（PLAN_NO）！',
            'OUT_MAT_NO.min'                     => '计划号必须1到20位！',
            'OUT_MAT_NO.max'                     => '计划号必须1到20位！',

        ];
    }
}
