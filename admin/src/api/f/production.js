/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-07 15:46:57
 * @LastEditTime: 2022-07-07 15:47:41
 * @Description: 
 */
import request from '@/utils/request'
// 获取实绩
export function getFProductionList(data) {
    return request({
        url: 'production/getList',
        method: 'get',
        params: data
    })
}
// 批量删除
export function delFProductionAll(data) {
    return request({
        url: 'production/delAll',
        method: 'delete',
        data: data
    })
}