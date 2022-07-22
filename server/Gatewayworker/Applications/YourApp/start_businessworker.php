<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 13:48:12
 * @LastEditTime: 2022-07-12 16:19:20
 * @Description: 
 */

/**
 * This file is part of workerman.
 *
 * BusinessWorker是运行业务逻辑的进程
 * BusinessWorker收到Gateway转发来的事件及请求时会
 * 默认调用Events.php中的onConnect onMessage onClose方法处理事件及数据
 * 开发者正是通过实现这些回调控制业务及流程
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';

// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'BusinessWorker';
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址 register里面的地址
$worker->registerAddress = '127.0.0.1:8086';

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
