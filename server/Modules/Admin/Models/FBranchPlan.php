<?php
/*
 * @Name: 
 * @Description: 
 * @Autor: trs
 * @Date: 2022-03-04 15:13:52
 * @LastEditTime: 2022-07-07 15:05:01
 */

namespace Modules\Admin\Models;

use DateTimeInterface;


class FBranchPlan extends BaseApiModel
{
	/**
	 * @name 更新时间为null时返回
	 * @description
	 * @author 西安咪乐多软件
	 * @date 2021/6/14 9:33
	 * @param  $value Int
	 * @return Boolean
	 **/
	public function getUpdatedAtAttribute($value)
	{
		return $value ? $value : '';
	}
}
