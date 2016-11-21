<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@bower/amazeui/dist';
    public $css = [
        'css/amazeui.css',
        'css/app.css',
    ];
    public $js = [
        'js/amazeui.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
