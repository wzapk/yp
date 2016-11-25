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

$fields = [
    'serial_no' => [
        'style' => 'width:20%',
    ],
    'name' => [
        'class' => 'am-text-primary',
    ],
    'manager' => [
        'style' => 'width:10%',
        
    ],
    //'business_scope',
    //'state',
    'location' => ['style' => 'width:20%',],
    //'address',
    'phone' => ['style' => 'width:15%',],
    //'taobao',
    //'homepage',
    //'weibo',
    //'weixin',
    //'qq',
];
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

<div class="am-scrollable-horizontal" style="color:#444;cursor:pointer">

    <table id="contents-table" class="am-table am-table-striped am-table-hover <?= $isMobile ? 'am-text-nowrap': '' ?>">
        <thead>
            <tr><?php $c = new Contents; foreach ($fields as $field => $opt): ?>
                <th <?= isset($opt['style']) ? 'style="'.$opt['style'].'"' : '' ?>><?= $c->getAttributeLabel($field) ?></th>
                <?php endforeach; unset($c); ?>
            </tr>
        </thead>
        <tbody>
<?php foreach ($contents as $con): $teachers = $con->teachers; ?>

    	<tr aria-data-url="<?= Url::to(['/site/view', 'id'=>$con->id]) ?>"><?php foreach ($fields as $field => $opt): ?>
            <td <?= isset($opt['class']) ? 'class="'.$opt['class'].'"' : '' ?>><?= Html::encode($con->$field) ?></td>
    		<?php endforeach; ?>
    	</tr>
    	

<?php endforeach; ?>
        </tbody>
    </table>

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
<?php
$this->registerJs("
    $('#contents-table tr').on('click', function() {
        var url = $(this).attr('aria-data-url');
        window.location = url;
    })
");