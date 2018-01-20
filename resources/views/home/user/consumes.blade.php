@extends('home.user.layout')   


@section('more_css')

@endsection

@section('body2')
<table cellpadding="4" cellspacing="10" width="100%">
	<thead>
		<th>缴费项目</th>
		<th>缴费金额</th>
		<th>缴费日期</th>
	</thead>
	<tbody>
		<tr>
			<td>XXX摄影大赛缴费</td>
			<td>200.00RMB</td>
			<td>2017/02/03 18:00</td>
		</tr>
		<tr>
			<td>XXX摄影大赛缴费</td>
			<td>200.00RMB</td>
			<td>2017/02/03 18:00</td>
		</tr>
		<tr>
			<td>XXX摄影大赛缴费</td>
			
			<td>200.00RMB</td>
			<td>2017/02/03 18:00</td>
		</tr>
		<tr>
			<td>XXX摄影大赛缴费</td>
			<td>200.00RMB</td>
			<td>2017/02/03 18:00</td>
		</tr>
		<tr>
			<td>XXX摄影大赛缴费</td>
			<td>200.00RMB</td>
			<td>2017/02/03 18:00</td>
		</tr>
	</tbody>
</table>
<div class="paging text-center">
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<li>
				<a href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">...</a></li>
			<li><a href="#">99</a></li>
			<li><a href="#">100</a></li>
			<li>
				<a href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>
</div>
@endsection

@section('other_js')

@endsection