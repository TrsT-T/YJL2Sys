<?php
/*
 * @Name: 获取计划验证规则
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-12 16:42:59
 * @LastEditTime: 2022-07-07 14:41:49
 */

namespace Modules\FL2Sys\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanPageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'page' => 'required|is_positive_integer',
            'limit' => 'required|is_positive_integer',
        ];
    }
    public function messages()
    {
        return [
            'page.required'                 => '缺少参数（page）！',
            'page.is_positive_integer'     => '（page）参数错误！',
            'limit.required'                 => '缺少参数（limit）！',
            'limit.is_positive_integer'     => '（limit）参数错误！',
        ];
    }
}
