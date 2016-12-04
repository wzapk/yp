<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Teachers */

$this->title = Yii::t('app/teacher', 'Create Teachers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/teacher', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
