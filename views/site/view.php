<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Contents;

$teachers = $con->teachers;
// 要显示的字段，按数组顺序排序
$fields = [
	'serial_no',
	'manager',
	'business_scope',
	'state',
	'address',
	'phone',
	'taobao',
	'homepage',
	'weibo',
	'weixin',
	'qq',
];
?>
<div class="am-u-md-6">
	<div class="am-list-news am-list-news-default">
		<div class="am-list-news-hd am-cf">
			<h2><?= Html::encode($con->name) ?></h2>
		</div>
		<div class="am-list-news-bd">
			<table class="am-table">
				<tbody>
				<?php foreach ($fields as $field): ?>
				
					<tr>
						<td><?= $con->attributeLabels()[$field] ?></td>
						<th><?= Html::encode($con->$field) ?></th>
					</tr>
						
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<div class="am-u-md-6">
	<div class="am-list-news am-list-news-default">
		<div class="am-list-news-hd am-cf">
			<a href="javascript:;"><h2>认证教师</h2></a>
		</div>
		<div class="am-list-news-bd">
		<?php if (count($teachers)): ?>
			<ul class="am-list">
			<?php foreach ($teachers as $teacher): ?>
				<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
					<div class="am-u-sm-4 am-list-thumb">
						<?= Html::a('<img src="'.$teacher->avatar.'">', ['/teachers/view', 'id'=>$teacher->id]) ?>
					</div>
					<div class="am-u-sm-8 am-list-main">
						<h3 class="am-list-item-hd">
							<?= Html::a($teacher->name, ['/teachers/view', 'id'=>$teacher->id]) ?>
						</h3>
						<div class="am-list-item-text"><?= $teacher->attributeLabels()['phone'] ?>：<?= $teacher->phone ?></div>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>未登记认证教师信息</p>
		<?php endif; ?>
		</div>
	</div>
</div>