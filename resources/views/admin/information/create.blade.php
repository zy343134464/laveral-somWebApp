@extends('admin.layout')
@section('title', '新建咨询')

@section('body')
<br>
<br><h3>新建咨询</h3>
<form action="{{ url('admin/information/store')}}" method="post">
	{{ csrf_field() }}

    标题:<input type="text" name="title"><br>
	副标题:<input type="text" name="sec_title"><br>
	<div class="col-sm-10">  
    @include('vendor.UEditor.head')  
    <!-- 加载编辑器的容器 -->  
    <script id="container" name="content" type="text/plain" style='width:100%;height:300px;'>  
    </script>  
    <!-- 实例化编辑器 -->  
    <script type="text/javascript">  
        var ue = UE.getEditor('container',{
        	 toolbars: [
			    ['fullscreen', 'fontsize', 'undo', 'redo','selectall','removeformat','cleardoc','time','date',
                'inserttable', //插入表格
                'insertrow', //前插入行
                'insertcol', //前插入列
                'mergeright', //右合并单元格
                'mergedown', //下合并单元格
                'deleterow', //删除行
                'deletecol', //删除列
                'splittorows', //拆分成行
                'splittocols', //拆分成列
                'splittocells', //完全拆分单元格
                'deletecaption', //删除表格标题
                'inserttitle', //插入标题
                'mergecells', //合并多个单元格
                'deletetable', 
                'simpleupload',
                        ],['bold','italic',
                'underline', //下划线
                'strikethrough', //删除线
                'superscript', //上标
                'subscript', //下标
                'fontborder', //字符边框
                'horizontal', //分隔线
                'paragraph', //段落格式
                'emotion', //表情
                'spechars', //特殊字符
                'justifyleft', //居左对齐
                'justifyright', //居右对齐
                'justifycenter', //居中对齐
                'justifyjustify', //两端对齐
                'forecolor', //字体颜色
                'backcolor', //背景色
                'directionalityltr', //从左向右输入
                'directionalityrtl', //从右向左输入
                'rowspacingtop', //段前距
                'rowspacingbottom', //段后距
                'imagenone', //默认
                'imageleft', //左浮动
                'imageright', //右浮动
                'imagecenter', //居中
                'lineheight', //行间距 
                'autotypeset', //自动排版
                'touppercase', //字母大写
                'tolowercase', //字母小写
                'template', //模板
            ],
        ]
        });  
        ue.ready(function(){  
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');   
        });  
    </script>  
	</div> 
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<input type="submit" value="保存">
</form>
@endsection