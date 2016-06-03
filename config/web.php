<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'simple',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'BeTwduX44kvoxY41av7awj3McVQwRPpw',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => '',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site\error',
        ],
        'log' => [
            'tracelevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

return $config;
?>
