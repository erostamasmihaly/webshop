@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Kategóriák kezelése
        <a href="{{ route('admin_category_create', $category_group_id) }}" class="btn btn-primary">Új kategória</a>
        <a href="{{ route('admin_category_sequence', $category_group_id) }}" class="btn btn-primary mr-2">Kategóriák sorrendje</a>
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($categories->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a class="btn btn-primary mb-3" href="{{ route('admin_category_edit',$category->id) }}">Szerkesztés</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('empty')
            @endif
        </div>
    </div>
</div>
@endsection