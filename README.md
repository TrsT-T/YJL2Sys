# 依托咪乐多CMS管理系统搭建的远境L2系统

#### 介绍
咪乐多CMS管理系统，是一款开源的CMS管理系统，为中小企业提供最佳的开发方案。是2021年全新推出的一款轻量级、高性能、前后端分离的企业级管理系统。完美支持二次开发，可学习可商用，为快速搭建企业级应用而生。远境L2系统，是一个运行于win10系统的数据采集与过程控制系统，通信方面借助Gatewayworker与MES实现websock长连接通讯，与底层plc进行TCP通讯。
#### 技术特点

- 前后端完全分离 (互不依赖 开发效率高)
- 采用PHP7.3 (强类型严格模式)
- Laravel8（轻量级PHP开发框架）
- vue-element-admin（企业级中后台产品UI组件库）

#### 环境要求

- CentOS 7.0+
- Nginx 1.10+
- PHP 7.3+
- MySQL 5.6+



#### 安装教程

- admin文件夹，是后台管理页面。
- server文件夹是后台接口文件夹。
#### server安装

```
1.打开server文件
# 创建.env文件
2. cp .env.example .env
# 安装相关依赖
3. composer install
# 生成laravel的key
4. php artisan key:generate
# 这条命令会在 .env 文件下生成一个加密密钥，如：JWT_SECRET=foobar
5. php artisan jwt:secret
6. 配置.env数据库信息
# 执行数据库迁移文件
7. php artisan module:migrate
# 执行数据库填充
8. php artisan module:seed
```
#### admin安装

```
打开admin文件夹

# 建议不要用 cnpm 安装 会有各种诡异的bug 可以通过如下操作解决 npm 下载速度慢的问题
1. npm install --registry=https://registry.npm.taobao.org
# 本地开发 启动项目
2. npm run dev
```
#### 创建项目
1.php artisan module:make FL2Sys  
2.php artisan module:make-controller PlanController FL2Sys


