@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Kategóriák sorrendje</h4>
    <input type="hidden" id="category_group_id" value="{{ $category_group_id }}" />
    @include('message')
    <div class="card">
        <div class="card-body">
            <div id="container">
                <ul id="sortable"></ul>
            </div>
        </div>
    </div>
    <div class="bg-dark p-3">
        <button type="button" class="btn btn-primary" id="save">Mentés</button>           
    </div>
</div>
<div id="dialog-confirm" title="Kérdés">
    Melyik irányba legyen elmozgatva az előző elemhez képest!?
</div>
@endsection