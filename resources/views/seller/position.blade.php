@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Munkakörök kezelése
        <a href="{{ route('seller_position_create') }}" class="btn btn-primary">Új munkakör</a>
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($positions->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Munkakör neve</th>
                            <th scope="col" class="all">Művelet</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($positions as $position)
                        <tr class="position" position_id="{{ $position->id }}">
                            <td>{{ $position->name }}</td>
                            <td>
                                <a href="{{ route('seller_position_edit',$position->id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Szerkesztés
                                </a> 
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