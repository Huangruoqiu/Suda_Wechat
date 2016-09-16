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
        'file'  => __DIR__.'/logs/wechat.log',
    ],
    'guzzle' => [
        'timeout' => 3.0, // 超时时间（秒）
        'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],
];

//使用配置初始化一个项目实例
$app = new Application($options);
//从项目实例中得到一个服务端应用实例
$server = $app->server;
//用户实例，可以通过类似$user->nickname这样的方法拿到用户昵称，openid等等

$menu = $app->menu;
$buttons = [
    [
        "name"=> "信息查询",
        "sub_button" => [
            [
                "type" => "click",
                "name" => "课表查询",
                "key"  => "QUERY_KEBIAO"
            ],
            [
                "type" => "click",
                "name" => "成绩查询",
                "key"  => "QUERY_CHENGJI"
            ],
            [
                "type" => "click",
                "name" => "学籍信息查询",
                "key"  => "QUERY_XUEJI"
            ],
            [
                "type" => "click",
                "name" => "行为学分查询",
                "key"  => "QUERY_XUEFEN"
            ],
            [
                "type" => "click",
                "name" => "奖惩信息查询",
                "key"  => "QUERY_JIANGC"
            ],
        ],
    ],
    [
        "type" => "click",
        "name" => "联系我",
        "key"  => "CONTACT"
    ],
];
$menu->add($buttons);
//接收用户发送的消息
//响应输出
$server->setMessageHandler(function ($message) {
    switch ($message->MsgType) {
        case 'event':
            switch ($message->Event) {
                case 'subscribe':
                    return new Text(['content'=>"您好！欢迎关注本公众号!您可以与我聊天哦！"]);
                    break;
                case 'CLICK':
                    switch ($message->EventKey) {
                        case 'QUERY_KEBIAO':
                            return new Text(['content'=>"暂未开放"]);
                            break;
                        case 'QUERY_CHENGJI':
                            return new Text(['content'=>"暂未开放"]);
                            break;
                        case 'QUERY_XUEJI':
                            return new Text(['content'=>"暂未开放"]);
                            break;
                        case 'QUERY_XUEFEN':
                            return new Text(['content'=>"暂未开放"]);
                            break;
                        case 'QUERY_JIANGC':
                            return new Text(['content'=>"暂未开放"]);
                            break;
                        case 'CONTACT':
                            return new Text(['content'=>"邮箱：215309257@qq.com，有任何疑问可以发邮件与我联系。"]);
                            break;
                        default:
                            return new Text(['content'=>"$message->EventKey"]);
                            break;
                    }
                    break;
                default:
                    return new Text(['content'=>"未知命令2"]);
                    break;
            }
        break;    
        case  'text':      
            $content = $message->Content;
            $url = "http://www.tuling123.com/openapi/api?key=9ec94d2929034462bd37403b3d0ad8f5&info=".$content;
            //获取图灵机器人返回的内容
            $content = file_get_contents($url);
            //对内容json解码
            $content = json_decode($content);
            //把内容发给用户
            $text =  new Text(['content' => $content->text]);	
            return $text;
        break;
        case 'image':
            $mediaId  = $message->MediaId;
            return new Image(['media_id' => $mediaId]);
        break;
        //声音信息处理，略
        case 'voice':
            $mediaId  = $message->MediaId;
            return new Voice(['media_id' => $mediaId]);
        break;
        //视频信息处理，略
        case 'video':
            $mediaId  = $message->MediaId;
            return new Video(['media_id' => $mediaId]);
        break;
        //坐标信息处理，略
        case 'location':
            return new Text(['content' => $message->Label]);
        break;

        //链接信息处理，略
        case 'link':
            return new Text(['content' => $message->Description]);
        break;
        default:
        break;
    }
});

$server->serve()->send();
