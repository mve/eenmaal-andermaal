<div class="row">
	<div class="col-lg-8 offset-lg-2">
		<h3>{{$title}}</h3>
		<table class="table table-hover" style="width:100%;">
			<thead>
				<tr>
					<th scope="col">Titel</th>
					<th scope="col">Huidig bedrag</th>
					<th scope="col">Einddatum</th>
				</tr>
			</thead>
			<tbody>
				@foreach($auctions as $auction)
				<tr onclick="window.location.assign('{{route('admin.auctions.view', $auction->id)}}')">
					<td>{{$auction->title}}</td>
					<td>€ {{$auction->amount}}</td>
					<td>{{$auction->end_datetime}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>