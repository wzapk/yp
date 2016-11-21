<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Contents;

$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	'分部管理',
];

$attributeLabels = Contents::attributeLabels();
?>

<div class="am-tabs" data-am-tabs="{noSwipe: 1}">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active">
			<a href="#contents-list"><?= Yii::t('app/contents', 'Contents') ?> (<?= $active_pagination->totalCount ?>)</a>
		</li>
		<li>
			<a href="#contents-trash"><?= Yii::t('app/contents', 'Recycle') ?> (<?= $trash_count ?>)</a>
		</li>
	</ul>
	<div class="am-tabs-bd">
		<div id="contents-list" class="am-tab-panel am-active">
			<div class="toolbar">
				<ul class="menu">
					<li class="menu-item">
						<a href="<?= Url::to(['/contents/create']) ?>"><?= Yii::t('app', 'Add') ?></a>
					</li>
					<li class="menu-item">|</li>
					<li class="menu-item"><?= Yii::t('app', 'Batch operation:') ?></li>
					<li class="menu-item">
						<a href="#" role="trash_all"><?= Yii::t('app', 'Trash') ?></a>
					</li>
					
				</ul>
			</div>
			
			<div class="am-scrollable-horizontal">
				<?php ActiveForm::begin(['id'=>'active-data-list-form']) ?>
				<table id="active-data-list-table" class="am-table am-text-nowrap am-table-striped">
					<thead>
						<tr>
							<th class="check-column"><input type="checkbox" id="action_data_select_all"></th>
							<th>&nbsp;</th>
							<th><?= $attributeLabels['serial_no'] ?></th>
							<th><?= $attributeLabels['name'] ?></th>
							<th><?= $attributeLabels['manager'] ?></th>
							<th><?= $attributeLabels['phone'] ?></th>
							<th><?= $attributeLabels['weibo'] ?></th>
							<th><?= $attributeLabels['weixin'] ?></th>
							<th><?= $attributeLabels['qq'] ?></th>
							<th><?= $attributeLabels['created_at'] ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if (isset($active_contents)): ?>
						<?php if (count($active_contents)): foreach ($active_contents as $contents): ?>
						<tr aria-id="<?= $contents->id ?>" aria-checked="false">
							<td class="check-column"><input type="checkbox" name="data_ids[]" value="<?= $contents->id ?>"></td>
							<td class="action-column">
								<a href="<?= Url::to(['update', 'id'=>$contents->id]) ?>"><?= Yii::t('app', 'Edit') ?></a> | <a href="<?= Url::to(['trash', 'id'=>$contents->id]) ?>"><?= Yii::t('app', 'Trash') ?></a>
							</td>
							<td><?= Html::encode($contents->serial_no) ?></td>
							<td><?= Html::encode($contents->name) ?></td>
							<td><?= Html::encode($contents->manager) ?></td>
							<td><?= Html::encode($contents->phone) ?></td>
							<td><?= Html::encode($contents->weibo) ?></td>
							<td><?= Html::encode($contents->weixin) ?></td>
							<td><?= Html::encode($contents->qq) ?></td>

							<td><?= date('Y-m-d', $contents->created_at) ?></td>
						</tr>
						<?php endforeach; else: ?>
						<tr>
							<td colspan="10"><?= Yii::t('app', 'No data') ?></td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					</tbody>
				</table>
				<?php ActiveForm::end() ?>

			</div>
			<?= LinkPager::widget(['pagination' => $active_pagination, 'options'=>['class'=>'am-pagination']]) ?>
		</div>
		<div id="contents-trash" class="am-tab-panel">
			<div class="toolbar">
				<ul class="menu">
					<li class="menu-item"><?= Yii::t('app', 'Batch operation:') ?></li>
					<li class="menu-item">
						<a href="#" role="untrash_all"><?= Yii::t('app', 'Untrash') ?></a>
					</li>
					<li class="menu-item">|</li>
					<li class="menu-item">
						<a href="#" role="delete_all"><?= Yii::t('app', 'Delete') ?></a>
					</li>
				</ul>
			</div>
			<div class="am-scrollable-horizontal">
			<?php ActiveForm::begin(['id'=>'trash-data-list-form']) ?>
			<table id="trash-data-list-table" class="am-table am-table-striped am-text-nowrap">
				<thead>
					<tr>
						<th class="check-column"><input type="checkbox" id="action_trash_select_all"></th>
						<th class="action-column">&nbsp;</th>
						<th><?= $attributeLabels['serial_no'] ?></th>
							<th><?= $attributeLabels['name'] ?></th>
							<th><?= $attributeLabels['manager'] ?></th>
							<th><?= $attributeLabels['phone'] ?></th>
							<th><?= $attributeLabels['weibo'] ?></th>
							<th><?= $attributeLabels['weixin'] ?></th>
							<th><?= $attributeLabels['qq'] ?></th>
							<th><?= $attributeLabels['created_at'] ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if (isset($deactive_contents)): ?>
					<?php if (count($deactive_contents)): foreach ($deactive_contents as $contents): ?>
					<tr aria-id="<?= $contents->id ?>" aria-checked="false">
						<td class="check-column"><input type="checkbox" name="trash_data_ids[]" value="<?= $contents->id ?>"></td>
						<td class="action-column">
							<a href="<?= Url::to(['/contents/untrash', 'id'=>$contents->id]) ?>"><?= Yii::t('app', 'Untrash') ?></a> | <a href="<?= Url::to(['/contents/delete', 'id'=>$contents->id]) ?>"><?= Yii::t('app', 'Delete') ?></a>
						</td>
						<td><?= Html::encode($contents->serial_no) ?></td>
							<td><?= Html::encode($contents->name) ?></td>
							<td><?= Html::encode($contents->manager) ?></td>
							<td><?= Html::encode($contents->phone) ?></td>
							<td><?= Html::encode($contents->weibo) ?></td>
							<td><?= Html::encode($contents->weixin) ?></td>
							<td><?= Html::encode($contents->qq) ?></td>
						<td><?= date('Y-m-d', $contents->created_at) ?></td>
					</tr>
					<?php endforeach; else: ?>
					<tr>
						<td colspan="10"><?= Yii::t('app', 'No data') ?></td>
					</tr>
					<?php endif; ?>
				<?php endif; ?>
				</tbody>
			</table>
			<?php ActiveForm::end() ?>
			</div>
		</div>
	</div>
</div>

<?php
$js = "
	$.fn.crud({
		'url':{
			'trash': '".Url::to(['trash-all'])."',
			'untrash': '".Url::to(['untrash-all'])."',
			'destroy': '".Url::to(['delete-all'])."'
		}
	});
";
$this->registerJs($js);
$this->registerJsFile('@web/js/crud.js', ['depends'=>'yii\web\JqueryAsset']);