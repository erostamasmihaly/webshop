@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin_category_group') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $category_group->id }}"/>    
        <h4 class="card-title">
            @if($category_group->id==0) Kategória csoport hozzáadása @else Kategória csoport szerkesztése @endif
        </h4>
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-body row">
                <div class="col-sm-4 fw-bold mb-3">
                    Név *
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="{{ old('name', $category_group->name) }}"/>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                    @endif
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