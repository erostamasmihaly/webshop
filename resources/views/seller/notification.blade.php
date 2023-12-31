@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Értesítések kezelése
        @if(auth()->user()->unreadNotifications->count()>0)
            <a href="{{ route('seller_notification_readall') }}" class="btn btn-primary">Összes olvasottnak jelölése</a>
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
                            <th scope="col" class="none">Üzlet</th>
                            <th scope="col" class="none">Felhasználó</th>
                            <th scope="col" class="none">Leírás</th>
                            <th scope="col" class="desktop">Dátum</th>
                            <th scope="col" class="all">Látta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications AS $notification)
                            <tr>
                                <td>{{ $notification->data['subject'] }}</td>
                                <td>
                                    <a href="{{ route('seller_product_edit',$notification->data['product_id']) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $notification->data['product_name'] }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('shop',$notification->data['shop_id']) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $notification->data['shop_name'] }}</a>
                                </td>
                                <td>{{ $notification->data['user_name'] }}</td>
                                <td>
                                    @if(isset($notification->data['body']))
                                        {!! $notification->data['body'] !!}
                                    @endif
                                </td>
                                <td>{{ show_date($notification->created_at) }}</td>
                                <td>
                                    @if($notification->read_at)
                                        {{ show_date($notification->read_at) }}
                                    @else
                                        <a class="btn btn-primary" href="{{ route('seller_notification_read',$notification->id) }}"><i class="fa-solid fa-check"></i></a>
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