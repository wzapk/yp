<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\Options;
?>
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
            <li <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'class="am-active"':'' ?>>
            	<?= Html::a('分部列表',['/site/index']) ?>
            </li>
            <li <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'teachers' ? 'class="am-active"':'' ?>>
            	<?= Html::a('认证教师',['/site/teachers']) ?>
            </li>
            <li <?= Yii::$app->controller->id == 'map' ? 'class="am-active"':'' ?>>
            	<?= Html::a('地图显示',['/map/index']) ?>
            </li>
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
                            <li>
                            	<?= Html::a('后台管理',['/m/index']) ?>
                            </li>
                            <li class="am-divider"></li>
                        <?php endif; ?>
                        <li>
                        	<?= Html::a('退出',['/site/logout'],['data'=>['method'=>'POST']]) ?>
                        </li>
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
        <!-- 后台管理菜单 -->
        <div class="am-u-sm-4 am-u-lg-3">
            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">仪表盘</div>
                <div class="am-panel-bd">
                    <ul class="sidebar-menu">
                        <li>
                        	<?= Html::a('仪表盘',['/m/index']) ?>
                        </li>
                        <?php if (Yii::$app->user->can('admin')): ?>
                            <li><?= Html::a('用户管理',['/user/index']) ?></li>
                            <li><?= Html::a('系统管理',['/system/index']) ?></li>
                        <?php endif; ?>
                        <li><?= Html::a('分部管理',['/contents/index']) ?></li>
                        <li><?= Html::a('教师管理',['/teachers/index']) ?></li>
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