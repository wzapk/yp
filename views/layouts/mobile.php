<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\Options;
?>
<header class="am-header am-header-default am-header-fixed">
        <div class="am-header-left am-header-nav">
            <a href="<?= Url::to(['/site/index']) ?>">
                <i class="am-header-icon am-icon-home"></i>
            </a>
            <a href="<?= Url::to(['/map/index']) ?>">
                <i class="am-header-icon am-icon-map-pin"></i>
            </a>
            <a href="<?= Url::to(['/site/teachers']) ?>">
                <i class="am-header-icon am-icon-graduation-cap "></i>
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
            <ul class="am-navbar-nav am-cf am-avg-sm-5">
                <li>
                    <a href="<?= Url::to(['/m/index']) ?>" class="dashboard">
                        <span class="am-icon-dashboard"></span>
                        <span class="am-navbar-label">仪表盘</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/contents/index']) ?>" class="content-manage">
                        <span class="am-icon-th-list"></span>
                        <span class="am-navbar-label">分部</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/teachers/index']) ?>" class="teacher-manage">
                        <span class="am-icon-mortar-board"></span>
                        <span class="am-navbar-label">教师</span>
                    </a>
                </li>
                <?php if (Yii::$app->user->can('admin')): ?>
                <li>
                    <a href="<?= Url::to(['/user/index']) ?>" class="user-manage">
                        <span class="am-icon-user"></span>
                        <span class="am-navbar-label">用户</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/system/index']) ?>" class="system-manage">
                        <span class="am-icon-cog"></span>
                        <span class="am-navbar-label">系统</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </footer>

    <?php endif; ?>
    </div>
