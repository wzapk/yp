<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Teachers */

$this->title = Yii::t('app/teacher', 'Update Teachers: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/teacher', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/teacher', 'Update');
?>
<div class="teachers-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
