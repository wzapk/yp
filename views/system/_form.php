<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="am-u-sm-6">
<?php $form = ActiveForm::begin([
	'id'=>'system-form',
	'successCssClass'=>'am-form-success',
	'errorCssClass'=>'am-form-error', 
	'options'=>[
		'class'=>'am-form'
	]
]) ?>

	<?= $form->field($model, 'description', ['options'=>['class'=>'am-form-group am-form-group-sm']])->textInput(['class'=>'am-form-field']) ?>

	<?php if ($model->isNewRecord): ?>
		<?= $form->field($model, 'key', ['options'=>['class'=>'am-form-group am-form-group-sm']])->textInput(['class'=>'am-form-field']) ?>
	<?php else: ?>
		<div class="am-form-group am-form-group-sm am-form-warning">
			<label for="options-key"><?= $model->getAttributeLabel('key') ?></label>
			<div><?= Html::encode($model->key) ?></div>
			<div class="help-block">注意：编辑模式下不允许更改键名称。</div>
		</div>
	<?php endif; ?>
	<?= $form->field($model, 'value', ['options'=>['class'=>'am-form-group am-form-group-sm']])->textInput(['class'=>'am-form-field']) ?>

	<?= Html::submitButton(Yii::t('app', 'Save'), ['class'=>'am-btn am-btn-sm am-btn-primary']) ?>

<?php ActiveForm::end() ?>
</div>