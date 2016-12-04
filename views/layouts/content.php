<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Html;
use app\models\Options;
?>
<div class="content-wrapper">
    <div class="container">
        <section class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </section>
    </div>
</div>

<footer class="main-footer">
    <div class="container text-center">
        <p>
            由 
            <?= Html::a(
                    Html::encode(Options::v('support',Yii::$app->params['support'])), 
                    Options::v('supportLink',Yii::$app->params['supportLink']), 
                    [ 'target' => '_BLANK', 'title' => Html::encode(Options::v('support',Yii::$app->params['support'])) ]
            ) ?>
            提供技术支持
            &nbsp;CopyRight©<?= date('Y') ?> <?= Html::a(Html::encode(Options::v('copyright',Yii::$app->params['copyright'])), Options::v('copyrightLink',Yii::$app->params['copyrightLink']), ['target' => '_BLANK']) ?>
        </p>
        <p><?= Html::encode(Options::v('ICP',Yii::$app->params['ICP'])) ?></p>
    </div>
</footer>

<?php if ($isMobile): ?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <ul id="contents_states_list" class="control-sidebar-menu">
                            
                        </ul>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
<?php endif; ?>