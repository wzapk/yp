<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\models\Contents;

/* @var $this yii\web\View */
/* @var $model app\models\Teachers */
/* @var $form yii\widgets\ActiveForm */

$url = Url::to(['/contents/content-list']);
?>

<div class="teachers-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'am-form',
            "enctype" => "multipart/form-data"
        ],
        'successCssClass' => false,
        'errorCssClass' => 'am-form-error',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'options' => ['class'=>'am-form-group am-form-group-sm'],
            'inputOptions' => ['class'=>'am-form-field'],
            'errorOptions' => ['class' => 'am-form-help', 'tag'=>'p'],
            'labelOptions' => ['class' => false],
        ],
    ]); ?>

	<?php $content = empty($model->cid) ? '' : Contents::findOne($model->cid)->name; ?>
    <?= $form->field($model, 'cid')->widget(Select2::className(), [
    	'initValueText' => $content,
    	'options' => ['placeholder' => '输入分部名称'],
    	'pluginOptions' => [
    		'allowClear' => true,
    		'minimumInputLength' => 2,
    		'language' => [
    			'errorLoading' => new JsExpression("function() { return 'waiting for results...'; }"),
    		],
    		'ajax' => [
    			'url' => $url,
    			'dataType' => 'json',
    			'data' => new JsExpression('function(params) { return {q:params.term}; }'),
    		],
    		'escapeMarkup' => new JsExpression('function(markup) { return markup; }'),
    		'templateResult' => new JsExpression('function(content) { return content.text; }'),
    		'templateSelection' => new JsExpression('function(content) { return content.text; }'),
    	],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    

	<div class="well well-small">
    <?= $form->field($model, 'avatar')->widget(FileInput::className(), [
    	'options' => ['accept' => 'image/*', 'multiple' => false],
    	'pluginOptions' => [
    		'previewFileType' => 'image',
    		'initialPreview' => [$model->avatar],
    		'initialPreviewAsData' => true,
    		'showCaption' => false,
    		'showRemove' => false,
    		'showUpload' => false,
    		'browseLabel' => Yii::t('app/teacher', 'Select Photo'),
    		'elCaptionText' => '#customAvatarCaption'
    	],

    ]) ?>
    <span id="customAvatarCaption" class="text-success"><?= Yii::t('app/teacher', 'No file selected') ?></span>
    </div>

	<div class="well well-small">
    <?= $form->field($model, 'certificate')->widget(FileInput::classname(), [
    	'options' => ['accept' => 'image/*', 'multiple' => false],
    	'pluginOptions' => [
    		'previewFileType' => 'image',
    		'initialPreview' => [$model->certificate],
    		'initialPreviewAsData' => true,
    		'browseClass' => 'btn btn-default',
    		'showCaption' => false,
    		'showRemove' => false,
    		'showUpload' => false,
    		'browseLabel' => Yii::t('app/teacher', 'Select Photo'),
    		'elCaptionText' => '#customCertificateCaption'
    	],
    ]) ?>
    <span id="customCertificateCaption" class="text-success"><?= Yii::t('app/teacher', 'No file selected') ?></span>
    </div>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/teacher', 'Create') : Yii::t('app/teacher', 'Update'), ['class' => $model->isNewRecord ? 'am-btn am-btn-success' : 'am-btn am-btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
