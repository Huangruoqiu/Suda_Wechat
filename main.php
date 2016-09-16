<?php
//引入composer入口文件
include __DIR__.'/vendor/autoload.php';
//引入我们的主项目的入口类。
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Video;
use EasyWeChat\Message\Voice;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Article;
use EasyWeChat\Message\Material;
use EasyWeChat\Message\Raw;

//在options中填入配置信息
$options = [
    //打开调试模式
'debug'     => true,
//微信基本配置，从公众平台获取
    'app_id'    => 'wxe1c55c279b43b9a6',
    'secret'    => '3fe34aecf778f4cff1071500b8188d0c',
    'token'     => 'hefangteng',
//日志配置
    'log' => [
        'level' => 'debug',
        'file'  => 'wechat.log',
    ],

];
//使用配置初始化一个项目实例
$app = new Application($options);
//从项目实例中得到一个服务端应用实例
$server = $app->server;
//用户实例，可以通过类似$user->nickname这样的方法拿到用户昵称，openid等等
//$user = $app->user;
//接收用户发送的消息
//响应输出
$server->serve()->send();