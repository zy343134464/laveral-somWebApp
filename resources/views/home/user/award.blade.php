@extends('home.user.layout')   


@section('more_css')

@endsection

@section('body2')
<div class="award">
	<table cellpadding="4" cellspacing="10" width="100%">
		<thead>
			<th>赛事名称</th>
			<th>获得名次</th>
			<th>赛事日期</th>
		</thead>
		<tbody>
			<tr>
				<td>XXX摄影大赛</td>
				<td>第一名</td>
				<td>2017/02/03 18:00</td>
			</tr>
			<tr>
				<td>XXX摄影大赛</td>
				<td>第一名</td>
				<td>2017/02/03 18:00</td>
			</tr>
			<tr>
				<td>XXX摄影大赛</td>
				
				<td>第一名</td>
				<td>2017/02/03 18:00</td>
			</tr>
			<tr>
				<td>XXX摄影大赛</td>
				<td>第一名</td>
				<td>2017/02/03 18:00</td>
			</tr>
			<tr>
				<td>XXX摄影大赛</td>
				<td>第一名</td>
				<td>2017/02/03 18:00</td>
			</tr>
		</tbody>
	</table>
	<div class="page text-center">
		<ul class="pagination" style="margin-bottom:100px;">
		    <li><a href="#">&laquo;</a></li>
		    <li class="active"><a href="#">1</a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		    <li><a href="#">5</a></li>
		    <li><a href="#">&raquo;</a></li>
		</ul>
    </div>
</div>


@endsection
