<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\Controller;

class RbacController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'matchCallback' => function($rule, $action) {
							return Yii::$app->user->can('admin');
						}
					],
				],
			],
		];
	}

}