<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <nav class="navbar navbar-static-top" role="navigation">
    <div class="container">

        <?php if (!$isMobile): ?>
            <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'adminlte-brand']) ?>
        <?php endif; ?>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li>
                    <?= Html::a('分部', ['/site/index']) ?>
                </li>

                <?php if ($isMobile): ?>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-location-arrow"></i></a>
                </li>
                <?php endif; ?>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= Yii::$app->user->identity->username ?>
                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('管理', ['/m/index'], ['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    '退出',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    </nav>

</header>
