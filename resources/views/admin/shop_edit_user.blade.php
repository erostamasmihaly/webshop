@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <form action="" method="POST" enctype="multipart/form-data">   
        <h4 class="card-title">
            Alkalmazott felvitele
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
                        
                    </div>    
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold mb-3">
                        Munkakör
                    </div>
                    <div class="col-sm-8">
                        
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