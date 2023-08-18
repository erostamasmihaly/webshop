<div id="tab3" class="tab-pane fade">
    @if ($users->count() !== 0)
		<table class="datatable table table-bordered table-striped table-condensed">
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
						<a class="btn btn-primary mb-3" href="">Módosítás</a>
					</td>
				</tr>
			   @endforeach
			</tbody>
		</table>
	@endif
</div>