<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\District;
use app\models\DistrictUploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;

class DistrictController extends Controller
{

	public function actionState()
	{
		$query = District::find()->select(['p_id as k', 'p_nm as v'])->distinct();
		$p_id = Yii::$app->request->get('p_id');
		if ($p_id) {
			$query->where(['p_id' => $p_id]);
		}
		$models = $query->asArray()->all();
		return Json::encode($models);
	}

	public function actionCity()
	{
		$query = District::find()->select(['c_id as k', 'c_nm as v'])->distinct();
		$p_id = Yii::$app->request->get('p_id');
		$models = [];
		if ($p_id) {
			$query->where(['p_id' => $p_id]);
			$models = $query->asArray()->all();
		}
		return Json::encode($models);
	}

	public function actionRegion()
	{
		$query = District::find()->select(['a_id as k', 'a_nm as v'])->distinct();
		$p_id = Yii::$app->request->get('p_id');
		$c_id = Yii::$app->request->get('c_id');
		$models = [];
		if ($p_id && $c_id) {
			$query->where(['p_id'=>$p_id, 'c_id'=>$c_id]);
			$models = $query->asArray()->all();
		}
		return Json::encode($models);
	}
	
	public function actionImport()
	{
		$uploadForm = new DistrictUploadForm;
		if (Yii::$app->request->isPost) {
			$uploadForm->excelFile = UploadedFile::getInstance($uploadForm, 'excelFile');
			if ($uploadForm->upload()) {
				// 文件上传成功
				$retval = District::import($uploadForm->filename);
				return Json::encode($retval);
			}
		}
		return $this->render('upload', ['model' => $uploadForm]);
	}
	
}