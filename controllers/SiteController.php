<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Contents;
use app\models\Teachers;
use app\models\District;
use app\models\ResetPasswordForm;
use app\models\PasswordResetRequestForm;
use yii\data\Pagination;
use app\components\detect\BrowserDetect;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            */
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
    	// 检测客户端是否为移动手机
        $isMobile = BrowserDetect::is_mobile();

        // 根据客户端决定分页数量
        $pageSize = $isMobile ? 20 : 30;

        // 按检索条件分页查询数据
        $contents_query = Contents::find()->where(['status'=>Contents::STATUS_ACTIVE])->orderBy('created_at desc');

        $search_condition = $query_region = '';

        if (Yii::$app->request->isPost) {
            $query_str = Yii::$app->request->post('query');
            if ($query_str) {
                // 分割查询关键字
            	$query = explode(' ', $query_str);
                // 第一次条件标志
                $first_flag = true;
                
                foreach ($query as $q) {
                	$q = strtolower(trim($q));
                	if ($first_flag) {
                        // 第一个条件使用andWhere
                		$contents_query = $contents_query->andWhere(['like', 'CONCAT(name,manager,serial_no,location,address,business_scope,phone)', $q]);
                	} else {
                        // 第n个条件使用orWhere
                		$contents_query = $contents_query->orWhere(['like', 'CONCAT(name,manager,serial_no,location,address,business_scope,phone)', $q]);
                	}
                	$first_flag = false;
                }
                $search_condition = $query_str;
            }
        } else if (Yii::$app->request->isGet) {
            // 点击了侧边栏的地区链接
        	$query_region = Yii::$app->request->get('region');
        	if ($query_region) {
                // 设置条件为该地区的数据
        		$contents_query->andWhere(['state'=>$query_region]);
        	}
        }
        // 总数
        $count = $contents_query->count();
        // 分页
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
        // 查询数据
        $contents = $contents_query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (!$isMobile) {
            // 获取地区数据
            $states = District::getStates();
            // 获取已有分部的地区数据
            $contents_states = Contents::getStateNames();
            $stateSum = Contents::getStateSum();
            $stateSum = ArrayHelper::map($stateSum, 'state', 'stateCount');
            // 根据上述数据整理地区列表
            $contents_states_list = [];
            foreach ($contents_states as $c) {
            	$contents_states_list[$c->state] = $states[$c->state].' ('.$stateSum[$c->state].')';
            }

        }
        // 传递给index页面的数据
        $data = [
            // 分部数据
            'contents' => $contents,
            // 分页信息
            'pagination' => $pagination,
            // 搜索条件
            'search_condition' => $search_condition,
            // 地区条件
            'query_region' => $query_region,
            // 是否为移动端
            'isMobile' => $isMobile,
            //'contents_states_list' => $contents_states_list,
        ];

        if (!$isMobile) {
            // PC端则传递地区列表数据
            $data['contents_states_list'] = $contents_states_list;
        }
        return $this->render('index-table', $data);
    }

    // 显示分部信息
    public function actionView($id)
    {
        $content = Contents::findOne($id);
        if ($content) {
            return $this->render('view', [
                'con' => $content,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException('未找到分部数据');
        }
    }

    // 显示教师列表
    public function actionTeachers()
    {
        // 检测客户端是否为移动手机
        $isMobile = BrowserDetect::is_mobile();

        // 根据客户端决定分页数量
        $pageSize = $isMobile ? 20 : 30;
        
        $query = Teachers::find()->where(['status'=>Teachers::STATUS_ACTIVE])->orderBy('name');
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $teachers = $query->limit($pagination->limit)->offset($pagination->offset)->all();

        return $this->render('teachers', [
            'teachers' => $teachers,
            'pagination' => $pagination,
            'isMobile' => $isMobile,
        ]);
    }

    // 显示教师详细信息
    public function actionTeacher($id)
    {
        $pagination = new Pagination;
        $teacher = Teachers::find()->where(['status'=>Teachers::STATUS_ACTIVE, 'id'=>$id])->with('content')->one();
        return $this->render('teacher', [
            'teacher' => $teacher,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(['/m/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                if ($model->sendEmail()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                    return $this->render('passwordResetRequestSuccess');
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
                }
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
