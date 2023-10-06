@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Kategória csoportok kezelése
        <a href="{{ route('admin_category_group_create') }}" class="btn btn-primary">Új kategória csoport</a>
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($category_groups->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($category_groups as $category_group)
                        <tr>
                            <td>{{ $category_group->name }}</td>
                            <td>
                                <a class="btn btn-primary mb-3" href="{{ route('admin_category_group_edit',$category_group->id) }}">Szerkesztés</a>
                                <a class="btn btn-primary mb-3" href="{{ route('admin_category',$category_group->id) }}">Kategóriák</a>
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