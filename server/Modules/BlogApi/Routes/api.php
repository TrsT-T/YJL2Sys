<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 15:33:59
 * @LastEditTime: 2022-07-07 12:08:13
 * @Description: 
 */

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
Route::group(["prefix" => "L2/blogApi", "middleware" => "BlogApiAuth"], function () {
    /***********************************博客相关接口***************************************/
    // 博客分类
    Route::get('index/typeList', 'v1\IndexController@typeList');

    // 图片列表
    Route::get('index/bannerList', 'v1\IndexController@bannerList');

    // 文章列表
    Route::get('index/articleList', 'v1\IndexController@articleList');

    // 推荐文章列表
    Route::get('index/openArticleList', 'v1\IndexController@openArticleList');
});
