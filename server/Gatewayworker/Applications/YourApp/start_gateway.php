<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 13:48:12
 * @LastEditTime: 2022-07-18 13:51:01
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

// gateway 进程，这里使用Text协议，可以用telnet测试，外部连接的端口
$gateway = new Gateway("websocket://192.168.101.71:8084");
// gateway名称，status方便查看
$gateway->name = 'L3MES';
// $gateway->name = 'Gateway';
// gateway进程数

$gateway->count = 4;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = '192.168.101.71';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口 
$gateway->startPort = 2900;
// 服务注册地址 register里面的地址
$gateway->registerAddress = '127.0.0.1:8086';

//以下配置含义是客户端连接 pingInterval*pingNotResponseLimit=55 秒内没有任何数据传输给服务端则服务端
//认为对应客户端已经掉线，服务端关闭连接并触发onClose回调
// 心跳间隔S
$gateway->pingInterval = 55;
// 等待系数
$gateway->pingNotResponseLimit = 1.5;
// 心跳数据
$gateway->pingData = '';


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
