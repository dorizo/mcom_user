@extends('layouts.admin')

@section('content')

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah {{Route::current()->getName()}} </h4>
                  </div>
                  <div class="card-body">
                  <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah {{Route::current()->getName()}} </h4>
                  </div>
                  <div class="card-body">
                    <form method="post" action="{{ route('menu.menucontent' , $single->menuCode) }}"  enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                         
                      
                        
                        <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-12">
                          <input type="hidden" value="{{$menudata->id }}" name="id" />
                            <textarea class="form-control @error('isi') is-invalid @enderror ckeditor" name="menucontent" >{{$menudata->menucontent }}</textarea>
                            @if ($errors->has('isi'))
                                <span class="text-danger">{{ $errors->first('isi') }}</span>
                            @endif
                        </div>

                        <div class="form-group row mb-4 pt-5">
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary">Publish</button>
                        </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
                    
              </div>
            </div>
@endsection