<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'name' => '魔菇音乐教育黄页',
    'language' => 'zh-CN',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qWJS6lQBXXrs0Y7Ttcg4xlxiOdIJFKdt',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/contents' => 'contents.php',
                        'app/user' => 'user.php',
                        'app/options' => 'options.php',
                        'app/teacher' => 'teacher.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'hashCallback' => function ($path) {
 
                if (!function_exists('_myhash_')) {
                    function _myhash_($path) {
                        if (is_dir($path)) {
                            $handle = opendir($path);
                            $hash = '';
                            while (false !== ($entry = readdir($handle))) {
                                if ($entry === '.' || $entry === '..') {
                                    continue;
                                }
                                $entry = $path . '/' . $entry;
                                $hash .= _myhash_($entry);
                            }
                            $result = sprintf('%x', crc32($hash . Yii::getVersion()));
                        } else {
                            $result = sprintf('%x', crc32(filemtime($path) . Yii::getVersion()));
                        }
                        return $result;
                    }
                }
 
                return _myhash_($path);
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '18603388178@163.com',
                'password' => 'mkz758240',
                'port' => '994',
                'encryption' => 'ssl',
            ]
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
        //'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            //'suffix' => '.html',
            'rules' => [
                '<controller>/<action>',
                '<controller>/<id:\d+>' => '<controller>/<view>',
                '<controller>/<id:\d+>/<action:(update|trash|untrash|delete)>' => '<controller>/<action>',
                'news/<title:\w+>.html' => 'contents/view',
                'logout' => 'site/logout',
                'login' => 'site/login',
                'reset-password' => 'site/reset-password',
                'request-password-reset' => 'site/request-password-reset',
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    $config['components']['db'] = require(__DIR__ . '/db-local.php');
}

return $config;
