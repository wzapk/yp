<?php

return [
    'supportEmail' => 'wzapk_info@163.com',

    // icp
    'ICP' => '京ICP备14061930号',
    
    // 系统名称
    'appname' => '魔菇音乐教育黄页',
    // 系统名称缩写
    'shortappname' => '魔菇黄页',

    // support
    'support' => '伊波',
    // support link: 必须以http://开头
    'supportLink' => 'http://www.yiiboard.com',

    // copyright
    'copyright' => '吉他中国',
    // copyright link: 必须以http://开头
    'copyrightLink' => 'http://www.guitarchina.com',

    // 重置密码TOKEN过期时间：2小时
    'user.passwordResetTokenExpire' => 3600 * 2,

    // 社会化通信配置
    'social.list' => [
        'Email',
        '微信',
        '微博',
        'QQ',
        //'Facebook',
        //'g+',
        //'gmail',
    ],

    'restapi' => [
        'apiHost' => 'http://localhost/yellowpage/web/api',
        'tokenExpire' => 300, // 5分钟, 5*60
    ],

    'qiniu' => [
        'accessKey' => '4DO4KlxeOtHyX7RrQ-_dkkTF0vTkBp3kdO60izy-',
        'secretKey' => '2uWsBQaFKbQk3Wb9RtpYCLtHCFQveqF76nfOex70',
        'bucket' => 'guitarchina',
        'action' => 'http://upload.qiniu.com',
    ],

    'meta_keywords' => '网站关键字',
    'meta_description' => '网站描述',
];
