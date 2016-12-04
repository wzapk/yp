<?php

namespace app\controllers;

use Yii;
use app\models\Contents;
use app\models\User;
use app\models\Teachers;

class MController extends BackendController
{

	public function actionIndex()
	{
		$active_contents_count = Contents::find()->where(['status'=>Contents::STATUS_ACTIVE])->count();
		$deactive_contents_count = Contents::find()->where(['status'=>Contents::STATUS_DELETED])->count();
		$active_users_count = User::find()->where(['status'=>User::STATUS_ACTIVE])->count();
		$deactive_users_count = User::find()->where(['status'=>User::STATUS_DELETED])->count();
		$active_teachers_count = Teachers::find()->where(['status'=>Teachers::STATUS_ACTIVE])->count();
		$deactive_teachers_count = Teachers::find()->where(['status'=>Teachers::STATUS_DELETED])->count();
		$last_contents = Contents::getLast(5);
		$last_users = User::getLast(5);
		$last_teachers = Teachers::getLast(5);

		return $this->render('index-adminlte', [
			'active_contents_count' => $active_contents_count,
			'deactive_contents_count' => $deactive_contents_count,
			'active_users_count' => $active_users_count,
			'deactive_users_count' => $deactive_users_count,
			'active_teachers_count' => $active_teachers_count,
			'deactive_teachers_count' => $deactive_teachers_count,
			'last_contents' => $last_contents,
			'last_users' => $last_users,
			'last_teachers' => $last_teachers,
		]);
	}

	/*
	public function actionMap()
	{
		$mapmark = file_get_contents('c:/xampp/htdocs/yellowpage/web/js/mapmark.json');
		$jsonData = json_decode($mapmark);
		if (json_last_error() == 0) {
			var_export(\app\models\MapMark::import($jsonData));
		} else {
			var_dump($jsonData);
			var_dump(json_last_error_msg());
		}
	}
	

	public function actionTest($id)
	{
		$model = Contents::findOne($id);
		if (!$model) {
			throw new \yii\web\NotFoundHttpException('没有找到该ID对应的分部.');
		}
		$address = $model->address;
		$ak = '13reT2e9mO48UbkQg6gzD2I9';
		$url = 'http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak='.$ak;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);
		$retval = curl_exec($ch);
		var_dump($retval);
	}
	*/
	
	public function actionInitMap()
	{
		$contents = Contents::find()->where(['status'=>Contents::STATUS_ACTIVE])->all();
		$ak = '13reT2e9mO48UbkQg6gzD2I9';
		$baseUrl = 'http://api.map.baidu.com/geocoder/v2/?ak=' . $ak . '&output=json';
		$ch = curl_init();
		$debug_out = [];
		foreach ($contents as $index => $content) {
			$address = urlencode($content->address);
			$url = $baseUrl . '&address=' . $address;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);
			$retval = curl_exec($ch);
			$retval = json_decode($retval, true);
			
			if (json_last_error() == 0) {
				if ($retval['status'] == 0) {
					$location = $retval['result']['location'];
					
					$mapmark = \app\models\MapMark::findOne(['cid' => $content->id]);
					if (!$mapmark) {
						$mapmark = new \app\models\MapMark;
						$mapmark->cid = $content->id;
					}
					$mapmark->lat = ''.$location['lat'];
					$mapmark->lng = ''.$location['lng'];
					$mapmark->save();
					//unset($mapmark);
					
					$debug_out[] = [
						'name' => $content->name,
						'lat' => $mapmark->lat,
						'lng' => $mapmark->lng,
					];
					
				}
			}
		}
		return json_encode(['count'=>count($debug_out), 'data'=>$debug_out]);
	}
}