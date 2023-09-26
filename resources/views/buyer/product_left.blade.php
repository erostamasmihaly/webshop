<div class="col-sm-8 mb-2">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark mb-2 p-2">
            <h1 class="float-start">{{ $product->name }}</h1>
            <span class="float-end fw-bold">
                @if(has_role('vásárló'))
                    <span class="unfav @if(!$is_fav) d-none @endif">
                        <i class="fa-solid fa-thumbs-up fa-2xl"></i>
                    </span>
                    <span class="fav @if($is_fav) d-none @endif">
                        <i class="fa-regular fa-thumbs-up fa-2xl"></i>
                    </span>
                @else
                    <i class="fa-solid fa-thumbs-up fa-2xl text-secondary"></i> 
                @endif
                <br><span class="fav_total">{{ $fav_total }}</span> db
            </span>
        </div>
        <div class="row">
            <div class="col-sm-3 fw-bold">Bolt neve</div>
            <div class="col-sm-9">
                <a href="{{ route('shop',$product->shop_id) }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $product->shop->name }}</a>
            </div>
            <div class="col-sm-3 fw-bold">Termékcsoport</div>
            <div class="col-sm-9">{{ $product->group->category->name }}</div>
            <div class="col-sm-3 fw-bold">Méretek</div>
            <div class="col-sm-9">{{ implode(', ',$product->size_names()) }}</div>
            <div class="col-sm-3 fw-bold">Nem</div>
            <div class="col-sm-9">{{ $product->gender->category->name }}</div>
            <div class="col-sm-3 fw-bold">Korosztály</div>
            <div class="col-sm-9">{{ $product->age->category->name }}</div>
            <div class="col-sm-3 fw-bold">Mennyiség</div>
            <div class="col-sm-9">{{ $product->quantity }} {{ $product->unit->category->name }}</div>
            <div class="col-sm-3 fw-bold">Rövid leírás</div>
            <div class="col-sm-9">{!! nl2br($product->summary) !!}</div>
            <div class="col-sm-3 fw-bold">Részletes leírás</div>
            <div class="col-sm-9">{!! nl2br($product->body) !!}</div>
        </div>
        <div>
            <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">
                <div>Értékelések</div>
                <div>
                    <span id="title_fa_stars"></span> (<span id="title_total"></span> db)
                </div>
            </div>
            <div>
                <table id="ratings" class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th scope="col" class="all">Felhasználó neve</th>
                            <th scope="col" class="all">Értékelés címe</th>
                            <th scope="col" class="all">Értékelés</th>
                            <th scope="col" class="none">Értékelés szövege</th>
                            <th scope="col" class="none">Dátum</th>
                        </tr>
                    </thead>
                </table>
            </div>
            @if($is_buyed!=null)
                <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Értékelés megadása</div>
                <input type="hidden" id="user_id" value="{{ Auth::id() }}"/>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">Cím</div>
                    <div class="col-sm-9">
                        <input type="text" id="title" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">Szöveg</div>
                    <div class="col-sm-9">
                        <textarea id="body" class="form-control tinyeditor"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 fw-bold">Értékelés</div>
                    <div class="col-sm-9">
                        <select id="stars" class="form-control">
                            @foreach($rating_names AS $rating_name)
                                <option value="{{ $rating_name->sequence}}">{{ $rating_name->sequence }} csillag - {{ $rating_name->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="alert alert-info" role="alert">
                    Ha már egyszer értékelte a terméket, akkor az új értékelés esetén azon régi értékelése lesz módosítva! Minden egyes értékelés csak akkor jelenik meg (újra), ha azt az üzlet valamelyik alkalmazottja elfogadja! Így emiatt szíves türelmüket és megértésüket kérjük!
                </div>
                <div class="alert alert-success d-none" role="alert" id="rating_success">
                    Az érkékelés beküldése sikeres volt! Jelenleg moderálás alatt áll...
                </div>
                <div class="alert alert-danger d-none" role="alert" id="rating_error">
                    Az érkékelés beküldése sikertelen volt! kérjük próbálja meg újra!
                </div>
                <div>
                    <button class="btn btn-primary float-end" id="send_rating">Elküldés</button>
                </div>
            @endif
        </div>
    </div>
</div>