@extends('admin.layout')  
@section('title', '新闻资讯页')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/user/user.css') }}">
@endsection


@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--搜索框-->
                <form action="{{ url('/admin/user')}}" >
                    <div class="search-form">
                        <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
                        <input type="text" name="kw" placeholder="在当前条件下搜索比赛">
                    </div>
                </form>
                <!--新建图文-->
                <div class="batch-export">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button">
                            新建图文
                        </button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>名称</th>
                                <th>发布日期</th>
                                <th>阅读人数</th>
                                <th>置顶\编辑\删除</th>
                            </tr>
                            </thead>
                            <tbody class="panel panel-default">
                            <tr>
                                <td>
                                    <input type="checkbox">
                                </td>
                                <td>SOM测试比赛</td>
                                <td>2017年6月5日12:00</td>
                                <td>9999</td>
                                <td>
                                	<span>1</span>
                                	<span>2</span>
                                	<span>3</span>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
<!-- /.content-wrapper -->
@endsection

@section('other_js')
   
@endsection