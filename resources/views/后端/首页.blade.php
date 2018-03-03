@extends('admin.layout')   
@section('title', '首页')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/index/index.css') }}">
@endsection()
 

@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--搜索框-->
                <form action="{{ url('/admin/user')}}" >
                    <div class="search-form">
                        <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
                        <input type="text" name="kw" placeholder="请输入手机或用户名">
                    </div>
                </form>
                <div class="title">
                    正在进行中的赛事 <span>1</span>个 待处理事项 <span>1</span>个
                </div>
                <div class="tab-title">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#">所有事项</li></a>
                        <!-- <li role="presentation"><a href="#">赛事相关</a></li>
                        <li role="presentation"><a href="#">团体会员申请</a></li> -->
                    </ul>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="text-align:left;">事项名称</th>
                                <th>发生时间</th>
                                <th>处理状态</th>
                                <th>处理人</th>
                                <th>标为已读/没读</th>
                            </tr>
                            </thead>
                            <tbody class="panel panel-default">
                                <tr data-toggle="modal" data-target="#myModal">
                                    <td style="text-align:left;">
                                        <i class="fa fa-circle"></i>
                                        <span class="inner-title">SOM测试比赛 2018/2/6日志</span>
                                    </td>
                                    <td>2018年2月5日</td>
                                    <td>没处理</td>
                                    <td>-</td>
                                    <td>
                                        <span>
                                            <a href="#"><i class="fa fa-check"></i></a>
                                        </span>
                                        <span>
                                            <a href="#"><i class="fa fa-close"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr data-toggle="modal" data-target="#myModal">
                                    <td style="text-align:left;">
                                        <i class="fa fa-circle"></i>
                                        <span class="inner-title">广州青年摄影 团队会员申请</span>
                                    </td>
                                    <td>2018年2月6日</td>
                                    <td>已查阅</td>
                                    <td>martin</td>
                                    <td>
                                        <span>
                                            <a href="#"><i class="fa fa-check"></i></a>
                                        </span>
                                        <span>
                                            <a href="#"><i class="fa fa-close"></i></a>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
<!-- /.content-wrapper -->

<!-- 点击列表模态框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                截止<span>2018年2月6日</span>本比赛赛果如下:<br>
                赛事进行阶段第二轮，作品数量200个。已完成评审操作5人，尚没完成评审操作2人。<br>
                距离本轮预定结束时间还剩余3日。<br>
                <a href="#">进入评审室</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">
                    已查阅
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">以后再说
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
@endsection
@section('other_js')
    <script src="{{ url('js/admin/index/index.js') }}"></script>
@endsection