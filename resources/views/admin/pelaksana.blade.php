@extends('layouts.admin')

@section('content')
<style>
    @media (max-width: 575.98px){
        .card.card-large-icons .card-icon {
            height: 100px !important;
        }
        .card.card-large-icons{
            width:100% !important;
        }
    }
        
</style>
<div class="row">
              <div class="col-12 col-sm-12 col-lg-12">
                <div class="card author-box card-primary" style="background:#F2F3F5">
                  <div class="card-body">
                    <div class="author-box-left">
                      <img alt="image" src="{{asset('images/logo.png')}}" width=100%>
                      <div class="clearfix"></div>
                      <a href="#" class="btn btn-primary mt-3">{{$member->nomorinduk}}</a>
                    </div>
                    <div class="author-box-details">
                      <div class="author-box-name">
                        <a href="#"> {{$member->nama_lengkap}}</a>
                      </div>
                      <div class="author-box-job"> {{$member->jabatan->jabatanName}}</div>
                      <div class="author-box-description">
                        <p>
                               
                        </p>
                      </div>
                      <div class="mb-2 mt-3"><div class="text-small font-weight-bold">{{$member->email}}</div></div>
                      
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
@endsection