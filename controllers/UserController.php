<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\Controller;
use yii\data\Pagination;

class UserController extends BackendController
{
	/*
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
	*/

	public function actionIndex()
	{
		$active_users_query = User::find()->where(['status'=>User::STATUS_ACTIVE])->orderBy('created_at desc');
		$active_count = $active_users_query->count();
		$active_pagination = new Pagination(['totalCount' => $active_count]);
		$active_users = $active_users_query
			->offset($active_pagination->offset)
			->limit($active_pagination->limit)
			->with('roles')
			->all();

		$deactive_users_query = User::find()->where(['status'=>User::STATUS_DELETED])->orderBy('created_at desc');
		$trash_count = $deactive_users_query->count();
		$deactive_users = $deactive_users_query->all();

		return $this->render('index', [
			'active_users' => $active_users,
			'active_pagination' => $active_pagination,

			'deactive_users' => $deactive_users,
			'trash_count' => $trash_count,

		]);
	}

	public function actionCreate()
	{
		$model = new User;
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->generateAuthKey();
			$newPassword = uniqid();
			$model->password = $newPassword;
			if ($model->save()) {

				$account = [
					'username' => $model->username,
					'email' => $model->email,
					'password' => $newPassword,
				];
				

	            // 设置权限
				$auth = Yii::$app->authManager;
				$post_role = Yii::$app->request->post('role');
				if ($post_role && $post_role!='-1') {
					$role = $auth->getRole($post_role);
				} else {
					$role = $auth->getRole('member');
				}
				$auth->assign($role, $model->id);

				// 发送注册邮件
				Yii::$app
	            ->mailer
	            ->compose(
	                ['html' => 'createNewAccount-html'],
	                ['user' => $account]
	            )
	            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
	            ->setTo($model->email)
	            ->setSubject(Yii::t('app', 'Account information for {u}', ['u' => \Yii::$app->name]))
	            ->send();
	            
				// 转到用户管理首页
				return $this->redirect(['index']);
			}
		} 
		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();
			$auth = Yii::$app->authManager;
			$post_role = Yii::$app->request->post('role');
			if ($post_role) {
				$role = $auth->getRole($post_role);
			} else {
				$role = $auth->getRole('member');
			}
			$auth->revokeAll($model->id);
			$auth->assign($role, $model->id);

			return $this->redirect(['index']);
		}
		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionTrash($id)
	{
		$model = $this->findModel($id);
		$model->status = User::STATUS_DELETED;
		$model->save();
		return $this->redirect(['index']);
	}

	public function actionUntrash($id)
	{
		$model = $this->findModel($id);
		$model->status = User::STATUS_ACTIVE;
		$model->save();
		return $this->redirect(['index']);
	}

	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$auth = Yii::$app->authManager;
		$auth->revokeAll($id);
		$model->delete();
		return $this->redirect(['index']);
	}

	public function actionTrashAll()
	{
		$ids = Yii::$app->request->post('user_ids');
		if ($ids) {
			//$ids = implode(',', $ids);
			User::updateAll(['status'=>User::STATUS_DELETED], ['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionUntrashAll()
	{
		$ids = Yii::$app->request->post('trash_user_ids');
		if ($ids) {
			User::updateAll(['status'=>User::STATUS_ACTIVE], ['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionDeleteAll()
	{
		$ids = Yii::$app->request->post('trash_user_ids');
		if ($ids) {
			User::deleteAll(['in', 'id', $ids]);
		}
		return $this->redirect(['index']);
	}

	public function actionSetPassword()
	{
		$pwd = Yii::$app->request->post('pwd');
		$id = Yii::$app->request->post('id');
		if ($pwd && $id) {
			$model = $this->findModel($id);
			$model->password = $pwd;
			$model->save();
		}
		return $this->redirect(['index']);
	}

	protected function findModel($id)
	{
		$model = User::findOne($id);
		if ($model) {
			return $model;
		} else {
			throw new \yii\web\NotFoundHttpException('The requested page is not exists.');
		}
	}
}