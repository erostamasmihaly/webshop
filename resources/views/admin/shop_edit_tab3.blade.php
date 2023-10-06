<div id="tab3" class="tab-pane fade">
    @if ($users->count() !== 0)
		@include('waiting')
		<table id="datatable" class=" table table-bordered table-striped table-condensed w-100 d-none">
			<thead>
				<tr>
					<th scope="col" class="all">Név</th>
					<th scope="col" class="all">Munkakör</th>
					<th scope="col" class="all">Műveletek</th>
				</tr>
			</thead>
			<tbody>
			   @foreach ($users as $user)
				<tr>
					<td>{{ $user->surname }} {{ $user->forename }}</td>
					<td>{{ $user->position }}</td>
					<td>
						<a class="btn btn-primary mb-3" href="{{ route('admin_shop_user_edit',[$shop->id,$user->user_id,$user->position_id]) }}">Módosítás</a>
					</td>
				</tr>
			   @endforeach
			</tbody>
		</table>
	@else
		@include('empty')
	@endif
	<div>
		<a href="{{ route('admin_shop_user_edit',[$shop->id,0,0]) }}" class="btn btn-primary">Új alkalmazott felvitele</a>
	</div>
</div>