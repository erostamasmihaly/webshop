@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Tevékenység napló</h4>
    @include('message')
    <div class="card">
        <div class="card-body">
        @if ($logs->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Művelet</th>
                            <th scope="col" class="all">Típus</th>
                            <th scope="col" class="all">Azonosító</th>
                            <th scope="col" class="none">Létrehozó</th>
                            <th scope="col" class="none">Adatok</th>
                            <th scope="col" class="none">Létrehozva</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($logs as $log)
                        <tr>
                            <td>{{ __($log->description) }}</td>
                            <td>{{ __($log->subject_type) }}</td>
                            <td>{{ $log->subject_name }}</td>
                            <td>{{ $log->causer_name }}</td>
                            <td>{{ $log->properties }}</td>
                            <td>{{ $log->created_at }}</td>
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