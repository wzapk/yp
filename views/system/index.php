<?php
/* $models app\models\Options */
use app\models\Options;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	'系统管理',
];
?>

<div class="am-tabs" data-am-tabs="{noSwipe: 1}" id="trash-data-list-table">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active">
			<a href="#options-list"><?= Yii::t('app/options', 'Options') ?> (<?= $pagination->totalCount ?>)</a>
		</li>
		<li>
			<a href="#files-list"><?= Yii::t('app/options', 'Files') ?></a>
		</li>
	</ul>
	<div class="am-tabs-bd">
		<div id="options-list" class="am-tab-panel am-active">
			<div class="toolbar">
				<ul class="menu">
					<li class="menu-item">
						<a href="<?= Url::to(['/system/create']) ?>"><?= Yii::t('app', 'Add') ?></a>
					</li>
					<li class="menu-item">|</li>
					<li class="menu-item"><?= Yii::t('app', 'Batch operation:') ?></li>
					<li class="menu-item">
						<a href="#" role="delete_all"><?= Yii::t('app', 'Delete') ?></a>
					</li>
					
				</ul>
			</div>
		
			<div class="am-scrollable-horizontal">
				<?php $form = ActiveForm::begin(['id'=>'trash-data-list-form']) ?>
				<table class="am-table">
					<thead>
						<tr>
							<th class="check-column"><input type="checkbox" id="action_data_select_all"></th>
							<th class="action-column">&nbsp;</th>
							<th><?= Yii::t('app/options', 'Description') ?></th>
							<th><?= Yii::t('app/options', 'Key') ?></th>
							<th><?= Yii::t('app/options', 'Value') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if (count($models)): foreach ($models as $model): ?>
						<tr aria-checked="false" aria-id="<?= $model->id ?>">
							<td class="check-column"><input type="checkbox" name="data_ids[]" value="<?= $model->id ?>"></td>
							<td class="action-column" style="width:20%"><a href="<?= Url::to(['/system/update', 'id'=>$model->id]) ?>"><?= Yii::t('app', 'Edit') ?></a> | <a href="<?= Url::to(['/system/delete', 'id'=>$model->id]) ?>" date-method="post" data-confirm="真的要删除这条数据吗？"><?= Yii::t('app', 'Delete') ?></a></td>
							<td><?= Html::encode($model->description) ?></td>
							<td><?= Html::encode($model->key) ?></td>
							<td><?= Html::encode($model->value) ?></td>
						</tr>
					<?php endforeach; endif; ?>
					</tbody>
				</table>
				<?php ActiveForm::end() ?>
				<?= LinkPager::widget(['pagination' => $pagination, 'options'=>['class'=>'am-pagination','style'=>'font-size:12px;padding:0 10px']]) ?>
			</div>
		</div>

		<div id="files-list" class="am-tab-panel">
			<p>共有无效文件 0 个<span style="margin-left:10px"><?= Html::a('立即清理', ['/system/file-clean'], ['class'=>'am-btn am-btn-sm am-btn-warning']) ?></span></p>
		</div>
	</div>
</div>

<?php $this->registerJsFile('@web/js/crud.js', ['depends'=>'yii\web\JqueryAsset']) ?>
<?php $this->registerJs("
	$.fn.crud({
		'url': {
			'destroy': '".Url::to(['/system/delete-all'])."'
		}
	})
") ?>