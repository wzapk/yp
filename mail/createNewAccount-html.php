<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user 账号信息数组 */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
?>
<div>
    <p><?= Yii::t('app', 'Hello') ?> <?= Html::encode($user['username']) ?>,</p>

    <p><?= Yii::t('app', 'You are registered as account information:') ?></p>

    <p><?= Yii::t('app', 'Account: {u}', ['u' => $user['email']]) ?></p>

    <p><?= Yii::t('app', 'Password: {p}', ['p' => $user['password']]) ?></p>

	<p><?= Yii::t('app', 'Keep your account information') ?></p>

    <p><?= Html::a(Html::encode($loginLink), $loginLink) ?></p>
</div>