@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Üzletek</h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($shops->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Név</th>
                            <th scope="col" class="all">Művelet</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($shops as $shop)
                        <tr>
                            <td>{{ $shop->name }}</td>
                            <td>
                                <a href="{{ route('seller_shop_payed_carts',$shop->id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    Megvett termékek
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