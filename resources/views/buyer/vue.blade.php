@extends('buyer.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body">
                <div id="app"></div>
            </div>
        </div>
    </div>
</div>
@endsection