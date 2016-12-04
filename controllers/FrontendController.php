<?php
namespace app\controllers;

use yii\web\Controller;
use mdm\admin\components\AccessControl;

class FrontendController extends Controller
{
	public function init()
	{
		parent::init();
		$this->layout = '//main-amazeui';
	}

	public function behaviors()
	{
		return [
			'access' => [
                'class' => AccessControl::className(),
            ],
		];
	}
}