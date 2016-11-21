<?php
$this->title = '创建用户';
$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	['label' => '用户管理', 'url' => ['/user/index']],
	$this->title,
];

?>

<h2><?= $this->title ?></h2>
<?= $this->render('_form', [
	'model' => $model,
]) ?>