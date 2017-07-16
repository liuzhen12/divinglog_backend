<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','locationEvent'],
    'modules' => [
        'wechat' => [
            'class' => 'app\modules\wechat\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'abcd',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'diver'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'coach', 'extraPatterns' => ['GET,HEAD {id}/{transfer}' => 'view'],'tokens' => ['{id}' => '<id:\\d[\\d,]*>','{transfer}' => '<transfer:\\S[\\S,]*>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'activity'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'activity-member'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'certification'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'coach-course'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'course'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'divestore'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'diving-log'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'equip'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'level'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'speciality'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'student'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'coach-title'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'diver-level'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'location'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'base-location'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'language', 'only'=>['index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['login'=>'wechat/login'],'only'=>['index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['register'=>'wechat/register'],'only'=>['create']],
            ],
        ],
        'locationEvent' => [
            'class' => 'app\components\events\LocationEvent'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
