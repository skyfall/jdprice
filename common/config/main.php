<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=jdprice',
            'username' => 'root',
            'password' => null,
            'charset' => 'utf8',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'logVars'=>['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_SERVER'],
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/'.date("Y-m-d",time()).'info.log',
                    'maxFileSize' => 1024 * 2,
                ],
                [
                    'logVars'=>['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_SERVER'],
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@runtime/logs/'.date("Y-m-d",time()).'Warning.log',
                    'maxFileSize' => 1024 * 2,
                ],
            ],
        ],
    ],
];
