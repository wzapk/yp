<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Contents;
use app\models\District;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\Url;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ContentsController extends Controller
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
							if ($action->id == 'list')
								return true;
							return Yii::$app->user->can('manager');
						}
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		$active_contents_query = Contents::find()->where(['status'=>Contents::STATUS_ACTIVE])->orderBy('created_at desc');
		$active_count = $active_contents_query->count();
		$active_pagination = new Pagination(['totalCount' => $active_count]);
		$active_contents = $active_contents_query
			->offset($active_pagination->offset)
			->limit($active_pagination->limit)
			->all();

		$deactive_contents_query = Contents::find()->where(['status'=>Contents::STATUS_DELETED])->orderBy('created_at desc');
		$trash_count = $deactive_contents_query->count();
		$deactive_contents = $deactive_contents_query->all();

		return $this->render('index', [
			'active_contents' => $active_contents,
			'active_pagination' => $active_pagination,

			'deactive_contents' => $deactive_contents,
			'trash_count' => $trash_count,

		]);
	}

	public function actionView($title)
	{
		$model = Contents::find()->where(['name'=>$title])->one();
		if (!$model) {
			throw new \yii\web\NotFoundHttpException('The requested page is not exists.111');
		}
		return $this->render('view', ['model'=>$model]);
	}

	public function actionCreate()
	{
		$model = new Contents;
		$model->setScenario('insert');
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			
			$model->save();
			return $this->redirect(['index']);
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->setScenario('update');
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {

			$model->save();
			return $this->redirect(['index']);
		}
		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionTrash($id)
	{
		$model = $this->findModel($id);
		$model->status = Contents::STATUS_DELETED;
		$model->save();
		return $this->redirect(['index']);
	}

	public function actionUntrash($id)
	{
		$model = $this->findModel($id);
		$model->status = Contents::STATUS_ACTIVE;
		$model->save();
		return $this->redirect(['index']);
	}

	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->delete();
		return $this->redirect(['index']);
	}

	public function actionTrashAll()
	{
		$ids = Yii::$app->request->post('data_ids');
		if ($ids) {
			//$ids = implode(',', $ids);
			Contents::updateAll(['status'=>Contents::STATUS_DELETED], ['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionUntrashAll()
	{
		$ids = Yii::$app->request->post('trash_data_ids');
		if ($ids) {
			Contents::updateAll(['status'=>Contents::STATUS_ACTIVE], ['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionDeleteAll()
	{
		$ids = Yii::$app->request->post('trash_data_ids');
		if ($ids) {
			Contents::deleteAll(['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionUpload()
	{
		$bucket = Yii::$app->params['qiniu']['bucket'];
		$accessKey = Yii::$app->params['qiniu']['accessKey'];
		$secretKey = Yii::$app->params['qiniu']['secretKey'];
		$action = Yii::$app->params['qiniu']['action'];
		$auth = new Auth($accessKey, $secretKey);
		$token = $auth->uploadToken($bucket);
		if (Yii::$app->request->isPost) {
			//var_dump($_FILES);
			$file = $_FILES['file'];
			$filePath = $file['tmp_name'];
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_file($finfo, $filePath);
			
			$key = 'mogu7-zghysb-'.date('YmdHis').'-'.uniqid().'.jpg';
			$uploadManager = new UploadManager;
			list($ret, $err) = $uploadManager->putFile($token, $key, $filePath);
			return Json::encode(['ret'=>$ret, 'err'=>$err]);
		} else {
			return $this->render('upload', [
				'token' => $token,
				'action' => $action,
			]);
		}
	}

	public function actionList()
	{
		// 获取地区数据
        $states = District::getStates();
        // 获取已有分部的地区数据
        $contents_states = Contents::getStateNames();
        // 根据上述数据整理地区列表
        $contents_states_list = [];
        foreach ($contents_states as $c) {
        	//$tmp[] = ['id'=>$c->state, 'text'=>$states[$c->state], 'url'=>Url::to(['/site/index', 'region'=>$c->state])];
        	$contents_states_list[$c->state] = ['text'=>$states[$c->state], 'url'=>Url::to(['/site/index', 'region'=>$c->state])];;
        }
        return Json::encode($contents_states_list);
	}

	public function actionContentList($q = null, $id = null)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q)) {
			$query = new \yii\db\Query;
			$data = $query->select('id, name as text')
				->from('contents')
				->where(['like', 'name', $q])
				->limit(20);
			$command = $query->createCommand();
			$data = $command->queryAll();
			$out['results'] = array_values($data);
		} else if ($id > 0) {
			$out['results'] = ['id' => $id, 'text' => Contents::find($id)->name];
		}
		return $out;
	}

	protected function findModel($id)
	{
		$model = Contents::findOne($id);
		if ($model) {
			return $model;
		} else {
			throw new \yii\web\NotFoundHttpException('The requested page is not exists.');
		}
	}
}