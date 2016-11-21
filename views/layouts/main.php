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

<header class="am-topbar am-topbar-inverse am-topbar-fixed-top">
    <div class="am-g am-g-fixed">
    <h1 class="am-topbar-brand">
        <?= Html::a(Html::encode(Options::v('appname',Yii::$app->params['appname'])), ['/site/index']) ?>
    </h1>
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}">
        <span class="am-sr-only">导航切换</span>
        <span class="am-icon-bars"></span>
    </button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav">
            <li <?= Yii::$app->controller->id == 'site' ? 'class="am-active"':'' ?>><a href="<?= Url::to(['/site/index']) ?>">分部列表</a></li>
            <li <?= Yii::$app->controller->id == 'map' ? 'class="am-active"':'' ?>><a href="<?= Url::to(['/map/index']) ?>">地图显示</a></li>
        </ul>
        <form action="<?= Url::to(['/site/index']) ?>" method="POST" class="am-topbar-form am-topbar-left am-form-inline" role="search">
            <div class="am-form-group">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <input name="query" type="text" class="am-form-field am-input-sm" placeholder="<?= Yii::t('app', 'Search: region/name/phone') ?>">
            </div>
        </form>
        <div class="am-topbar-right">

            <?php if (Yii::$app->user->isGuest): ?>
                <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
                    <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>
                        管理 <span class="am-icon-caret-down"></span>
                    </button>
                    <ul class="am-dropdown-content">
                        <li><a href="<?= Url::to(['/site/login']) ?>">登录</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
                    <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>
                        <?= Html::encode(Yii::$app->user->identity->username) ?>
                        <span class="am-icon-caret-down"></span>
                    </button>
                    <ul class="am-dropdown-content">
                        <?php if (Yii::$app->user->can('manager')): ?>
                            <li><a href="<?= Url::to(['/m/index']) ?>">后台管理</a></li>
                            <li class="am-divider"></li>
                        <?php endif; ?>
                        <li><a href="<?= Url::to(['/site/logout']) ?>" data-method="POST">退出</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>
    </div>
</header>
<div class="wrap">

    <div class="am-g am-g-fixed">
    <?php if (Yii::$app->controller->id !== 'site' && Yii::$app->controller->id !== 'map'): ?>
        <!-- 后台管理 -->
        <div class="am-u-sm-4 am-u-lg-3">
            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">仪表盘</div>
                <div class="am-panel-bd">
                    <ul class="sidebar-menu">
                        <li><a href="<?= Url::to(['/m/index']) ?>">Dashboard</a></li>
                        <?php if (Yii::$app->user->can('admin')): ?>
                            <li><a href="<?= Url::to(['/user/index']) ?>">用户管理</a></li>
                            <li><a href="<?= Url::to(['/system/index']) ?>">系统管理</a></li>
                        <?php endif; ?>
                        <li><a href="<?= Url::to(['/contents/index']) ?>">分部管理</a></li>
                        <li><a href="<?= Url::to(['/teachers/index']) ?>">教师管理</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="am-u-sm-8 am-u-lg-9">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 
                'activeItemTemplate'=>"<li class=\"am-active\">{link}</li>\n", 
                'tag'=>'ol', 
                'homeLink'=>false, 
                'options'=>[
                    'class'=>'am-breadcrumb'
                ]
            ]) ?>
            <?= $content ?>
        </div>
    <?php else: ?>
        <!-- 首页 -->
        
        <?= $content ?>


    <?php endif; ?>
    </div>
</div>

<footer class="am-footer am-footer-default">
    
    <div class="am-footer-miscs ">

        <p>
            由 
            <?= Html::a(
                    Html::encode(Options::v('support',Yii::$app->params['support'])), 
                    Options::v('supportLink',Yii::$app->params['supportLink']), 
                    [ 'target' => '_BLANK', 'title' => Html::encode(Options::v('support',Yii::$app->params['support'])) ]
            ) ?>
            提供技术支持
        </p>
        <p>CopyRight©<?= date('Y') ?> <?= Html::a(Html::encode(Options::v('copyright',Yii::$app->params['copyright'])), Options::v('copyrightLink',Yii::$app->params['copyrightLink']), ['target' => '_BLANK']) ?></p>
        <p><?= Html::encode(Options::v('ICP',Yii::$app->params['ICP'])) ?></p>
    </div>

</footer>

<?php else: ?>

    <?php /* 移动页面 */ ?>

    <header class="am-header am-header-default am-header-fixed">
        <div class="am-header-left am-header-nav">
            <a href="<?= Url::to(['/site/index']) ?>">
                <i class="am-header-icon am-icon-home"></i>
            </a>
            <a href="<?= Url::to(['/map/index']) ?>">
                <i class="am-header-icon am-icon-map-pin"></i>
            </a>
        </div>

        <h1 class="am-header-title">
            <a href="javascript:;" class="">
                <?= Html::encode(Options::v('shortappname',Yii::$app->params['shortappname'])) ?>
            </a>
        </h1>
        
        <?php 
            $controller = Yii::$app->controller;
            $action = $controller->action;
        ?>
        <?php if ($controller->id == 'site' && $action->id == 'index'): ?>
        <div class="am-header-right am-header-nav">
            <a id="action-region-select" href="#">
                <span class="am-icon-link"></span>
                <span class="am-navbar-label"><?= Yii::t('app', 'Region') ?></span>
            </a>
            <nav class="am-menu am-menu-offcanvas2" data-am-widget="menu" data-am-menu-offcanvas>
                <a id="sidebar-toggle" href="#" class="am-menu-toggle"></a>
                <div class="am-offcanvas">
                    <div class="am-offcanvas-bar am-offcanvas-bar-flip am-open">
                        <ul id="contents_states_list" class="am-menu-nav am-avg-sm-3 am-in">
                            
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <?php endif; ?>

    </header>
    
    <div class="wrap">
        
            <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 
                    'activeItemTemplate'=>"<li class=\"am-active\">{link}</li>\n", 
                    'tag'=>'ol', 
                    'homeLink'=>false, 
                    'options'=>[
                        'class'=>'am-breadcrumb'
                    ]
                ]) ?>
            
            <?= $content ?>
            
    <?php if (Yii::$app->controller->id !== 'site' && Yii::$app->controller->id !== 'map'): ?>
        
        <footer class="am-navbar am-cf am-navbar-default">
            <ul class="am-navbar-nav am-cf am-avg-sm-4">
                <li>
                    <a href="<?= Url::to(['/m/index']) ?>" class="dashboard">
                        <span class="am-icon-dashboard"></span>
                        <span class="am-navbar-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/contents/index']) ?>" class="content-manage">
                        <span class="am-icon-th-list"></span>
                        <span class="am-navbar-label">分部管理</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/user/index']) ?>" class="user-manage">
                        <span class="am-icon-user"></span>
                        <span class="am-navbar-label">用户管理</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/system/index']) ?>" class="system-manage">
                        <span class="am-icon-cog"></span>
                        <span class="am-navbar-label">系统管理</span>
                    </a>
                </li>
            </ul>
        </footer>

    <?php endif; ?>
    </div>

<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
