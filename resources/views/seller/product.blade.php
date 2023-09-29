@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="card-title">Termékek kezelése
        <a href="{{ route('seller_product_create') }}" class="btn btn-primary">Új termék</a>
    </h4>
    @include('message')
    <div class="card">
        <div class="card-body">
            @if ($products->count() !== 0)
                @include('waiting')
                <table class="datatable table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Termék neve</th>
                            <th scope="col" class="desktop">Termékcsoport</th>
                            <th scope="col" class="all">Legnagyobb egységár</th>
                            <th scope="col" class="none">Méretek</th>
                            <th scope="col" class="none">Nem</th>
                            <th scope="col" class="none">Korosztály</th>
                            <th scope="col" class="none">Rövid leírás</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($products as $product)
                        <tr class="product" product_id="{{ $product->id }}">
                            <td>
                                <a href="{{ route('seller_product_edit',$product->id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $product->name }}
                                </a> 
                            </td>
                            <td>{{ $product->group->category->name }}</td>
                            <td>
                                {{ $product->discount_price }}
                                @if($product->discount)
									<span class="badge rounded-pill bg-danger float-end">
										{{ numformat_with_unit($product->discount,'%') }}
									</span>
								@endif
                            </td>
                            <td>{{ $product->sizes_list() }}</td>
                            <td>{{ $product->gender->category->name }}</td>
                            <td>{{ $product->age->category->name }}</td>
                            <td>{!! $product->summary !!}</td>
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