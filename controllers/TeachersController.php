<?php

namespace app\controllers;

use Yii;
use app\models\Teachers;
use app\models\TeachersSearch;
use app\models\Options;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\data\Pagination;

/**
 * TeachersController implements the CRUD actions for Teachers model.
 */
class TeachersController extends BackendController
{
    protected $uploadAvatarPath;
    protected $uploadCertificatePath;
    protected $avatarUrl;
    protected $certificateUrl;

    public function init()
    {
        parent::init();
        $this->uploadAvatarPath = Yii::getAlias(Options::v('avatarPath', '@webroot/uploads/avatar'));
        $this->uploadCertificatePath = Yii::getAlias(Options::v('certificatePath', '@webroot/uploads/certificate'));
        $this->avatarUrl = Yii::getAlias(Options::v('avatarUrl', '@web/uploads/avatar'));
        $this->certificateUrl = Yii::getAlias(Options::v('certificateUrl', '@web/uploads/certificate'));
    }

    /**
     * @inheritdoc
     */
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Teachers models.
     * @return mixed
     */
    protected function old_index()
    {
        $searchModel = new TeachersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $active_teachers_query = Teachers::find()->where(['status'=>Teachers::STATUS_ACTIVE])->orderBy('created_at desc');
        $active_count = $active_teachers_query->count();
        $active_pagination = new Pagination(['totalCount' => $active_count]);
        $active_teachers = $active_teachers_query
            ->offset($active_pagination->offset)
            ->limit($active_pagination->limit)
            ->all();

        $deactive_teachers_query = Teachers::find()->where(['status'=>Teachers::STATUS_DELETED])->orderBy('created_at desc');
        $trash_count = $deactive_teachers_query->count();
        $deactive_teachers = $deactive_teachers_query->all();

        return $this->render('index', [
            'active_teachers' => $active_teachers,
            'active_pagination' => $active_pagination,

            'deactive_teachers' => $deactive_teachers,
            'trash_count' => $trash_count,

        ]);
    }

    /**
     * Displays a single Teachers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Teachers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teachers();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post('Teachers');
            $model->cid = $post['cid'];
            $model->name = $post['name'];
            //$model->serial_no = $post['serial_no'];
            //$model->contact = $post['contact'];
            if ($model->validate()) {
                if (UploadedFile::getInstance($model, 'avatar')) {
                    $model->avatar = UploadedFile::getInstance($model, 'avatar');
                    $avatarFilename = uniqid().'-'.date('YmdHis').'.'.$model->avatar->extension;
                    $dir = $this->uploadAvatarPath . '/' . $avatarFilename;
                    $model->avatar->saveAs($dir);
                    $model->avatar = $this->avatarUrl .'/'.$avatarFilename;
                }
                if (UploadedFile::getInstance($model, 'certificate')) {
                    $model->certificate = UploadedFile::getInstance($model, 'certificate');
                    $certificateFilename = uniqid().'-'.date('YmdHis').'.'.$model->certificate->extension;
                    $dir = $this->uploadCertificatePath . '/' . $certificateFilename;
                    $model->certificate->saveAs($dir);
                    $model->certificate = $this->certificateUrl . '/' . $certificateFilename;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Teachers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post('Teachers');
            $model->cid = $post['cid'];
            $model->name = $post['name'];
            //$model->serial_no = $post['serial_no'];
            //$model->contact = $post['contact'];
            if ($model->validate()) {
                if (UploadedFile::getInstance($model, 'avatar')) {
                    $model->avatar = UploadedFile::getInstance($model, 'avatar');
                    $avatarFilename = uniqid().'-'.date('YmdHis').'.'.$model->avatar->extension;
                    $dir = $this->uploadAvatarPath . '/' . $avatarFilename;
                    $model->avatar->saveAs($dir);
                    $model->avatar = $this->avatarUrl .'/'.$avatarFilename;
                }
                if (UploadedFile::getInstance($model, 'certificate')) {
                    $model->certificate = UploadedFile::getInstance($model, 'certificate');
                    $certificateFilename = uniqid().'-'.date('YmdHis').'.'.$model->certificate->extension;
                    $dir = $this->uploadCertificatePath . '/' . $certificateFilename;
                    $model->certificate->saveAs($dir);
                    $model->certificate = $this->certificateUrl . '/' . $certificateFilename;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } 
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        $model->status = Teachers::STATUS_DELETED;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionUntrash($id)
    {
        $model = $this->findModel($id);
        $model->status = Teachers::STATUS_ACTIVE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Teachers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTrashAll()
    {
        $ids = Yii::$app->request->post('data_ids');
        if ($ids) {
            //$ids = implode(',', $ids);
            Teachers::updateAll(['status'=>Teachers::STATUS_DELETED], ['in', 'id', $ids]);
        }
        return $this->redirect(['index']);
    }

    public function actionUntrashAll()
    {
        $ids = Yii::$app->request->post('trash_data_ids');
        if ($ids) {
            Teachers::updateAll(['status'=>Teachers::STATUS_ACTIVE], ['in', 'id', $ids]);
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        $ids = Yii::$app->request->post('trash_data_ids');
        if ($ids) {
            Teachers::deleteAll(['in', 'id', $ids]);
        }
        return $this->redirect(['index']);
    }


    /**
     * Finds the Teachers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teachers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teachers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
