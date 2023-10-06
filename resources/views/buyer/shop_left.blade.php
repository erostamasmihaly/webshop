<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2">
            <h1>{{ $shop->name }}</h1>
        </div>
        <div class="fw-bold">{!! nl2br($shop->summary) !!}</div>
        @if($shop->body)
            <div>{!! nl2br($shop->body) !!}</div>
        @endif
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Termékek</div>
        <div>
            @if ($products->count() !== 0)
                @include('waiting')
                <table id="datatable" class=" table table-bordered table-striped table-condensed d-none">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Termék neve</th>
                            <th scope="col" class="all">Legnagyobb egységár</th>
                            <th scope="col" class="none">Termékcsoport</th>
                            <th scope="col" class="none">Méretek</th> 
                            <th scope="col" class="none">Nem</th>
                            <th scope="col" class="none">Korosztály</th>
                            <th scope="col" class="none">Rövid leírás</th>
                            <th scope="col" class="all">Művelet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr class="product" product_id="{{ $product->id }}">
                            <td>{{ $product->name }}</td>
                            <td>
                                {{ $product->discount_price }}
                                @if($product->discount)
									<span class="badge rounded-pill bg-danger float-end">
										{{ numformat_with_unit($product->discount,'%') }}
									</span>
								@endif
                            </td>
                            <td>{{ $product->group->category->name }}</td>
                            <td>{{ $product->sizes_list() }}</td>
                            <td>{{ $product->gender->category->name }}</td>
                            <td>{{ $product->age->category->name }}</td>
                            <td>{{ $product->summary }}</td>
                            <td>
                                <a href="{{ route('product',$product->id) }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Megtekintés
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