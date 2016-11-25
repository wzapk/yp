<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\Html;
use app\models\Contents;
use yii\data\ActiveDataProvider;

class MapController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Contents::find()->orderBy('updated_at desc'),
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		$models = Contents::find()
			->with('map')
			->where(['status'=>Contents::STATUS_ACTIVE])
			->orderBy('updated_at desc')
			->all();
		$markArray = [];
		foreach ($models as $index => $content) {
			$location = $content->map;
			$markArray[] = [
				'title' => Html::encode($content->name),
				'content' => Html::encode($content->address).'，电话：'.Html::encode($content->phone),
				'point' => $location['lng'] . '|' . $location['lat'],
				'isOpen' => 0,
				'icon' => [
					'w' => 21,
					'h' => 21,
					'l' => 46,
					't' => 46,
					'x' => 1,
					'lb' => 10,
				],
			];
		}
		
		return $this->render('index-pjax', [
			'totalCount' => count($models),
			'dataProvider' => $dataProvider,
			'markArray' => $markArray,
		]);
	}
}