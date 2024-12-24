@extends('layouts.admin')

@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah {{Route::current()->getName()}} </h4>
                  </div>
                  <div class="card-body">
                    <form method="post" action="{{ route('beritas.store') }}" enctype="multipart/form-data">
                        
                        @csrf
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}">
                            @if ($errors->has('judul'))
                                <span class="text-danger">{{ $errors->first('judul') }}</span>
                            @endif
                            <input type="hidden" class="form-control @error('judul') is-invalid @enderror" name="creator" value="{{ Auth::user()->email }}">
                        
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Publish</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="publish">
                              <option value="">Pilih</option>
                              <option value="1" @if(old('publish') == 1 ) selected @endif >Publish</option>
                              <option value="2" @if(old('publish') == 2 ) selected @endif >tidah</option>
                            
                            </select>
                            @if ($errors->has('publish'))
                                <span class="text-danger">{{ $errors->first('publish') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="beritakatCode">
                              <option value="">Pilih</option>
                              @foreach($beritakat as $jb)
                              <option value="{{$jb->beritakatCode}}" @if(old('beritakatCode') == $jb->beritakatCode) selected @endif   >{{$jb->beritakatName}} </option>
                              @endforeach
                            </select>
                            @if ($errors->has('beritakatCode'))
                                <span class="text-danger">{{ $errors->first('beritakatCode') }}</span>
                            @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto berita</label>
                        <div class="col-sm-12 col-md-7">
                     
                                   <input name="gambar" class="form-control form-control-lg" id="gambar"
                                           type="file">
                                           @if ($errors->has('gambar'))
                                          <span class="text-danger">{{ $errors->first('gambar') }}</span>
                                      @endif
                        </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-12">
                            <textarea class="form-control @error('isi') is-invalid @enderror ckeditor" name="isi" >{{ old('isi') }}</textarea>
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
@endsection