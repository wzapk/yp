<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

	<a href="javascript:;"><?= Html::encode($model->name) ?></a>
	<div class="am-list-item-text"><?= HtmlPurifier::process($model->address) ?></div>
