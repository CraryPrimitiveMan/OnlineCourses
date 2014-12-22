<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST <controller:[\w-]+>s'                                => '<controller>/create',
                '<controller:[\w-]+>s'                                     => '<controller>/index',
                'PUT <controller:[\w-]+>/<id:[\w\d,]{24}>'                 => '<controller>/update',
                'DELETE <controller:[\w-]+>/<id:[\w\d,]{24}>'              => '<controller>/delete',
                '<controller:[\w-]+>/<id:[\w\d,]{24}>'                     => '<controller>/view',

                'POST <module:\w+>/<controller:[\w-]+>s'                   => '<module>/<controller>/create',
                '<module:\w+>/<controller:[\w-]+>s'                        => '<module>/<controller>/index',
                'PUT <module:\w+>/<controller:[\w-]+>/<id:[\w\d,]{24}>'    => '<module>/<controller>/update',
                'DELETE <module:\w+>/<controller:[\w-]+>/<id:[\w\d,]{24}>' => '<module>/<controller>/delete',
                '<module:\w+>/<controller:[\w-]+>/<id:[\w\d,]{24}>'        => '<module>/<controller>/view',

                '<controller:[\w-]+>/<action:[\w-]+>'                         => '<controller>/<action>',
                '<module:\w+>/<controller:[\w-]+>/<action:[\w-]+>'            => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
