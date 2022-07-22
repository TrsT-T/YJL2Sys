/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-07 15:46:57
 * @LastEditTime: 2022-07-07 15:47:41
 * @Description: 
 */
import request from '@/utils/request'
// 获取故障
export function getFaultList(data) {
    return request({
        url: 'fault/getList',
        method: 'get',
        params: data
    })
}