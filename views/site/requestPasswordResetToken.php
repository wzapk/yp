<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = Yii::t('app', 'Request password reset');
//$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="am-u-sm-10 am-u-sm-centered">
<div class="site-request-password-reset" style="margin:30px 0;">
    <h2><?= Html::encode($this->title) ?></h2>

    <p><?= Yii::t('app', 'Please fill out your email. A link to reset password will be sent there.') ?></p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="am-alert am-alert-success">
            <p><?= Yii::$app->session->getFlash('success') ?></p>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div class="am-alert am-alert-danger">
            <p><?= Yii::$app->session->getFlash('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form', 
                'options'=>['class'=>'am-form'],
                'errorCssClass' => 'am-form-error',
                'successCssClass' => 'am-form-success'
            ]); ?>
                
                <?= $form->field($model, 'email', ['options' => ['class' => 'am-form-group am-form-group-sm']])->textInput(['class' => 'am-form-field']) ?>

                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'am-btn am-btn-sm am-btn-primary']) ?>

            <?php ActiveForm::end(); ?>
        </div>
        
    </div>
</div>
    
</div>
