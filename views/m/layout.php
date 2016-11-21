<?php
use app\components\detect\BrowserDetect;
use app\assets\ManageAsset;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

if (!isset($isMobile)) {
	$isMobile = BrowserDetect::is_mobile();
}

ManageAsset::register($this);
?>

<?php if (!$isMobile): ?>
	<div class="am-u-sm-4 am-u-lg-3">
		<ul class="sidebar-menu">
			<li><a href="<?= Url::to(['/m/index']) ?>">Dashboard</a></li>
			<li><a href="<?= Url::to(['/m/user']) ?>">用户管理</a></li>
			<li><a href="#">分部管理</a></li>
		</ul>
	</div>
	<div class="am-u-sm-8 am-u-lg-9">
		
		<?= $this->render($viewFile, $params) ?>
	</div>
<?php else: ?>
	<?= $this->render($viewFile, $params) ?>
	    <footer class="am-navbar am-cf am-navbar-default">
        <ul class="am-navbar-nav am-cf am-avg-sm-3">
        	<li>
        		<a href="<?= Url::to(['/m/index']) ?>">
        			<span class="am-icon-dashboard"></span>
        			<span class="am-navbar-label">Dashboard</span>
        		</a>
        	</li>
        	<li>
                <a href="#" class="">
                    <span class="am-icon-th-list"></span>
                    <span class="am-navbar-label">分部管理</span>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['/m/user']) ?>">
                	<span class="am-icon-user"></span>
                	<span class="am-navbar-label">用户管理</span>
                </a>
            </li>
        </ul>
    </footer>
<?php endif; ?>