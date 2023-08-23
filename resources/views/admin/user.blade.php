@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Felhasználók kezelése
        <a href="{{ route('admin_user_create') }}" class="btn btn-primary">Új felhasználó</a>
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($users->count() !== 0)
                @include('waiting')
                <table class="datatable table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">E-mail cím</th>
                            <th scope="col" class="desktop">Létrehozva</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at}}</td>
                            <td>
                                <a class="btn btn-primary mb-3" href="{{ route('admin_user_edit',$user->id) }}">Szerkesztés</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @else
                @include('layouts.empty')
            @endif
        </div>
    </div>
</div>
@endsection