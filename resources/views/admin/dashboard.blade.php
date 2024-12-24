@extends('layouts.admin')

@section('content')
<div class="row">
  
<div class="col-lg-12 col-md-12 col-sm-12">
  <form>
    <div class="card card-statistic-2">
                    <div class="card-stats">
                    <div class="card-stats-title">CARI
                     <div class="card-stats-items">
                        <div class="col-5">
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">BULAN</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="bulan">
                              <option value="">Pilih</option>
                              @for ($i = 1; $i <= 12; $i++)
                              <option value="{{ $i }}" @if($bulan == $i ) selected @endif >{{ $i }}</option>
                              @endfor
                            </select>
                            @if ($errors->has('bulan'))
                                <span class="text-danger">{{ $errors->first('bulan') }}</span>
                            @endif
                        </div>
                        </div>
                        </div>
                        <div class="col-5"> <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">TAHUN</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" name="tahun">
                            {{ $last= date('Y')-120 }}
                             {{ $now = date('Y') }}
                             <option value="">Pilih</option>
                              @for ($i = $now; $i >= $last; $i--)
                              <option value="{{ $i }}"  @if($tahun == $i ) selected @endif >{{ $i }}</option>
                              @endfor
                            
                            </select>
                            @if ($errors->has('tahun'))
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            @endif
                        </div>
                        </div>
                       </div>
                        <div class="col-2">  
                        <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary">Cari</button>
                        </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    </div>
    </div>
  </form>
</div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Jumlah Member
                    
                  </div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?=$JPTMADYA?></div>
                      <div class="card-stats-item-label">JPT MADYA</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?=$JPTPRATAMA?></div>
                      <div class="card-stats-item-label">JPT PRATAMA</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?=$ADMINISTRATOR?></div>
                      <div class="card-stats-item-label">ADMINISTRATOR</div>
                    </div>
                  </div>
                  <div class="card">
                  <div class="row p-3 mb-3 card-stats-items">
                  
                    <div class="card-stats-item ">
                      <div class="card-stats-item-count"><?=$PENGAWAS?></div>
                      <div class="card-stats-item-label">PENGAWAS</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?=$Pelaksana?></div>
                      <div class="card-stats-item-label">Pelaksana</div>
                    </div>
                  </div>
                </div>
                </div>
               
                
                
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fcfcfc}</style><path d="M0 64C0 46.3 14.3 32 32 32h80c79.5 0 144 64.5 144 144c0 58.8-35.2 109.3-85.7 131.7l51.4 128.4c6.6 16.4-1.4 35-17.8 41.6s-35-1.4-41.6-17.8L106.3 320H64V448c0 17.7-14.3 32-32 32s-32-14.3-32-32V288 64zM64 256h48c44.2 0 80-35.8 80-80s-35.8-80-80-80H64V256zm256-96h80c61.9 0 112 50.1 112 112s-50.1 112-112 112H352v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V352 192c0-17.7 14.3-32 32-32zm80 160c26.5 0 48-21.5 48-48s-21.5-48-48-48H352v96h48z"/></svg>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>PEMASUKAN BULAN INI</h4>
                  </div>
                  <div class="card-body">
                   
                  @rupiah($iuran)
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fcfcfc}</style><path d="M0 64C0 46.3 14.3 32 32 32h80c79.5 0 144 64.5 144 144c0 58.8-35.2 109.3-85.7 131.7l51.4 128.4c6.6 16.4-1.4 35-17.8 41.6s-35-1.4-41.6-17.8L106.3 320H64V448c0 17.7-14.3 32-32 32s-32-14.3-32-32V288 64zM64 256h48c44.2 0 80-35.8 80-80s-35.8-80-80-80H64V256zm256-96h80c61.9 0 112 50.1 112 112s-50.1 112-112 112H352v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V352 192c0-17.7 14.3-32 32-32zm80 160c26.5 0 48-21.5 48-48s-21.5-48-48-48H352v96h48z"/></svg>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>PENGELUARAN BULAN INI</h4>
                  </div>
                  <div class="card-body">
                   
                  @rupiah($pengeluaran)
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>TOTAL MEMBER TRANSAKSI</h4>
                  </div>
                  <div class="card-body">
                   <?=$memberall?>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-8 col-md-8 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">
                    Anggota PER PRODUK
                  </div>
                    <div class="card-stats-items" style="height:150px">
                    <div class="row">
                      @foreach($kategori as $kats)
                      <div class="card-stats-item col-3 card">
                        <div class="card-stats-item-count">{{App\Models\Member::where("id_member_kats" , $kats->id_member_kats)->count()}}</div>
                        <div class="card-stats-item-label">
                        <a href="{{URL::to('member?cari=')}}{{$kats->memberkatName}}" target="_BLANK">
                        {{$kats->memberkatName}}
                        </a>
                        </div>
                      </div>
                      @endforeach
                    </div>

                    </div>
                  </div>
                </div>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Invoices</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Due Date</th>
                        <th>Action</th>
                      </tr>
                      @foreach($member as $mem)
                      <tr>
                        <td><a href="#">INV-{{$mem->iuran_membersCode}}</a></td>
                        <td class="font-weight-600">{{$mem->member->nama_lengkap}}</td>
                        <td>{{$mem->bulan}}-{{$mem->tahun}}</td>
                        <td>
                          <a href="#" class="btn btn-primary">Detail</a>
                        </td>
                      </tr>
                      @endforeach
                    
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          @endsection