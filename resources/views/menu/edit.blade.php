@extends('layouts.admin')

@section('content')

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah {{Route::current()->getName()}} </h4>
                  </div>
                  <div class="card-body">
                    <form method="post" action="{{ route('menu.update' , $single->menuCode) }}"  enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                         
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">menu</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('menuName') is-invalid @enderror" name="menuName" value="{{ $single->menuName }}">
                            @if ($errors->has('menuName'))
                                <span class="text-danger">{{ $errors->first('menuName') }}</span>
                            @endif
                            <input type="hidden" class="form-control @error('creator') is-invalid @enderror" name="creator" value="{{ Auth::user()->email }}">
                        
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Link</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('menuLink') is-invalid @enderror" name="menuLink" value="{{ $single->menuLink }}">
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
                              <option value="1" @if( $single->publish == 1 ) selected @endif >Halaman</option>
                              <option value="2" @if($single->publish == 2 ) selected @endif >Dinamis(fungsi ini butuh development)</option>
                            
                            </select>
                            @if ($errors->has('publish'))
                                <span class="text-danger">{{ $errors->first('publish') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="parent">
                              <option value="0">Parent </option>
                              @foreach($beritakat as $jb)
                              <option value="{{$jb->menuCode}}" @if($single->parent == $jb->menuCode) selected @endif   >{{$jb->menuName}} </option>
                              @endforeach
                            </select>
                            @if ($errors->has('parent'))
                                <span class="text-danger">{{ $errors->first('parent') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto berita</label>
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