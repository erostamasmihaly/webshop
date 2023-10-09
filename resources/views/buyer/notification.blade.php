@extends('buyer.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title mb-2">
        @if(auth()->user()->unreadNotifications->count()>0)
            <a href="{{ route('buyer_notification_readall') }}" class="btn btn-primary">Összes olvasottnak jelölése</a>
        @endif
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($notifications->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Cím</th>
                            <th scope="col" class="all">Termék</th>
                            <th scope="col" class="desktop">Dátum</th>
                            <th scope="col" class="all">Látta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications AS $notification)
                            <tr>
                                <td>{{ $notification->data['subject'] }}</td>
                                <td>
                                    <a href="{{ route('product',$notification->data['product_id']) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $notification->data['product_name'] }}</a>
                                </td>
                                <td>{{ show_date($notification->created_at) }}</td>
                                <td>
                                    @if($notification->read_at)
                                        {{ show_date($notification->read_at) }}
                                    @else
                                        <a class="btn btn-primary" href="{{ route('buyer_notification_read',$notification->id) }}"><i class="fa-solid fa-check"></i></a>
                                    @endif
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