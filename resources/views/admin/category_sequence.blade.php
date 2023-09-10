@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Kategóriák sorrendje</h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            <div id="container">
                <ul id="sortable"></ul>
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="button" class="btn btn-primary">Mentés</button>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection