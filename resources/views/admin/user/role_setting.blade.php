@extends('admin.layout')   
@section('title', '会籍管理')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/user/membership.css') }}">
@endsection()

@section('body')
<section class="content">
    <div class="row">
        <form class="form-horizontal" role="form">
            <div class="col-xs-11">
                <h5 class="vip-rule">
                    会员章程
                </h5>
                <div class="vip-content">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">标题</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="输入标题">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">正文</label>
                        <div class="col-sm-10">
                           <textarea class="form-control" rows="8" placeholder="输入正文"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-11" style="position: relative;">
                <h5 class="vip-rank">
                    会籍级别一
                </h5>
                <div class="vip-content" style="padding-bottom:50px;">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">名称</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="输入标题">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">是否收费</label>
                        <label class="radio-inline" style="margin-left:20px;">
                            <input type="radio" value="option1" name="cost" checked> 是
                        </label>
                        <label class="radio-inline" style="margin-left:36px;">
                            <input type="radio" value="option2" name="cost"> 否
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">期限</label>
                        <div class="col-sm-2">
                            <label class="radio-inline" style="margin-left:4px;">
                                <input type="radio" value="option1" name="time" checked> 终身制
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="option2" name="time"> 年费制
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="人民币">
                        </div>
                        <div class="col-sm-1" style="padding-top:8px;margin-left:-20px;">RMB</div>
                    </div>
                </div>
                <div class="vip-detail">
                    <div class="form-group">
                        <textarea class="form-control" rows="8" placeholder="输入正文" style="width:400px;"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
@section('other_js')
    <script src="{{ url('js/admin/user/membership.js') }}"></script>
@endsection