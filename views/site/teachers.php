<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Teachers;
use app\components\detect\BrowserDetect;
use yii\widgets\LinkPager;

$this->title = Html::encode(Yii::$app->name);

if (!isset($isMobile)) {
	$isMobile = BrowserDetect::is_mobile();
}
?>
<div class="teachers-index" style="margin-top:40px">
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

	<?php if ($isMobile): ?>
	<form class="am-form" method="post">
		<div class="am-form-group am-form-group-sm">
			<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
			<input type="text" name="query" class="am-form-field" placeholder="<?= Yii::t('app', 'Search: region/name/phone') ?>">
		</div>
	</form>
	<?php endif; ?>

	<div class="am-scrollable-horizontal">
		<table class="am-table am-table-striped am-text-nowrap">
		<thead>
			<tr>
				<th>教师编号</th>
				<th>&nbsp;</th>
				<th>姓名</th>
				<th>分部</th>
				<th>所在城市</th>
				<th>联系方式</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($teachers as $teacher): $content = $teacher->content; ?>

	    <tr>
	    	<td><?= Html::encode($teacher->id) ?></td>
	    	<td><img src="<?= $teacher->avatar ?>" style="max-height:40px;width:auto;"></td>
	    	<td><?=  Html::a($teacher->name, ['/site/teacher', 'id'=>$teacher->id]) ?></td>
	    	<td><?= Html::a($content->name, ['/site/view', 'id'=>$content->id]) ?></td>
	    	<td><?= Html::encode($content->location) ?></td>
	    	<td><?= Html::encode(empty($teacher->contact) ? $content->phone : $teacher->contact) ?></td>
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
</div>