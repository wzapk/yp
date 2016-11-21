<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="am-g am-u-sm-6 am-u-sm-centered">
<?php $form = ActiveForm::begin(['options' => ['class' => 'am-form', 'enctype' => 'multipart/form-data']]) ?>

	<?= $form->field($model, 'excelFile')->fileInput(['accept'=>'text/plain']) ?>

	<?= Html::submitButton('Upload', ['class'=>'am-btn am-btn-sm']) ?>

<?php ActiveForm::end() ?>
</div>