<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Contents;
use app\models\District;
use app\components\detect\BrowserDetect;
use yii\widgets\LinkPager;

$this->title = Html::encode(Yii::$app->name);

if (!isset($isMobile)) {
	$isMobile = BrowserDetect::is_mobile();
}
?>

<?php if (!$isMobile): ?>
    <div class="am-u-md-3">
        <?php if (isset($contents_states_list)): ?>
            

                    <section class="sidebar">
                        <ul class="am-nav">
                            <li class="am-nav-header"><?= Yii::t('app', 'Region') ?></li>
                            <?php foreach ($contents_states_list as $key=>$value): ?>
                            <li><?= Html::a($value, ['/site/index', 'region'=>$key]) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>

            
        <?php endif; ?>
    </div>
    <div class="am-u-md-9">
<?php endif; ?>

<?php if (!empty($search_condition)): ?>
	<div class="am-alert am-alert-secondary">
		<p>包含
        <?php $query = explode(' ', $search_condition);
            foreach ($query as $q): ?>
            “<span style="color:#900"><?= strtolower(trim($q)) ?></span>”
        <?php endforeach; ?>
        的检索结果</p>
	</div>
<?php endif; ?>

<?php if (!empty($query_region)): ?>
    <div class="am-alert am-alert-secondary">
        <p>地区为 <span style="color:#900"><?= District::getStates($query_region)[$query_region] ?></span> 的分部</p>
    </div>
<?php endif; ?>

<div class="site-index">

<?php if ($isMobile): ?>
	<form class="am-form" method="post">
		<div class="am-form-group am-form-group-sm">
			<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
			<input type="text" name="query" class="am-form-field" placeholder="<?= Yii::t('app', 'Search: region/name/phone') ?>">
		</div>
	</form>
<?php endif; ?>

<?php if (!$isMobile): ?><ul class="am-avg-sm-2 am-avg-md-3 am-thumbnails"><?php endif; ?>
<?php foreach ($contents as $con): $teachers = $con->teachers; ?>

    <?= !$isMobile ? '<li>' : '' ?>

    	<div class="am-intro am-cf am-intro-default">
    		<div class="am-intro-bd">
    			
    			<div class="">
    				<h4 style="color:#00d;"><?= Html::a($con->name, ['/site/view', 'id'=>$con->id]) ?></h4>
    				<p>
    					<?= $con->getAttributeLabel('serial_no') ?>: <span><?= Html::encode($con->serial_no) ?></span><br>
    					<?= $con->getAttributeLabel('manager') ?>: <span><?= Html::encode($con->manager) ?></span><br>
    					<?= $con->getAttributeLabel('business_scope') ?>: <span><?= Html::encode($con->business_scope) ?></span><br>
    					<?= $con->getAttributeLabel('location') ?>: <span><?= Html::encode($con->location) ?></span><br>
    					<?= $con->getAttributeLabel('address') ?>: <span><?= Html::encode($con->address) ?></span><br>
    					<?= $con->getAttributeLabel('phone') ?>: <span><?= Html::encode($con->phone) ?></span><br>
                        <?= $con->getAttributeLabel('taobao') ?>: <span><?= empty($con->taobao) ? '':Html::a('点击访问',Html::encode($con->taobao)) ?></span><br>
                        <?= $con->getAttributeLabel('homepage') ?>: <span><?= empty($con->taobao) ? '':Html::a('点击访问',Html::encode($con->homepage)) ?></span><br>
    					<?= $con->getAttributeLabel('weibo') ?>: <span><?= empty($con->weibo) ? '' : Html::a(Html::encode($con->weibo),Html::encode($con->weibo)) ?></span><br>
    					<?= $con->getAttributeLabel('weixin') ?>: <span><?= Html::encode($con->weixin) ?></span><br>
    					<?= $con->getAttributeLabel('qq') ?>: <span><?= Html::encode($con->qq) ?></span><br>
                        认证教师: <span><?php foreach($teachers as $teacher) { echo Html::a($teacher->name, ['/teachers/view', 'id'=>$teacher->id]); } ?></span>
    				</p>
    			</div>
    		</div>
    	</div>
    	
    <?= !$isMobile ? '</li>' : '' ?>
<?php endforeach; ?>
<?php if (!$isMobile): ?>
	</ul>
<?php endif; ?>

</div>

<div class="pagination am-cf" style="font-size:14px">
	<?php 
	if ($isMobile) {
		$options = ['class'=>'am-pagination am-pagination-select'];
	} else {
		$options = ['class'=>'am-pagination'];
	} 
	?>

	<?= LinkPager::widget(['pagination' => $pagination, 'options' => $options]) ?>
</div>

<?php if (!$isMobile): ?>
    </div> <!-- am-u-md-9 -->
<?php endif; ?>


<?php if ($isMobile && Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') : ?>
<?php $js = "

    $('#action-region-select').on('click', function(){
        $('#sidebar-toggle').click();
        return false;
    });
    
    $.ajax({
        url: '".Url::to(['/contents/list'])."',
        type: 'get',
        dataType: 'json',
        success: function(response) {
            //console.log(response);
            $.each(response, function(idx, content){
                $('#contents_states_list').append('<li><a href=\"'+content.url+'\">'+content.text+'</a></li>');
                //console.log(content);
            })
            
        }
    });
";
$this->registerJs($js);
?>
<?php endif; ?>