<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Teachers;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeachersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/teacher', 'Teachers');
$this->params['breadcrumbs'][] = $this->title;

$attributeLabels = Teachers::attributeLabels();
?>
<div class="teachers-index">


<div class="am-tabs" data-am-tabs="{noSwipe: 1}">
    <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active">
            <a href="#teachers-list"><?= Yii::t('app/teacher', 'Teachers') ?> (<?= $active_pagination->totalCount ?>)</a>
        </li>
        <li>
            <a href="#teachers-trash"><?= Yii::t('app/teacher', 'Recycle') ?> (<?= $trash_count ?>)</a>
        </li>
    </ul>
    <div class="am-tabs-bd">
        <div id="teachers-list" class="am-tab-panel am-active">
            <div class="toolbar">
                <ul class="menu">
                    <li class="menu-item">
                        <a href="<?= Url::to(['/teachers/create']) ?>"><?= Yii::t('app', 'Add') ?></a>
                    </li>
                    <li class="menu-item">|</li>
                    <li class="menu-item"><?= Yii::t('app', 'Batch operation:') ?></li>
                    <li class="menu-item">
                        <a href="#" role="trash_all"><?= Yii::t('app', 'Trash') ?></a>
                    </li>
                    
                </ul>
            </div>
            
            <div class="am-scrollable-horizontal">
                <?php ActiveForm::begin(['id'=>'active-data-list-form']) ?>
                <table id="active-data-list-table" class="am-table am-text-nowrap am-table-striped">
                    <thead>
                        <tr>
                            <th class="check-column"><input type="checkbox" id="action_data_select_all"></th>
                            <th>&nbsp;</th>
                            <th><?= $attributeLabels['cid'] ?></th>
                            <th><?= $attributeLabels['name'] ?></th>
                            <th><?= $attributeLabels['avatar'] ?></th>
                            <th><?= $attributeLabels['certificate'] ?></th>
                            <th><?= $attributeLabels['phone'] ?></th>
                            <th><?= $attributeLabels['created_at'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($active_teachers)): ?>
                        <?php if (count($active_teachers)): foreach ($active_teachers as $teacher): ?>
                        <tr aria-id="<?= $teacher->id ?>" aria-checked="false">
                            <td class="check-column"><input type="checkbox" name="data_ids[]" value="<?= $teacher->id ?>"></td>
                            <td class="action-column">
                                <a href="<?= Url::to(['update', 'id'=>$teacher->id]) ?>"><?= Yii::t('app', 'Edit') ?></a> | <a href="<?= Url::to(['trash', 'id'=>$teacher->id]) ?>"><?= Yii::t('app', 'Trash') ?></a>
                            </td>
                            <td><?= Html::encode($teacher->content->name) ?></td>
                            <td><?= Html::encode($teacher->name) ?></td>
                            <td><?= !empty($teacher->avatar) ? '<img src="'.$teacher->avatar.'" width="80" height="80">' : '' ?></td>
                            <td><?= !empty($teacher->certificate) ? '<img src="'.$teacher->certificate.'" width="80" height="80">' : '' ?></td>
                            <td><?= Html::encode($teacher->phone) ?></td>

                            <td><?= date('Y-m-d', $teacher->created_at) ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="8"><?= Yii::t('app', 'No data') ?></td>
                        </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php ActiveForm::end() ?>

            </div>
            <?= LinkPager::widget(['pagination' => $active_pagination, 'options'=>['class'=>'am-pagination']]) ?>
        </div>
        <div id="teachers-trash" class="am-tab-panel">
            <div class="toolbar">
                <ul class="menu">
                    <li class="menu-item"><?= Yii::t('app', 'Batch operation:') ?></li>
                    <li class="menu-item">
                        <a href="#" role="untrash_all"><?= Yii::t('app', 'Untrash') ?></a>
                    </li>
                    <li class="menu-item">|</li>
                    <li class="menu-item">
                        <a href="#" role="delete_all"><?= Yii::t('app', 'Delete') ?></a>
                    </li>
                </ul>
            </div>
            <div class="am-scrollable-horizontal">
            <?php ActiveForm::begin(['id'=>'trash-data-list-form']) ?>
            <table id="trash-data-list-table" class="am-table am-table-striped am-text-nowrap">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" id="action_trash_select_all"></th>
                        <th class="action-column">&nbsp;</th>
                        <th><?= $attributeLabels['cid'] ?></th>
                            <th><?= $attributeLabels['name'] ?></th>
                            <th><?= $attributeLabels['avatar'] ?></th>
                            <th><?= $attributeLabels['certificate'] ?></th>
                            <th><?= $attributeLabels['phone'] ?></th>
                            <th><?= $attributeLabels['created_at'] ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($deactive_teachers)): ?>
                    <?php if (count($deactive_teachers)): foreach ($deactive_teachers as $teacher): ?>
                    <tr aria-id="<?= $teacher->id ?>" aria-checked="false">
                        <td class="check-column"><input type="checkbox" name="trash_data_ids[]" value="<?= $teacher->id ?>"></td>
                        <td class="action-column">
                            <a href="<?= Url::to(['untrash', 'id'=>$teacher->id]) ?>"><?= Yii::t('app', 'Untrash') ?></a> | <a href="<?= Url::to(['delete', 'id'=>$teacher->id]) ?>"><?= Yii::t('app', 'Delete') ?></a>
                        </td>
                        <td><?= Html::encode($teacher->content->name) ?></td>
                            <td><?= Html::encode($teacher->name) ?></td>
                            <td><?= !empty($teacher->avatar) ? '<img src="'.$teacher->avatar.'" width="80" height="80">' : '' ?></td>
                            <td><?= !empty($teacher->certificate) ? '<img src="'.$teacher->certificate.'" width="80" height="80">' : '' ?></td>
                            <td><?= Html::encode($teacher->phone) ?></td>
                        <td><?= date('Y-m-d', $teacher->created_at) ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8"><?= Yii::t('app', 'No data') ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>



</div>
<?php
$js = "
    $.fn.crud({
        'url':{
            'trash': '".Url::to(['trash-all'])."',
            'untrash': '".Url::to(['untrash-all'])."',
            'destroy': '".Url::to(['delete-all'])."'
        }
    });
";
$this->registerJs($js);
$this->registerJsFile('@web/js/crud.js', ['depends'=>'yii\web\JqueryAsset']);



