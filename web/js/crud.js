(function($){
	var defaultOptions = {
		'url': {
			'trash': '',
			'untrash': '',
			'destroy': '',
		}
	};

	$.fn.extend({
		'crud': function(options) {
			// 合并用户配置与默认配置
			var opts = $.extend({}, defaultOptions, options);
			var select_all = function(checkbox, checked) {
				var objs = $('input[name="'+checkbox+'"]');
				var p;
				if (objs.length) {
					$.each(objs, function(idx, obj){
						$(obj).prop('checked', checked);
						var p = $(obj).parent().parent();
						p.attr('aria-checked', checked);
					})
				}
			};

			/* 数据全选 */
			if ($('#action_data_select_all').length) {
				$('#action_data_select_all').on('click', function(){
					var checked = $(this).is(':checked');
					select_all('data_ids[]', checked);
				});
			}
			/* 回收站全选 */
			if ($('#action_trash_select_all').length) {
				$('#action_trash_select_all').on('click', function(){
					var checked = $(this).is(':checked');
					select_all('trash_data_ids[]', checked);
				});
			}
			/* 数据选中时，修改tr容器属性 */
			if ($('input[name="data_ids[]"]').length) {
				$('input[name="data_ids[]"]').on('click', function(){
					var checked = $(this).is(':checked');
					$(this).parent().parent().attr('aria-checked', checked);
				});
			}
			/* 回收站数据选中时，修改tr容器属性 */
			if ($('input[name="trash_data_ids[]"]').length) {
				$('input[name="trash_data_ids[]"]').on('click', function(){
					var checked = $(this).is(':checked');
					$(this).parent().parent().attr('aria-checked', checked);
				});
			}

			/* 批量放入回收站 */
			if ($('a[role="trash_all"]').length) {
				$('a[role="trash_all"]').on('click', function(){
					var selected = $('#active-data-list-table tr[aria-checked="true"]');
					var form = $('#active-data-list-form');
					if (selected.length > 0) {
						form.attr('action', opts.url.trash);
						form.submit();
					} else {
						alert('请选择要操作的数据。')
					}
					return false;
				});
			}

			/* 批量还原 */
			if ($('a[role="untrash_all"]').length) {
				$('a[role="untrash_all"]').on('click', function(){
					var selected = $('#trash-data-list-table tr[aria-checked="true"]');
					var form = $('#trash-data-list-form');
					if (selected.length > 0) {
						form.attr('action', opts.url.untrash);
						form.submit();
					} else {
						alert('请选择要操作的数据。');
					}
				});
			}

			/* 批量彻底删除 */
			if ($('a[role="delete_all"]').length) {
				$('a[role="delete_all"]').on('click', function(){
					var selected = $('#trash-data-list-table tr[aria-checked="true"]');
					var form = $('#trash-data-list-form');
					if (selected.length > 0) {
						if (confirm('删除操作不可逆转，'+'\r\n'+'确认要删除这些数据吗？')) {
							form.attr('action', opts.url.destroy);
							form.submit();
						}
					} else {
						alert('请选择要操作的数据。');
					}
				});
			}
		}
	});
})(jQuery);
