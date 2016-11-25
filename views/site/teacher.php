<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\fancyBox\FancyBoxBundle;

/* @var $this yii\web\View */
/* @var $teacher app\models\Teachers */

FancyBoxBundle::register($this);
$this->title = Yii::$app->name;
?>
<div class="site-teacher am-u-md-6 am-u-md-centered">
    <?= DetailView::widget([
        'options' => [
            'class' => 'am-table',
        ],
        'model' => $teacher,
        'attributes' => [
            'name',
            'serial_no',
            [
                'attribute' => 'cid',
                'value' => Html::a($teacher->content->name,['/site/view', 'id'=>$teacher->content->id]),
                'format' => 'raw',
            ],
            [
                'attribute' => 'avatar',
                'value' => Html::a('<img src="'.$teacher->avatar.'" style="max-height:84px;width:auto">', $teacher->avatar, ['class'=>'avatar-fancybox']),
                'format' => 'raw',
            ],
            [
                'attribute' => 'certificate',
                'value' => Html::a('<img src="'.$teacher->certificate.'" style="max-height:84px;width:auto">', $teacher->certificate, ['class'=>'certificate-fancybox']),
                'format' => 'raw',
            ],
            [
                'attribute' => 'contact',
                'value' => $teacher->content->phone,
            ],
            //'phone',
        ],
    ]) ?>
</div>
<?php
$this->registerJs("

    $('.avatar-fancybox').fancybox();
    $('.certificate-fancybox').fancybox();

");