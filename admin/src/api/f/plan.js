/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-07 15:46:57
 * @LastEditTime: 2022-07-07 15:47:41
 * @Description: 
 */
import request from '@/utils/request'
// 操作日志
export function getFPlanList(data) {
    return request({
        url: 'plan/getList',
        method: 'get',
        params: data
    })
}
//开卷
export function planStart(data) {
    return request({
        url: 'plan/start',
        method: 'post',
        data: data
    })
}
// 批量删除
export function delFPlanAll(data) {
    return request({
        url: 'plan/delAll',
        method: 'delete',
        data: data
    })
}
// 新建计划
export function createPlan(data) {
    return request({
        url: '/plan/store',
        method: 'post',
        data: data
    })
}