<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\detect\BrowserDetect;
use app\assets\ManageAsset;
use app\models\Options;

AppAsset::register($this);

if (!isset($isMobile)) {
    $isMobile = BrowserDetect::is_mobile();
}

if (Yii::$app->controller->id !== 'site') {
    ManageAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="no-js">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta property="qc:admins" content="1471137206577576375" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= Html::encode(Options::v('meta_description', Yii::$app->params['meta_description'])) ?>">
    <meta name="keywords" content="<?= Html::encode(Options::v('meta_keywords', Yii::$app->params['meta_keywords'])) ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Options::v('appname',Yii::$app->params['appname'])) ?></title>
    <?php $this->head() ?>
</head>
<body class="am-with-topbar-fixed-top">
<?php $this->beginBody() ?>

<?php if (!$isMobile): ?>
<?php /* 电脑版页面 */ ?>

    <?= $this->render('pc-admin', ['content' => $content]) ?>

<?php else: ?>
<?php /* 移动页面 */ ?>

    <?= $this->render('mobile', ['content' => $content]) ?>    

<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
