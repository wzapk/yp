<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	'用户管理',
];

?>

<div class="am-tabs" data-am-tabs="{noSwipe: 1}">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active">
			<a href="#user-list">用户列表 (<?= $active_pagination->totalCount ?>)</a>
		</li>
		<li>
			<a href="#user-trash">回收站 (<?= $trash_count ?>)</a>
		</li>
	</ul>
	<div class="am-tabs-bd">
		<div id="user-list" class="am-tab-panel am-active">
			<div class="toolbar">
				<ul class="menu">
					<li class="menu-item">
						<a href="<?= Url::to(['/user/create']) ?>">添加</a>
					</li>
					<li class="menu-item">|</li>
					<li class="menu-item">
						<a href="#" role="trash_all">批量放入回收站</a>
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
							<th>用户名</th>
							<th>Email</th>
							<th>认证TOKEN</th>
							<th>权限</th>
							<th>创建时间</th>
						</tr>
					</thead>
					<tbody>
					<?php if (isset($active_users)): ?>
						<?php if (count($active_users)): foreach ($active_users as $user): $roles = $user->roles; ?>
						<tr aria-id="<?= $user->id ?>" aria-checked="false">
							<td class="check-column"><input type="checkbox" name="data_ids[]" value="<?= $user->id ?>"></td>
							<td class="action-column">
								<a href="<?= Url::to(['/user/update', 'id'=>$user->id]) ?>">编辑</a> | <a href="<?= Url::to(['/user/trash', 'id'=>$user->id]) ?>">放入回收站</a>
								
								<br><a href="#" class="set-password" aria-id="<?= $user->id ?>">修改密码</a>
								
							</td>
							<td><?= $user->username ?></td>
							<td><?= $user->email ?></td>
							<td><?= $user->auth_key ?></td>
							<td>
								<?php $has_role = []; foreach ($roles as $role): ?>
									<?php $has_role[] = $role->item_name ?>
								<?php endforeach; ?>
								<?= implode(',', $has_role) ?>
							</td>
							<td><?= date('Y-m-d', $user->created_at) ?></td>
						</tr>
						<?php endforeach; else: ?>
						<tr>
							<td colspan="6">未找到数据</td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					</tbody>
				</table>
				<?php ActiveForm::end() ?>

			</div>
			<?= LinkPager::widget(['pagination' => $active_pagination, 'options'=>['class'=>'am-pagination']]) ?>
		</div>
		<div id="user-trash" class="am-tab-panel">
			<div class="toolbar">
				<ul class="menu">
					<li class="menu-item">
						<a href="#" role="untrash_all">批量还原</a>
					</li>
					<li class="menu-item">|</li>
					<li class="menu-item">
						<a href="#" role="delete_all">批量彻底删除</a>
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
						<th>用户名</th>
						<th>Email</th>
						<th>认证TOKEN</th>
						<th>创建时间</th>
					</tr>
				</thead>
				<tbody>
				<?php if (isset($deactive_users)): ?>
					<?php if (count($deactive_users)): foreach ($deactive_users as $user): ?>
					<tr aria-id="<?= $user->id ?>" aria-checked="false">
						<td class="check-column"><input type="checkbox" name="trash_data_ids[]" value="<?= $user->id ?>"></td>
						<td class="action-column">
							<a href="<?= Url::to(['/user/untrash', 'id'=>$user->id]) ?>">还原</a> | <a href="<?= Url::to(['/user/delete', 'id'=>$user->id]) ?>">彻底删除</a>
						</td>
						<td><?= $user->username ?></td>
						<td><?= $user->email ?></td>
						<td><?= $user->auth_key ?></td>
						<td><?= date('Y-m-d', $user->created_at) ?></td>
					</tr>
					<?php endforeach; else: ?>
					<tr>
						<td colspan="6">未找到数据</td>
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

<div class="am-modal am-modal-prompt" id="set-password-modal">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">设置密码</div>
		<div class="am-modal-bd">
			设置一个新密码
			<input type="password" name="pwd" class="am-modal-prompt-input">
		</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel>取消</span>
			<span class="am-modal-btn" data-am-modal-confirm>提交</span>
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