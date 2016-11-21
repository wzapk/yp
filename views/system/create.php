<?php
use app\models\Options;
use yii\helpers\Html;

/* $model app\model\Options */
$this->title = Html::encode(Options::v('appname', Yii::$app->params['appname'])).' - 新建'.Yii::t('app/options', 'Options');
$this->params['breadcrumbs'] = [
	['label' => '后台首页', 'url' => ['/m/index']],
	Yii::t('app/options', 'Options'),
];

?>

<h2>新建<?= Yii::t('app/options', 'Options') ?></h2>
<?= $this->render('_form', [
	'model' => $model,
]) ?>