@extends('admin.match.create.layout')
@section('title', '投稿要求——团体')
@section('other_css')
<link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}" />
<link rel="stylesheet" href="{{ url('css/admin/match/matchcreate.css') }}" />
@endsection
@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storerequire_team/'.$id) }}" method="post" >
	{{ csrf_field() }}
		<ul class="nav nav-tabs nav-otherjob" role="tablist">
			<li role="presentation" ><a href="{{ url('admin/match/require_personal/'.$id) }}" >个人</a></li>
			<li role="presentation" class="active" ><a href="{{ url('admin/match/require_team/'.$id) }}" >团体</a></li>
		</ul>
		@if(count($require_team))
		@foreach($require_team as $v)
		<div class="match-require">
			<!-- 收费 -->
			<div class="form-group">
                <label for="firstname3" class="col-sm-2 control-label">收费类型</label>
				<div class="col-sm-6">
					<label class="radio-inline">
						<input type="radio" name="pay" value="0" id="only2"  checked>免费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay" value="1" id="only1">每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay" value="2" id="only3">报名费
					</label>
				</div>
				<div>
					<a href="javascript:void(0)" onclick="layerfunc()" class="btn  btn-danger"> 清空本页所有内容</a>
				</div>
            </div>
            <div class="form-group div2">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number" step="0" min="0.00" class="form-control" id="firstname5" placeholder="" name="price"  value="{{ $v->price }}">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group div2">
				<label for="firstname7" class="col-sm-2 control-label">收费说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off"   name="introdution_title"  value="{{ $v->introdution_title }}">
					<textarea class="form-control" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
			</div>
			<!-- end -->
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">单张/组图</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="{{ $v->group_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="{{ $v->group_max }}">
					<span class="input-hint">张/组</span>
				</div>
				<div class="col-sm-3" style="padding-top:6px;padding-left:30px">
					<span>
						<input type="radio" value="2" name="group_limit" {{ $v->group_limit == 2 ? 'checked' : '' }}> 仅限组图
					</span>
					<span>
						<input type="radio" id="only" value="1" name="group_limit"  {{ $v->group_limit == 1 ? 'checked' : '' }}> 仅限单张
					</span>
					<span >
						<input type="radio" value="0" name="group_limit" {{ $v->group_limit == 0 ? 'checked' : '' }}>不限
					</span>
				</div>
			</div>
			<div class="form-group div1">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="{{ $v->num_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="" placeholder="张"  name="num_max" value="{{ $v->num_max }}">
					<span class="input-hint">张</span>

				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="MB" name="size_min" step="0" min="0" value="{{ $v->size_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4" placeholder="MB" name="size_max"  value="{{ $v->size_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="像素"  name="length"  value="{{ $v->length }}">
					<span class="input-hint">px</span>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">补充说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off"  name="introdution_title" value="{{ $v->introdution_title }}">
					<textarea class="form-control" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
			</div>
			<?php
				$tag = json_decode($v->production_info);
				$info = $tag[0];
				$required = [];
				foreach ($info as $infok => $infov) {
					if($tag[1][$infok] == 1)	 {
						$required[] = $infov.'_r';
					}
				}
			?>
			<div class="form-group">
                <label class="col-sm-2 control-label">作品信息</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="author" name="info[]" {{ in_array('author',$info) ? 'checked' : ''}} > 作者姓名
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="author_r" name="required[]" {{ in_array('author_r',$required) ? 'checked' : ''}} > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" {{ in_array('title',$info) ? 'checked' : ''}}> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]"  {{ in_array('title_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>

					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" {{ in_array('detail',$info) ? 'checked' : ''}}> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]"  {{ in_array('detail_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="represent" name="info[]" {{ in_array('represent',$info) ? 'checked' : ''}}> 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="represent_r"  name="required[]"  {{ in_array('represent_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"   value="year" name="info[]" {{ in_array('year',$info) ? 'checked' : ''}}> 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"   value="year_r" name="required[]"  {{ in_array('year_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" {{ in_array('country',$info) ? 'checked' : ''}}> 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]"  {{ in_array('country_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="location" name="info[]" {{ in_array('location',$info) ? 'checked' : ''}}> 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="location_r" name="required[]"  {{ in_array('location_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" {{ in_array('size',$info) ? 'checked' : ''}} > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]"  {{ in_array('size_r',$required) ? 'checked' : ''}}> 必填
						</label>
					</div>
				</div>
            </div>
            <?php
            	unset($tag, $info, $required);

            	$diy = json_decode($v->diy_info,true);
            	$diy_info = isset($diy[0]) ? $diy[0] : [];
            	$diy_required = isset($diy[1]) ? $diy[1] : [];
            ?>
            @if(count($diy_info) && count($diy_required) && count($diy_required) == count($diy_info) && is_array($diy_info))
			@foreach($diy_info as $diyk => $diyv)
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label" >自定义</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off"  name="diy_info[]" value="{{ $diyv}}">
				</div>
				<div class="col-sm-2">
					<select name="diy_required[]">
						<option value ="1" {{ $diy_required[$diyk] == 1 ? 'selected': ''}}>必填</option>
						<option value ="0" {{ $diy_required[$diyk] == 0 ? 'selected': ''}}>选填</option>
					</select>
				</div>
				
			</div>
			@endforeach
			@else
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">自定义</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off" name="diy_info[]" value="">
				</div>
				<div class="col-sm-2">
					<select name="diy_required[]">
						<option value ="1">必填</option>
						<option value ="0" selected>选填</option>
					</select>
				</div>
				
			</div>
			@endif
			<?php
				unset($diy, $diy_info, $diy_required);
			?>
			<p><span id="addVar1_btn" class="col-sm-offset-2" style="margin-left:180px;">+</span></p>
			<!-- <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">多语录入</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="zhongwen" name="zhongwen" checked> 简体中文
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="zhongwen" name="zhongwen_required" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="Chinese_Traditiona" name="Chinese_Traditiona"> 繁体中文
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="Chinese_Traditiona_r" name="Chinese_Traditiona_required"> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="English" name="English"> 英语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="English_r" name="English_required"> 必填
						</label>
					</div>
				</div>
			</div>
 -->
            <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">赛事须知</label>
				<div class="col-sm-8">
					<textarea class="form-control" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
				<div class="col-sm-8 col-sm-offset-2" style="color:#cccccc;">
					(赛事须知为用户必须确认已知才能参与比赛的声明内容)
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-2">
					<button class="btn btn-warning" style="background-color:#d4b179;color:#000;border:none;">创建报名表</button>
				</div>
			</div>
		</div>
		@endforeach
		@else
		<div class="match-require">
			<!-- 收费 -->
			<div class="form-group">
                <label for="firstname3" class="col-sm-2 control-label">收费类型</label>
				<div class="col-sm-6">
					<label class="radio-inline">
						<input type="radio" name="pay" checked value="0" id="only2">免费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="1" id="only1">每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="2" id="only3">报名费
					</label>
				</div>
				<div>
					<a href="javascript:void(0)" onclick="layerfunc()" class="btn  btn-danger"> 清空本页所有内容</a>
				</div>
            </div>
            <div class="form-group div2">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number" step="0" min="0.00" class="form-control" id="firstname5" placeholder="" name="price"  value="">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group div2">
				<label for="firstname7" class="col-sm-2 control-label">收费说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="pay_title"  value="">
					<textarea class="form-control" placeholder="400字内" name="pay_detail" ></textarea>
				</div>
			</div>
			<!-- end -->
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">单张/组图</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="">
				</div>
				<div class="col-sm-3" style="padding-top:6px;padding-left:30px">
					<span>
						<input type="radio" value="2" name="group_limit"> 仅限组图
					</span>
					<span>
						<input type="radio" id="only" value="1" name="group_limit"> 仅限单张
					</span>
					<span >
						<input type="radio" value="0" name="group_limit" checked> 不限
					</span>
				</div>
			</div>
			<div class="form-group div1">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control"  placeholder="张"  name="num_max" value="">
					<span class="input-hint">张</span>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3"  name="size_min" step="0" min="0" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4"  name="size_max"  value="">
					<span class="input-hint">MB</span>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="像素"  name="length"  value="">
					<span class="input-hint">px</span>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">补充说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off"  name="introdution_title" value="">
					<textarea class="form-control"  placeholder="400字内" name="introdution_detail" ></textarea>
				</div>
			</div>
			<div class="form-group">
                <label class="col-sm-2 control-label">作品信息</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="author" name="info[]" checked> 作者姓名
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="author_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" checked> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" checked> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]" checked> 必填
						</label>
					</div>
					
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent" name="info[]" > 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent_r"  name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" value="year" name="info[]" > 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="year_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" > 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]" > 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="location" name="info[]" > 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="location_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]" > 必填
						</label>
					</div>
				</div>
            </div>
			
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">自定义</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题" autocomplete="off" name="diy_info[]" value="">
				</div>
				<div class="col-sm-2">
					<select name="diy_required[]">
						<option value ="1">必填</option>
						<option value ="0" selected>选填</option>
					</select>
				</div>
				
			</div>
			<p><span id="addVar1_btn" class="col-sm-offset-2" style="margin-left:180px;">+</span></p>
			<!-- <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">多语录入</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="zhongwen" name="zhongwen" checked> 简体中文
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="zhongwen" name="zhongwen_required" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="Chinese_Traditiona" name="Chinese_Traditiona"> 繁体中文
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="Chinese_Traditiona_r" name="Chinese_Traditiona_required"> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="English" name="English"> 英语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="English_r" name="English_required"> 必填
						</label>
					</div>
				</div>
			</div> -->

            <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">赛事须知</label>
				<div class="col-sm-8">
					<textarea class="form-control" placeholder="400字内" name="notice" ></textarea>
				</div>
				<div class="col-sm-8 col-sm-offset-2" style="color:#cccccc;">
					(赛事须知为用户必须确认已知才能参与比赛的声明内容)
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-5">
					<a class="btn btn-warning" style="background-color:#d4b179;color:#000;border:none;" title="创建团体表单">创建报名表</a>
				</div>
			</div>
		</div>
		@endif
		<script>
				// $('.navbar-nav li').eq(4).addClass('active');
				var status = true;
					//表单提交事件
		       function addInput (id){
		       	if(status=='false'){
		       		return status;
		       	}else{
		       		status=false;
		       	}
		        var $inputTpl = '<input type="hidden" name="jump" value="'+id+'">';
		        $('.nextPage').prepend($inputTpl);
		        $("form").submit();
		      };
		      function popupTpl (){
		      		// if(confirm('确定跳转到团体投稿吗？')){
		      		// 	addInput (1);
		      		// }else{
		      			addInput (1);	
		      		// };
		      }
		    
		</script>
		<div class="nextPage">
			<button type="submit" class="btn btn-default" style="padding:10px 15px;" onclick="return addInput(0)">上一页</button>
			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-left:20px;" onclick="return addInput(2)">保存</button>
			<button type="submit" class="btn btn-default next-page-btn" style="padding:10px 15px;margin-left:20px;" onclick="return popupTpl()">下一页</button>
			<!-- <a href="{{ url('admin/match/showedit/'.$id) }}" class="btn btn-default" style="padding:10px 15px;margin-left:50px;">预览</a> -->
		</div>
	</form>
</div>
@endsection
@section('other_js')
<script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
<script>
	  $('.match-nav .nav  li').removeClass('active');
	  $('.match-nav .nav  li').eq(4).addClass('active');
	  var url_a = "{{ url('admin/match/del_team/'.$id)}}";
	 function layerfunc() {
	 	commonLsf.layerFunc({title:'提示',msg:'确定清空本页所有内容吗？'},function(flag){
	 		if(flag){
	 			window.location.href = url_a;
	 		}
	 	})
	 }
</script>
<script type="text/javascript" src="{{ url('js/admin/match/matchcreate.js') }}"></script>
@endsection
