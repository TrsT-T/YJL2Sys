<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 13:48:12
 * @LastEditTime: 2022-07-18 14:58:28
 * @Description: 
 */

/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use GatewayWorker\Lib\Db;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    public static function onConnect($client_id)
    {
        $db = new \Workerman\MySQL\Connection('127.0.0.1', '3306', 'root', '123456', 'test');
        // 执行SQL
        // 插入
        $db->insert('lv_common_connects')->cols(array(
            'connect_name' => 'Websocket',
            'ip_no' => $_SERVER['REMOTE_ADDR'],
            'port_no' => $_SERVER['REMOTE_PORT'],
            'created_at' => date('Y-m-d H:i:s')
        ))->query();
        Gateway::sendToClient($client_id, "已成功连接\r\n");
        $db = null;
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        // 向所有人发送 
        // Gateway::sendToClient($client_id, "已接收到信息：$message\r\n");
        // Gateway::sendToClient($client_id, "1");

        // if ($str == 10) {
        //     $head = substr($message, 0, 4);
        //     $body = substr($message, 4, 5);
        //     $foot = substr($message, 9);
        //     Gateway::sendToClient($client_id, json_encode(['head' => $head, 'body' => $body, 'foot' => $foot]));
        // } else {
        //     Gateway::sendToClient($client_id, "格式错误");
        // }
        // echo "onMessage\r\n";
        $str = strlen($message);
        $data = array();
        switch ($str) {
            case 51:
                $data['PLAN_NO'] = substr($message, 0, 10);
                $data['branch_id'] = substr($message, 10, 1);
                $data['status'] = 0;
                $data['IN_MAT_NO'] = substr($message, 11, 20);
                $data['OUT_MAT_NO'] = substr($message, 31, 20);
                $data['created_at'] = date('Y-m-d H:i:s');
                break;
            default:
                Gateway::sendToClient($client_id, "信息发送错误：$message 长度为 $str \r\n");
        }
        if (!empty($data)) {
            $db = new \Workerman\MySQL\Connection('127.0.0.1', '3306', 'root', '123456', 'test');
            $db->insert('lv_f_main_plans')->cols($data)->query();
            Gateway::sendToClient($client_id, "信息接收成功\r\n");
            $db = null;
        }
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送 
        // GateWay::sendToClient($client_id, "logout\r\n");
        $db = new \Workerman\MySQL\Connection('127.0.0.1', '3306', 'root', '123456', 'test');
        // 执行SQL
        $db->update('lv_common_connects')->cols(array('updated_at'))
            ->orderByDESC(array('id'))->limit(1)->bindValue('updated_at', date('Y-m-d H:i:s'))->query();
        Gateway::sendToClient($client_id, "已断开\r\n");
        $db = null;
    }
}
