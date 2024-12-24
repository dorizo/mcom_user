@extends('layouts.admin')

@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah {{Route::current()->getName()}} </h4>
                  </div>
                  <div class="card-body">
                    <form method="post" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                        
                        @csrf
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Menu</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('menuName') is-invalid @enderror" name="menuName" value="{{ old('menuName') }}">
                            @if ($errors->has('menuName'))
                                <span class="text-danger">{{ $errors->first('menuName') }}</span>
                            @endif
                            <input type="hidden" class="form-control @error('judul') is-invalid @enderror" name="creator" value="{{ Auth::user()->email }}">
                        
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">LINK</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('menuLink') is-invalid @enderror" name="menuLink" value="{{ old('menuLink') }}">
                            @if ($errors->has('menuLink'))
                                <span class="text-danger">{{ $errors->first('menuLink') }}</span>
                            @endif
                        
                        </div>
                        </div>
                           
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Publish</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="publish">
                              <option value="">Pilih</option>
                              <option value="1" @if(old('publish') == 1 ) selected @endif >halaman</option>
                              <option value="2" @if(old('publish') == 2 ) selected @endif >Dinamis(fungsi ini butuh development)</option>
                            
                            </select>
                            @if ($errors->has('publish'))
                                <span class="text-danger">{{ $errors->first('publish') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Parent</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="parent">
                              <option value="0">Parent</option>
                              @foreach($beritakat as $jb)
                              <option value="{{$jb->menuCode}}" @if(old('parent') == $jb->menuCode ) selected @endif   >{{$jb->menuName}} </option>
                              @endforeach
                            </select>
                            @if ($errors->has('parent'))
                                <span class="text-danger">{{ $errors->first('parent') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Icon</label>
                        <div class="col-sm-12 col-md-7">
                     
                                   <input name="icon" class="form-control form-control-lg" id="icon"
                                           type="file">
                                           @if ($errors->has('icon'))
                                          <span class="text-danger">{{ $errors->first('icon') }}</span>
                                      @endif
                        </div>
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
@endsection