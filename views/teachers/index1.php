<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TeachersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/teacher', 'Teachers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/teacher', 'Create Teachers'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return Html::a($data->name, ['view', 'id'=>$data->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'cid',
                'value' => function($data) {
                    return $data->content->name;
                },
            ],
            
            [
                'attribute' => 'avatar',
                'format' => [
                    'image',
                    [
                        'width' => '84',
                        'height' => '84',
                    ],
                ],
            ],
            [
                'attribute' => 'certificate',
                'format' => [
                    'image',
                    [
                        'width' => '84',
                        'height' => '84',
                    ],
                ],
            ],
            // 'contact',
            'phone',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
