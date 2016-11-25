<?php
namespace app\components\fancyBox;

class FancyBoxBundle extends \yii\web\AssetBundle
{
	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		$this->js = [
			'jquery.mousewheel-3.0.6.pack.js',
			'jquery.fancybox.js',
		];
		$this->css = [
			'jquery.fancybox.css',
		];
		$this->depends = [
			'yii\web\JqueryAsset',
		];
	}
}