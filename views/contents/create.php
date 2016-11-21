<?php
$this->title = '创建分部数据';
$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	['label' => '分部管理', 'url' => ['/contents/index']],
	$this->title,
];

?>

<h2><?= $this->title ?></h2>
<?= $this->render('_form', [
	'model' => $model,
]) ?>