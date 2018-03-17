@extends('admin.layout')   
@section('title', '会籍管理')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/user/membership.css') }}">
@endsection()

@section('body')
<section class="content">
    <div class="row">
        <form class="form-horizontal" role="form"  action="{{ url('admin/user/set_role') }}"  method="post">
        {{ csrf_field() }}
            <div class="col-xs-11">
                <h5 class="vip-rule">
                    会员章程
                </h5>
                <div class="vip-content">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">标题</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="member_title" @if( $organ ) value="{{$organ->member_title}}" @else placeholder="输入标题" value="" @endif >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">正文</label>
                        <div class="col-sm-10">
                           <textarea class="form-control" rows="8" name="member_content" @if( $organ ) value="{{$organ->member_content}}" @else placeholder="输入正文" value="" @endif></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-11" style="position: relative;">
                <h5 class="vip-rank">
                    会籍
                </h5>
                <div class="vip-content" style="padding-bottom:50px;">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">名称</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" @if( $roles ) name="role_name" value="{{$roles->role_name}}" @else placeholder="输入标题" value="" @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">是否收费</label>
                        <label class="radio-inline" style="margin-left:20px;">
                            <input type="radio" value="1" name="free" @if( $roles ) @if( $roles->free == 1 ) checked @endif @endif> 是
                        </label>
                        <label class="radio-inline" style="margin-left:36px;">
                            <input type="radio" value="0" name="free" @if( $roles ) @if( $roles->free == 0 ) checked @endif @endif> 否
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">期限</label>
                        <div class="col-sm-2">
                            <label class="radio-inline" style="margin-left:4px;">
                                <input type="radio" value="0" name="cycle" @if( $roles ) @if( $roles->cycle == 0 ) checked @endif @endif> 终身制
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="365" name="cycle" @if( $roles ) @if( $roles->cycle == 365 ) checked @endif @endif> 年费制
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="price" @if( $roles ) value="{{$roles->price}}" @else placeholder="人民币" value="" @endif>
                        </div>
                        <div class="col-sm-1" style="padding-top:8px;margin-left:-20px;">RMB</div>
                    </div>
                </div>
                <div class="vip-detail">
                    <div class="form-group">
                        <textarea class="form-control" rows="8" name="desc" style="width:400px;" >@if( $roles ) {{$roles->desc}} @else 输入正文 @endif</textarea>
                    </div>
                </div>
                <input class="btn btn-default" value="保存" type="submit"></input>
            </div>
        </form>
    </div>
</section>

@endsection
@section('other_js')
    <script src="{{ url('js/admin/user/membership.js') }}"></script>
@endsection