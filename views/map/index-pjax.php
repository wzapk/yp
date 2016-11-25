<?php
use app\components\detect\BrowserDetect;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = '魔菇联盟全国分布图';
?>


<div id="map-index">
	<div id="baidu_map_container">
		
	</div>
	<div class="contents-info">
		<div class="contents-summary">
			<h2>目前有<span><?= $totalCount ?></span>家联盟，waitting for you!</h2>
		</div>
		<div class="contents-body">
			<div class="am-list-news am-list-news-default">
				<div class="am-list-news-hd am-cf">
					<h2>最新联盟列表</h2>
				</div>
				
					<?php Pjax::begin(['options'=>['class'=>'am-list-news-bd']]) ?>
						<?= ListView::widget([
							'dataProvider' => $dataProvider,
							'itemView' => '_listview',
							'summary' => false,
							'options' => [
								'tag' => 'ul',
								'class' => 'am-list',
							],
							'itemOptions' => [
								'class' => 'am-g am-list-item-desced',
								'tag' => 'li',
							],
							'pager' => [
								'options' => [
									'class' => 'am-pagination',
								],
							],
						]) ?>
					<?php Pjax::end(); ?>
				
			</div>
		</div>
	</div>
	
</div>


<?php
$this->registerJsFile('http://api.map.baidu.com/api?v=2.0&ak=13reT2e9mO48UbkQg6gzD2I9', ['position'=>View::POS_HEAD]);
$markArr = 'var markerArr = ' . Json::encode($markArray);
$this->registerJs($markArr);
$js = '
	// 百度地图API功能
	var map = new BMap.Map("baidu_map_container");    // 创建Map实例

	//map.setMapStyle({style:"midnight"}); // 设置地图风格模板

	map.centerAndZoom(new BMap.Point(108.356574, 37.768901), 5);  // 初始化地图,设置中心点坐标和地图级别
	//map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
	map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT})); //添加比例尺
	map.setCurrentCity("北京");          // 设置地图显示的城市 此项是必须设置的
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	map.enableKeyboard(); // 键盘支持

	//创建marker
    function addMarker(){
        for(var i=0;i<markerArr.length;i++){
            var json = markerArr[i];
            var p0 = json.point.split("|")[0];
            var p1 = json.point.split("|")[1];
            var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
            var marker = new BMap.Marker(point,{icon:iconImg});
            //map.addOverlay(marker);
            
			var iw = createInfoWindow(i);
			var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
			label.hide();
			marker.setLabel(label);
            map.addOverlay(marker);
            label.setStyle({
                        borderColor:"#808080",
                        color:"#333",
                        cursor:"pointer"
            });
			
			(function(){
				var index = i;
				var _iw = createInfoWindow(i);
				var _marker = marker;
				_marker.addEventListener("click",function(){
				    this.openInfoWindow(_iw);
			    });
			    _iw.addEventListener("open",function(){
				    _marker.getLabel().hide();
			    })
			    _iw.addEventListener("close",function(){
				    _marker.getLabel().show();
			    })
				label.addEventListener("click",function(){
				    _marker.openInfoWindow(_iw);
			    })
				if(!!json.isOpen){
					label.hide();
					_marker.openInfoWindow(_iw);
				}
			})();
			
        }
    }
    //创建InfoWindow
    function createInfoWindow(i){
        var json = markerArr[i];
        var iw = new BMap.InfoWindow("<b class=\'iw_poi_title\' title=\'" + json.title + "\'>" + json.title + "</b><div class=\'iw_poi_content\'>"+json.content+"</div>");
        return iw;
    }
    //创建一个Icon
    function createIcon(json){
        var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
        return icon;
    }
	addMarker();
';
$this->registerJs($js);
