<?php
namespace app\controllers;

use yii\web\Controller;
use mdm\admin\components\AccessControl;

class BackendController extends Controller
{
	public function init()
	{
		parent::init();
		$this->layout = '//backend/main';
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