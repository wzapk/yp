<?php
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\web\View;
use yii\helpers\Html;

$this->title = '仪表盘';

$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	$this->title,
];
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css');
?>
<div class="row">
	<div class="col-md-12 col-lg-8">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua">
						<i class="ion ion-ios-book-outline"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">加盟分部</span>
						<span class="info-box-number"><small>有效</small> <?= $active_contents_count ?> <small>回收站</small> <?= $deactive_contents_count ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red">
						<i class="ion ion-university"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">认证教师</span>
						<span class="info-box-number"><small>有效</small> <?= $active_teachers_count ?> <small>回收站</small> <?= $deactive_teachers_count ?></span>
					</div>
				</div>
			</div>
			<div class="clearfix visible-sm-block"></div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow">
						<i class="ion ion-ios-people-outline"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">用户</span>
						<span class="info-box-number"><small>有效</small> <?= $active_users_count ?> <small>回收站</small> <?= $deactive_users_count ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-lg-8">
		<!-- 联盟分部 -->
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">最新加盟分部</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>名称</th>
								<th>所在地</th>
								<th>添加时间</th>
							</tr>
						</thead>
						<tbody>
						<?php if (isset($last_contents) && $last_contents): foreach ($last_contents as $last_content): ?>
							<tr>
								<td><?= Html::encode($last_content->name) ?></td>
								<td><?= $last_content->location ?></td>
								<td><?= date('Y-m-d', $last_content->created_at) ?></td>
							</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="3">没有找到分部数据</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer clearfix">
				<a href="<?= Url::to(['/contents/create']) ?>" class="btn btn-sm btn-info btn-flat pull-left">添加</a>
				<a href="<?= Url::to(['/contents/index']) ?>" class="btn btn-sm btn-default btn-flat pull-right">查看全部联盟</a>
			</div>
		</div><!-- 联盟分部 -->

		<!-- 认证教师 -->
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">最新认证教师</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<th>姓名</th>
								<th>所属分部</th>
								<th>添加时间</th>
							</tr>
						</thead>
						<tbody>
						<?php if (isset($last_teachers) && $last_teachers): ?>
							<?php foreach ($last_teachers as $last_teacher): $content = $last_teacher->content; ?>
							<tr>
								<td><img src="<?= $last_teacher->avatar ?>" style="width:auto;max-height:48px" class="img-circle"></td>
								<td><?= Html::encode($last_teacher->name) ?></td>
								<td><?= Html::encode($content->name) ?></td>
								<td><?= date('Y-m-d', $last_teacher->created_at) ?></td>
							</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="4">没有找到教师数据</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer clearfix">
				<a href="<?= Url::to(['/teachers/create']) ?>" class="btn btn-sm btn-danger btn-flat pull-left">添加</a>
				<a href="<?= Url::to(['/teachers/index']) ?>" class="btn btn-sm btn-default btn-flat pull-right">查看全部教师</a>
			</div>
		</div><!-- 认证教师 -->

		<?php if (Yii::$app->user->can('admin')): ?>
		<!-- 注册用户 -->
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">最新注册用户</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>用户名</th>
								<th>EMail</th>
								<th>权限</th>
								<th>添加时间</th>
							</tr>
						</thead>
						<tbody>
						<?php if (isset($last_users) && $last_users): ?>
							<?php foreach ($last_users as $last_user): $roles = Yii::$app->authManager->getRolesByUser($last_user->id); ?>
							<tr>
								<td><?= Html::encode($last_user->username) ?></td>
								<td><?= Html::encode($last_user->email) ?></td>
								<td><?php foreach($roles as $role){ echo $role->description.'<br>'; } ?></td>
								<td><?= date('Y-m-d', $last_user->created_at) ?></td>
							</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="4">没有找到注册用户数据</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer clearfix">
				<a href="<?= Url::to(['/users/create']) ?>" class="btn btn-sm btn-danger btn-flat pull-left">添加</a>
				<a href="<?= Url::to(['/users/index']) ?>" class="btn btn-sm btn-default btn-flat pull-right">查看全部用户</a>
			</div>
		</div><!-- 注册用户 -->
		<?php endif; ?>

	</div>
</div>
