@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin_shop_user_update') }}" method="POST" enctype="multipart/form-data">   
        <input type="hidden" name="prev_position_id" value="{{ $prev_position_id }}"/>
        <input type="hidden" name="shop_id" value="{{ $shop_id }}"/>
        <h4 class="card-title">
            @if($user_id==0) Alkalmazott felvitele @else Alkalmazott szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold mb-3">
                        Alkalmazott
                    </div>
                    <div class="col-sm-8">
                        <select name="user_id" class="form-control select2">
                            @foreach($sellers AS $seller)
                                <option value="{{ $seller->id }}" @selected(old('user_id',$user_id)==$seller->id)>{{ $seller->surname }} {{ $seller->forename }}</option>
                            @endforeach
                        </select>
                    </div>    
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold mb-3">
                        Munkakör
                    </div>
                    <div class="col-sm-8">
                        <select name="new_position_id" class="form-control select2">
                            @foreach($positions AS $position)
                                <option value="{{ $position->id }}" @selected(old('new_position_id',$prev_position_id)==$position->id)>{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>    
                </div> 
            </div>
            <div class="bg-dark p-3">
                <div class="submit">
                    <button type="submit" class="btn btn-primary">Mentés</button>            
                </div>
            </div>
        </div>
    </form>
</div>
@endsection