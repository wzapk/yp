<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contents */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/contents', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/contents', 'Update'), ['update', 'id' => $model->id], ['class' => 'am-btn am-btn-primary']) ?>
        <?= Html::a(Yii::t('app/contents', 'Recycle'), ['trash', 'id' => $model->id], ['class' => 'am-btn am-btn-warning']) ?>
        <?= Html::a(Yii::t('app/contents', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'am-btn am-btn-danger',
            'data' => [
                'confirm' => Yii::t('app/contents', 'Are you sure you want to delete this item?'),
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
            'manager',
            'phone',
            'business_scope',
            'address'
        ],
    ]) ?>

</div>
