<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Contents;
/* @var $this yii\web\View */
/* @var $model app\models\Teachers */

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/teacher', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/teacher', 'Update'), ['update', 'id' => $model->id], ['class' => 'am-btn am-btn-primary']) ?>
        <?= Html::a(Yii::t('app/teacher', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'am-btn am-btn-danger',
            'data' => [
                'confirm' => Yii::t('app/teacher', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'options' => [
            'class' => 'am-table',
        ],
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'cid',
                'value' => $model->content->name,
            ],
            [
                'attribute' => 'avatar',
                'format' => [
                    'image',
                    [
                        'width' => 84,
                        'height' => 84,
                    ]
                ]
            ],
            [
                'attribute' => 'certificate',
                'format' => [
                    'image',
                    [
                        'width' => 84,
                        'height' => 84,
                    ]
                ]
            ],
            'contact',
            'phone',
        ],
    ]) ?>

</div>
