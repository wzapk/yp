<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Options;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class SystemController extends Controller
{
	public function behaviors()
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'delete'  => ['post'],
				],
			],
		]);
	}
	
	public function actionIndex()
	{
		$query = Options::find();
		$count = $query->count();
		$pagination = new Pagination([
			'totalCount' => $count,
		]);
		$models = Options::find()
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
		]);
	}

	public function actionCreate()
	{
		$model = new Options;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		}
		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	protected function findModel($id)
	{
		$model = Options::findOne($id);
		if (!$model) {
			throw new NotFoundHttpException(Yii::t('app', 'The requested page is not exists.'));
		}
		return $model;
	}
}