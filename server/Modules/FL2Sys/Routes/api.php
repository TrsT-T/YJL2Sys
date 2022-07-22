<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-05 15:03:12
 * @LastEditTime: 2022-07-12 11:56:34
 * @Description: 
 */

use Illuminate\Http\Request;

Route::group(["prefix" => "L2", "middleware" => "AdminApiAuth"], function () {
    /***********************************Index***************************************/
    // //登录
    // Route::post('index/login', 'L2\IndexController@login');
    // // 获取管理员信息
    // Route::get('index/info', 'L2\IndexController@info');
    // //清除缓存
    // Route::delete('index/outCache', 'L2\IndexController@outCache');
    // //修改密码
    // Route::put('index/upadtePwdView', 'L2\IndexController@upadtePwdView');
    // //刷新token  
    // Route::put('index/refreshToken', 'L2\IndexController@refreshToken');
    // //退出登录
    // Route::delete('index/logout', 'L2\IndexController@logout');
    // //获取模块
    // Route::get('index/getModel', 'L2\IndexController@getModel');
    // //获取左侧栏
    // Route::get('index/getMenu', 'L2\IndexController@getMenu');
    /***********************************Plan***************************************/
    //查询计划列表
    Route::get('plan/getList', 'PlanController@getList');
    //删除计划
    Route::delete('plan/delAll', 'PlanController@delAll');
    //新增计划
    Route::post('plan/store', 'PlanController@store');
    //开卷
    Route::post('plan/start', 'PlanController@start');
    /***********************************Production***************************************/
    //查询计划列表
    Route::get('production/getList', 'ProductionController@getList');
    //删除计划
    Route::delete('production/delAll', 'ProductionController@delAll');
    /***********************************fault***************************************/
    //查询计划列表
    Route::get('fault/getList', 'FaultController@getList');
});
