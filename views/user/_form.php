<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="user-form" style="padding:0 10px">
<?php $form = ActiveForm::begin([
	'successCssClass' => 'am-form-success',
	'errorCssClass' => 'am-form-error',
	'options' => ['class' => 'am-form']
]) ?>

	<?= $form->field($model, 'username', ['options'=>['class'=>'am-form-group am-form-group-sm']])->textInput(['class'=>'am-form-field']) ?>

	<?= $form->field($model, 'email', ['options'=>['class'=>'am-form-group am-form-group-sm']])->textInput(['class'=>'am-form-field']) ?>

	<div class="am-form-group am-form-group-sm">
		<label for="user-role">角色</label>
		<?php $roles = Yii::$app->authManager->getRoles();
			$roles_options = ['-1' => '无'];
			foreach ($roles as $role) {
				$roles_options[$role->name] = $role->description;
			}
			$has_roles = Yii::$app->authManager->getRolesByUser($model->id);
			$model_role = null;
			if ($has_roles) {
				foreach($has_roles as $key => $has_role) {
					$model_role = $key;
					break;
				}
			}
		?>
		<?= Html::dropdownList('role', $model_role, $roles_options, ['class'=>'am-form-field', 'style'=>'width:150px']) ?>
	</div>

	<?= Html::submitButton($model->isNewRecord ? '创建':'保存', ['class'=>'am-btn am-btn-sm am-btn-primary']) ?>

<?php ActiveForm::end(); ?>
</div>