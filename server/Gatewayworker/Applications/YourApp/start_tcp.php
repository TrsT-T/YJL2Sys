<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-13 16:31:24
 * @LastEditTime: 2022-07-18 10:57:18
 * @Description: 
 */

/**
 * This file is part of workerman.
 *
 *Gateway类用于初始化Gateway进程
 *Gateway进程是暴露给客户端的让其连接的进程
 *所有客户端的请求都是由Gateway接收然后分发给BusinessWorker处理
 *同样BusinessWorker也会将要发给客户端的响应通过Gateway转发出去。
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Workerman\Connection\TcpConnection;
use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';

$tcp_worker = new Worker("tcp://192.168.99.3:2000");
// gateway名称，status方便查看
$tcp_worker->name = 'L1PLC';
// 启动4个进程对外提供服务
$tcp_worker->count = 4;
// 当客户端发来数据时
$tcp_worker->onMessage = function (TcpConnection $connection, $data) {
    // 向客户端发送数据
    $strsend = "88";
    $strsend = base_convert($strsend, 10, 16);
    $strsend = str_pad($strsend, (9 - count([$strsend])), '0', STR_PAD_LEFT);//补位
    $strs1 = substr($strsend, 0, 2);//截取
    $strs2 = substr($strsend, 2, 2);
    $strs3 = substr($strsend, 4, 2);
    $strs4 = substr($strsend, 6, 2);
    $tras = $strs3 . $strs4 . $strs1 . $strs2; //高低位对调
    $connection->send(hex2bin($tras));

    //接收客户端数据
    $string = bin2hex($data);//assic转2进制
    $str1 = substr($string, 0, 2);
    $str2 = substr($string, 2, 2);
    $str3 = substr($string, 4, 2);
    $str4 = substr($string, 6, 2);
    $tra = $str4 . $str3 . $str2 . $str1; //高低位对调，前后端对调
    $tra = base_convert($tra, 16, 10);
    // echo "recv: $tra\n"; //32个布尔打印于cmd
    // echo "sent:  $tras\n";
};

/* 
// 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
$gateway->onConnect = function($connection)
{
    $connection->onWebSocketConnect = function($connection , $http_header)
    {
        // 可以在这里判断连接来源是否合法，不合法就关掉连接
        // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket链接
        if($_SERVER['HTTP_ORIGIN'] != 'http://kedou.workerman.net')
        {
            $connection->close();
        }
        // onWebSocketConnect 里面$_GET $_SERVER是可用的
        // var_dump($_GET, $_SERVER);
    };
}; 
*/

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
