<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Contents;
use app\components\fancyBox\FancyBoxBundle;
/* @var $this yii\web\View */
/* @var $model app\models\Teachers */

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/teacher', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

FancyBoxBundle::register($this);
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
                'value' => Html::a('<img src="'.$model->avatar.'" style="max-height:84px;width:auto">', $model->avatar, ['class'=>'avatar-fancybox']),
                'format' => 'raw',
            ],
            [
                'attribute' => 'certificate',
                'value' => Html::a('<img src="'.$model->certificate.'" style="max-height:84px;width:auto">', $model->certificate, ['class'=>'certificate-fancybox']),
                'format' => 'raw',
            ],
            'contact',
            'phone',
        ],
    ]) ?>

</div>
<?php
$this->registerJs("

    $('.avatar-fancybox').fancybox();
    $('.certificate-fancybox').fancybox();

");