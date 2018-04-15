@extends('home.user.layout')   

@section('more_css')
    
@endsection

@section('body2')

<div class="personal-top">
    <!-- 还在征稿期就是 -->
   @if( $match->status == 3 )
    <a href="{{ url('match/uploadimg/'.$id) }}" class="submit-btn">继续投稿</a>
    @else
    <a href="#" class="btn btn-warning">截止投稿</a>
     @endif

</div>
<div class="product">
     
    <div class="row
        <div class="col-sm-12">
            <ul class="match-main text-left clearfix">
                @if( count($product) )
                    @foreach($product as $v)
                        <li class="match-check-item" data-id="{{ $v->id }}">
                            <div class="match-img">
                                <img src="{{ url($v->pic) }}" onerror="onerror=null;src='{{url('img/404.jpg')}}'">
                                @if( $v->status == 1 )
                                    <!-- 添加信息 -->
                                    <div class="edit-info-mask">
                                        <a href="{{ url('/user/pic/'.$v->id)}}" class="edit-info-btn">添加信息</a>
                                    </div>
                                @else
                                    <a href="javascript:imgShow({{ $v->id }})" class="match-check-mask">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                            </div>
                            <p>作品标题:{{ mb_substr($v->title,0, 10,'UTF8') }} </p>
                            <p>作品作者:{{ mb_substr($v->author,0, 10,'UTF8') }} </p>
                            @if( $v->status != 3 )
                            <div class="footer">
                                <a href="javascript:imgDel({{ $v->id }})" class="del-btn"><i class="fa fa-close"></i></a>
                                <a href="{{ url('/user/pic/'.$v->id)}}" class="edit-btn"><i class="fa fa-edit"></i></a>
                            </div>
                            @endif
                        </li>
                    @endforeach
                             
                @else
                    <li>
                        <div style="color:red;">暂无数据</div>
                    </li>
                @endif
            </ul>
            <div class="page text-center">
                {{ $product->links() }}
                <!-- <ul class="pagination" style="margin-bottom:100px;">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul> -->
            
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgrater1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal100">
        <div class="modal-content">
            <div class="modal-header" style="padding-left:66px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#imgrater1').removeClass('in').hide()">&times;</button>
              
            </div>
            <div class="modal-body" style="padding-left:66px;">
                <ul class="clearfix">
                    <li class="wrapperimg">
                        <div class="img">
                            <img src="">
                            <span class="prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next"><i class="fa fa-chevron-right"></i></span>
                        </div>
                        <div class="btnrater" match="" round="">
                           
                        </div>
                    </li>
                    <li class="wrapperinfro">
                        <ul>
                            <li style="padding-top:0;">
                                <span>编号</span>
                                <span class="imgId"></span>
                            </li>
                            <li>
                                <span>作品标题</span>
                                <span class="imgTitle"></span>
                            </li>
                            <li>
                                <span>文字描述</span>
                                <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;"></span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
@endsection

@section('other_js')
    <script>
   var solicit_end  = '{{ $match }}';

        function imgShow(id) {
            $('#imgrater1').show().addClass('in');
            
            var modelImg = $('.wrapperimg img');        //显示的img标签路径
            var ImgId = document.getElementsByClassName('imgId')[0];                //显示的编号
            var imgTitle = document.getElementsByClassName('imgTitle')[0];          //显示的作品标题
            var imgDetail = document.getElementsByClassName('imgDetail')[0];        //显示的文字描述
            
            var num;     //点击的作品id在列表id数组中的索引
            //按顺序获取列表内的作品id
            var arrId = [];     //列表id数组
            var id_arr = $('.match-main li');
            for(let i=0;i<id_arr.length;i++){
                var iId = parseInt(id_arr.eq(i).attr('data-id'));
                arrId.push(iId);
                if(iId === id) {
                    num = i;
                }
            }

            // console.log(arrId.indexOf(imgId))        //点击的作品id在列表id数组中的索引
            // console.log(imgId)                       //点击的作品id
            // console.log(arrId)                       //列表的作品id数组

            //显示的内容
            
            var ajax = function(id){        
                return $.ajax({
                    url:'/admin/match/img/'+id,
                    type: 'get',
                    data: {
                    },
                    success: function(data){
                        data = JSON.parse(data)
        //                 console.log(data)
                        modelImg.attr('src','http://a.com/'+data.pic);
                        ImgId.innerHTML = data.id;
                        imgTitle.innerHTML = data.title;
                        imgDetail.innerHTML = data.detail;
                    }
                })
            }
            ajax(id)                         //点击列表中的作品后自动渲染

            //下一个作品详情
            $('.next').unbind().on('click',function(){
                if(num<arrId.length-1){
                    num++;
                    ajax(arrId[num])
                }
            })
            //上一个作品详情
            $('.prev').unbind().on('click',function(){
                if(num>=1){
                    num--;
                    ajax(arrId[num])
                }
            })
        }

        // 删除作品
        function imgDel(id) {
            promptShow('作品管理', '如果你确认删除此作品，里面的内容将全部清空', function() {
                $.ajax({
                type: 'POST',
                url: '/user/del_pic',
                data: { id : id},
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                     if(data[0]==1){
                        window.location.reload();
                    }
                },
                error: function(xhr, type){
                alert('Ajax error!')
                }
                });
            })
        }
        
    </script>
@endsection
