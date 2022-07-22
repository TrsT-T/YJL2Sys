<?php
/*
 * @Name: 获取计划验证规则
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-12 16:42:59
 * @LastEditTime: 2022-07-05 15:30:02
 */

namespace Modules\FL2Sys\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanOperateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'id'   => 'required|is_positive_integer',
            'operateid' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'id.required'                     => '缺少参数（id）！',
            'id.is_positive_integer'         => '（id）参数错误！',
            'operateid.required'                 => '缺少参数（operateid）！',
        ];
    }
}
