<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title = '登录';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <div class="am-u-md-6 am-u-sm-centered site-login-wrapper">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
            <?php $form = ActiveForm::begin([
                    'id' => 'login-form', 
                    'options' => ['class' => 'am-form'],
                    'errorCssClass' => 'am-form-error',
                    'successCssClass' => 'am-form-success',
            ]); ?>

                <?= $form->field($model, 'identity', ['options'=>['class'=>'am-form-group am-form-group-sm']])
                    ->textInput([
                        'autofocus' => true, 
                        'class' => 'am-form-field', 
                        'placeholder' => 'Email'
                    ]) -> label(false) ?>

                <?= $form->field($model, 'password', ['options'=>['class'=>'am-form-group am-form-group-sm']])
                    ->passwordInput(['class' => 'am-form-field', 'placeholder' => '密码'])
                    ->label(false) ?>

                <div class="am-form-group">
                    <a href="<?= Url::to(['/site/request-password-reset']) ?>">找回密码</a>
                </div>

                <?= $form->field($model, 'rememberMe', ['options'=>['class'=>'am-form-group am-form-group-sm']])->checkbox() ?>

                <div class="am-form-group">
                    <?= Html::submitButton('登录', ['class' => 'am-btn am-btn-primary am-btn-sm', 'name' => 'login-button', 'style' => 'margin-right:20px']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        
    </div>

</div>
