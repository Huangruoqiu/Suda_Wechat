<?php
include __DIR__.'/vendor/autoload.php';

use EasyWeChat\Foundation\Application;
$options = include __DIR__."/config.php";

$app = new Application($options);

$server = $app->server;

$server->serve()->send();


