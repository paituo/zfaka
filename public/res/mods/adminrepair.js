layui.define(['layer', 'form'], function(exports){
	var $ = layui.jquery;
	var layer = layui.layer;
	var form = layui.form;

    form.on('submit(repair)', function(data){
		data.field.csrf_token = TOKEN;
		data.field.method = 'repair';
		var i = layer.load(2,{shade: [0.5,'#fff']});
			$.ajax({
				url: '/'+ADMIN_DIR+'/repair/repairajax/',
				type: 'POST',
				dataType: 'json',
				data: data.field,
			})
			.done(function(res) {
				if (res.code == '1') {
					layer.open({
						type: 1
						,title: '修复数据'
						,offset: 'auto'
						,id: 'layerPayone' //防止重复弹出
						,content: '<div style="padding: 20px 100px;">'+res.msg+'</div>'
						,btn: '关闭'
						,btnAlign: 'c' //按钮居中
						,shade: 0.8 //不显示遮罩
						,yes: function(){
							location.reload();
						}
						,cancel: function(){ 
							location.reload();
						} 
					});
				} else {
					layer.msg(res.msg,{icon:2,time:5000});
				}
			})
			.fail(function() {
				layer.msg('服务器连接失败，请联系管理员',{icon:2,time:5000});
			})
			.always(function() {
				layer.close(i);
			});

			return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
    
    form.on('submit(repaircard)', function(data){
		data.field.csrf_token = TOKEN;
		data.field.method = 'repair';
		var i = layer.load(2,{shade: [0.5,'#fff']});
			$.ajax({
				url: '/'+ADMIN_DIR+'/repair/repaircardajax/',
				type: 'POST',
				dataType: 'json',
				data: data.field,
			})
			.done(function(res) {
				if (res.code == '1') {
					layer.open({
						type: 1
						,title: '修复数据'
						,offset: 'auto'
						,id: 'layerPayone' //防止重复弹出
						,content: '<div style="padding: 20px 100px;">'+res.msg+'</div>'
						,btn: '关闭'
						,btnAlign: 'c' //按钮居中
						,shade: 0.8 //不显示遮罩
						,yes: function(){
							location.reload();
						}
						,cancel: function(){ 
							location.reload();
						} 
					});
				} else {
					layer.msg(res.msg,{icon:2,time:5000});
				}
			})
			.fail(function() {
				layer.msg('服务器连接失败，请联系管理员',{icon:2,time:5000});
			})
			.always(function() {
				layer.close(i);
			});

			return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });	
    
	exports('adminrepair',null)
});