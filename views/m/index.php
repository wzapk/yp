<?php
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	'Dashboard',
];

?>
<div class="data-summary">
	<h4>数据统计</h4>
	<table class="am-table">
		<tbody>
			<tr>
				<td>加盟</td>
				<td>有效：<?= $active_contents_count ?>，回收站：<?= $deactive_contents_count ?></td>
			</tr>
			<tr>
				<td>用户</td>
				<td>有效：<?= $active_users_count ?>，回收站：<?= $deactive_users_count ?></td>
			</tr>
		</tbody>
	</table>

	<h4>
		最新加盟分部
		<?php if (Yii::$app->user->can('manager')): ?>
			<span class="more"><a href="<?= Url::to(['/contents/index']) ?>">管理</a></span>
		<?php endif; ?>
	</h4>
	<table class="am-table">
		<tbody>
		<?php if (isset($last_contents) && $last_contents): foreach ($last_contents as $last_content): ?>
			<tr>
				<td><?= $last_content->name ?></td>
				<td><?= date('Y-m-d', $last_content->created_at) ?></td>
			</tr>
		<?php endforeach; else: ?>
			<tr>
				<td colspan="2">没有找到分部数据</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>

	<h4>
		最新用户
		<?php if (Yii::$app->user->can('admin')): ?>
			<span class="more"><a href="<?= Url::to(['/user/index']) ?>">管理</a></span>
		<?php endif; ?>
	</h4>
	<table class="am-table">
		<tbody>
			<?php if (isset($last_users) && $last_users): foreach ($last_users as $last_user): ?>
				<tr>
					<td><?= $last_user->username ?></td>
					<td><?= $last_user->email ?></td>
					<td><?= date('Y-m-d', $last_user->created_at) ?></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="3">没有找到用户数据</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>