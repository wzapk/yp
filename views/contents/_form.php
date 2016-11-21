<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Contents;
use app\models\District;
?>

<div class="contents-form" style="padding:0 10px;margin-bottom:60px;">
<?php $form = ActiveForm::begin([
	'successCssClass' => 'am-form-success',
	'errorCssClass' => 'am-form-error',
	'options' => ['class' => 'am-form'],
	'fieldConfig' => [
		'template'=>"{label}\n{input}\n",
		'options' => ['class' => 'am-form-group am-form-group-sm'],
		'inputOptions' => ['class' => 'am-form-field'],
	],
]) ?>

	<?= $form->field($model, 'serial_no')->textInput() ?>

	<?= $form->field($model, 'name')->textInput() ?>

	<?= $form->field($model, 'manager')->textInput() ?>

	<?= $form->field($model, 'business_scope')->textInput() ?>

	<?= $form->field($model, 'taobao')->textInput() ?>

	<?= $form->field($model, 'homepage')->textInput() ?>

	<?= $form->field($model, 'location')->hiddenInput()->label(false) ?>

	<div class="am-form-group am-form-group-sm">
		<label for=""><?= $model->getAttributeLabel('location') ?></label>
		<div class="am-g am-cf">
			<div class="am-container">
				<span id="location-value-preview" style="color:#999;font-size:12px"><?= $model->location ?></span>
			</div>
			<div class="am-u-sm-4">
				<?= $form->field($model, 'state')
					->dropdownList(District::getStates(),['prompt'=>'选择省份'])
					->label(false) ?>
			</div>
			<div class="am-u-sm-4">
				<?= $form->field($model, 'city')
					->dropdownList(District::getCities($model->state),['prompt'=>'选择城市'])
					->label(false) ?>
			</div>
			<div class="am-u-sm-4">
				<?= $form->field($model, 'region')
					->dropdownList(District::getRegions($model->state, $model->city),['prompt'=>'选择区/县'])
					->label(false) ?>
			</div>
		</div>
	</div>
	
	<?= $form->field($model, 'address')->textInput() ?>

	<?= $form->field($model, 'phone')->textInput(['style'=>'width:150px']) ?>

	<div class="am-g am-cf">
		<?= $form->field($model, 'qq', ['options'=>['class'=>'am-u-sm-4 am-form-group am-form-group-sm']])->textInput() ?>

		<?= $form->field($model, 'weixin', ['options'=>['class'=>'am-u-sm-4 am-form-group am-form-group-sm']])->textInput() ?>

		<?= $form->field($model, 'weibo', ['options'=>['class'=>'am-u-sm-4 am-form-group am-form-group-sm']])->textInput() ?>
	</div>

	<?= $form->field($model, 'remark')->textInput() ?>

	<?php
	/*
	$form->field($model, 'thumbnail', [
		'options'=>[
			'class'=>'am-form-group am-form-file',
		],
		'template'=>'<button type="button" class="am-btn am-btn-default am-btn-sm"><i class="am-icon-cloud-upload"></i> 选择要上传的图片</button>{input}'
		
	])->fileInput() ?>
	<div id="file-list"></div>
	*/
	?>
	<?php if ($model->thumbnail): ?>
	<div class="wp-core-ui">
		<div class="media-list-content" data-columns="3">
			<div class="attachments-browser">
				<ul class="attachments">
					<li class="attachment">
						<div class="attachment-preview portrait">
							<div class="thumbnail1">
								<div class="centered">
									<img src="<?= Contents::getThumbnailUrl() . '/' . $model->thumbnail ?>" alt="">
								</div>

							</div>
						</div>
						<div class="filename">
							<div style="font-size:12px;color:#900">保存后才能看到新图片的预览</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<?php endif; ?>
	<?= Html::submitButton(Yii::t('app', 'Save'), ['class'=>'am-btn am-btn-sm am-btn-primary']) ?>

<?php ActiveForm::end(); ?>
</div>

<?php
$this->registerCssFile('@web/css/media-views.css');
$js = "

$('#contents-thumbnail').on('change', function() {
      var fileNames = '';
      $.each(this.files, function() {
        fileNames += '<span class=\"am-badge\">' + this.name + '</span> ';
      });
      $('#file-list').html(fileNames);
});

var updateLocationValue = function() {
	var s = $('#contents-state').find('option:selected').text(),
		c = $('#contents-city').find('option:selected').text(),
		r = $('#contents-region').find('option:selected').text(),
		text = (s=='请选择……' ? '':s) 
			+ (c=='请选择……' || c=='市辖区' || c=='县' || c=='省直辖行政单位' ? '':c) 
			+ (r=='请选择……' || r=='市辖区' ? '':r);
	$('#contents-location').val(text);
	$('#location-value-preview').html(text);
};

var locationChanged = function(url, param, select, updated) {
	var o = $(select);
	$.ajax({
		url: url,
		method: 'get',
		data: param,
		dataType: 'json',
		success: function(response){
			//console.log(response);
			o.html('');
			o.append('<option value=\"-1\">请选择……</option>');
			$.each(response, function(idx, resp){
				o.append('<option value=\"'+resp.k+'\">'+resp.v+'</option>');
			});
			o.removeAttr('disabled');
			if (updated) {
				updateLocationValue();
			}
		}
	});
};

//locationChanged('".Url::to(['/district/state'])."', {}, '#contents-state', false);

$('#contents-state').on('change', function(){
	var p_id = $(this).val();
	$('#contents-region').html('').attr('disabled','');
	locationChanged('".Url::to(['/district/city'])."', {p_id:p_id}, '#contents-city', true);
});
$('#contents-city').on('change', function(){
	var c_id = $(this).val();
	var p_id = $('#contents-state').val();
	locationChanged('".Url::to(['/district/region'])."', {p_id:p_id, c_id:c_id}, '#contents-region', true);
});
$('#contents-region').on('change', function(){
	updateLocationValue();
})

";
$this->registerJs($js);