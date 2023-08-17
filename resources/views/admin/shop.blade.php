@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Üzletek kezelése
        <a href="{{ route('admin_shop_create') }}" class="btn btn-primary">Új üzlet</a>
    </h4>
    @include('layouts.message')
    <div class="card">
        <div class="card-body">
            @if ($shops->count() !== 0)
                <table class="datatable table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($shops as $shop)
                        <tr>
                            <td>{{ $shop->name }}</td>
                            <td>
                                <a class="btn btn-primary mb-3" href="{{ route('admin_shop_edit',$shop->id) }}">Szerkesztés</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection