<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Request password reset success!');
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="am-u-sm-10 am-u-sm-centered">
<div class="site-request-password-reset" style="margin:30px 0;">
    <h2><?= Html::encode($this->title) ?></h2>
    <p><?= Yii::t('app', 'Check your email for further instructions.') ?></p>
</div>
</div>