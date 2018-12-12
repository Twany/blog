var UI = {
	// 加载自定义的alert
	// obj:对象，包含{title:标题,msg:显示的消息,icon:图标[ok,warm,error]}
	alert:function(obj){
		var title = (obj==undefined || obj.title==undefined) ? '系统消息' : obj.title;
		var msg = (obj ==undefined || obj.msg==undefined) ? '' : obj.msg;
		var icon = (obj ==undefined || obj.icon==undefined) ?'warm':obj.icon;

		var html = UI.getAlertHtml().replace('{title}',title).replace('{icon}',icon).replace('{msg}',msg);
		

		$('body').append(html);
		$('#myModal').modal({backdrop:'static'});
		$('#myModal').modal('show');
		$('#myModal').on('hidden.bs.modal', function (e) {
		  $('#myModal').remove();
		})
	},
	// 加载页面
	// obj对象，包含{title:标题,width:窗口宽度,height:窗口高度,url:加载的页面url}
	open:function(obj){
		var title = (obj == undefined || obj.title == undefined) ? '' : obj.title;
		var width = (obj == undefined || obj.width == undefined) ? 500 : obj.width;
		var height = (obj == undefined || obj.height == undefined) ? 450 : obj.height;

		var html = UI.getWinHtml().replace('{title}',title);

		$('body').append(html);
		// 设置模态框的宽度和高度
		$('#myModal .modal-lg').css('width',width);
		$('#myModal .modal-body').css('height',height);

		$('#myModal iframe').attr('src',obj.url);
		$('#myModal').modal({backdrop:'static'});
		$('#myModal').modal('show');
		$('#myModal').on('hidden.bs.modal', function(e){
		  $('#myModal').remove();
		})
	},

	getAlertHtml:function(){
		var html = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
			  <div class="modal-dialog modal-sm" role="document">\
			    <div class="modal-content">\
			      <div class="modal-header">\
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
			        <h4 class="modal-title" id="myModalLabel">{title}</h4>\
			      </div>\
			      <div class="modal-body">\
			        <img src="http://39.107.127.186/Blog/config/images/{icon}.png" style="margin-right:10px;" />{msg}\
			      </div>\
			      <div class="modal-footer">\
			        <button type="button" class="btn btn-primary" onclick="$(\'#myModal\').modal(\'hide\')">确定</button>\
			      </div>\
			    </div>\
			  </div>\
			</div>';
		return html;
	},

	getWinHtml:function(){
		var html = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
			  <div class="modal-dialog modal-lg" role="document">\
			    <div class="modal-content">\
			      <div class="modal-header">\
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
			        <h4 class="modal-title" id="myModalLabel">{title}</h4>\
			      </div>\
			      <div class="modal-body">\
			        <iframe style="width:100%;height:100%" frameborder="0" scrolling="auto">\
			      </div>\
			    </div>\
			  </div>\
			</div>';
		return html;
	}
}