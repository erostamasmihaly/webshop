@extends('buyer.layouts.app')
@viteReactRefresh
@section('content')
<div class="container">
    <div class="row">
        @include('message')
		<div class="card">
			<div class="card-body">
                <div id="main">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection