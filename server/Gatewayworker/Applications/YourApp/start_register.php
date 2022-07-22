<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 13:48:12
 * @LastEditTime: 2022-07-12 16:46:00
 * @Description: 
 */

/**
 * This file is part of workerman.
 *  Gateway进程和BusinessWorker进程启动后分别向Register进程注册自己的通讯地址
 *  Gateway进程和BusinessWorker通过Register进程得到通讯地址后，就可以建立起连接并通讯了
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

use \Workerman\Worker;
use \GatewayWorker\Register;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';

// register 必须是text协议//不可外部访问
$register = new Register('text://127.0.0.1:8086');

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
