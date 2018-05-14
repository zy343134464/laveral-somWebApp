var commonLsf = {
	/*-----------------------------弹出层-----------------------------------*/
	layerFunc:function (json,func){ 
		var flag,
		closeBtn = json.closeBtn==1?json.closeBtn:0; //取消按钮的显示和隐藏
			var layerTpl = ' <div class="alert alert-danger alert-dismissible layer_alert fade in" role="alert">'+
	'        <div class="alert_div">'+
	'          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+
	'            '+
	'              <h4>'+json.title+'</h4>'+
	'              <div class="alert-cont">'+
	'                  <p>'+json.msg+'</p>'+
	'                  <p style="margin-top:40px;">'+
	'                    <button type="button" class="btn btn-danger" data-dismiss="alert" aria-label="Close" data-status="true">确定</button>'+
	'<button type="button" class="btn btn-default" style="margin-left:18px;"  data-dismiss="alert" aria-label="Close" data-status="false">取消</button>'+
	'                  </p>'+
	'               </div>'+
	'            </div>'+
	'        </div>';
	    $('body').append(layerTpl);
	    if(closeBtn){
	    	closeBtn==0?$('.layer_alert .btn-default').show():$('.layer_alert .btn-default').hide();
	    }

			$('body').on('click','.layer_alert button',function(){

				 flag = $(this).data('status');
				  if(func){
				    	func(flag);
				    }
			})
	},
	/*-----------------------------弹出层 end-----------------------------------*/

	/*-----------------------------搜索-----------------------------------*/
	search_form : function (){
		var getParams = function () {
		    var pairs, 
		        map,
		        params = {},
		        params_name = window.location.search,
		        query = params_name.substr(1);
		    
		    pairs = query.split('&');
		    
		    for (var i=0, len=pairs.length; i<len; i++) {
		        map = pairs[i].split('=');
		         if(map[0]!='kw'){
		            if (map[0] in params) {
		                if (Array.isArray(params[map[0]])) {    // 第三次或更多插入
		                    params[map[0]].push(map[1]);
		                } else {    // 第二次插入
		                    params[map[0]] = [params[map[0]], map[1]];
		                }
		            } else {    // 第一次插入
		                params[map[0]] = map[1];
		            }
		        }        
		    }
		    return params;
		};
	    var url_data =  getParams(),input_html;
	    for (var Key in url_data){
	        if(Key!=''){
	        input_html = '<input type="hidden" name="'+Key+'" value="'+url_data[Key]+'" >';
	        $('.search-form').append(input_html);
	       }
	    }

	    /*$('.search-form').on('click','.fa-search',function(e){
	        var searchInput = $('input[name="kw"]').val();
	        if(!searchInput){
	            commonLsf.layerFunc({title:'提示',msg:"搜索框不能为空",closeBtn:1})
	            return false;
	        }
	        $('.search-form').submit();
	    })*/
		console.log(555555)

	}
	/*-----------------------------搜索 end-----------------------------------*/



}