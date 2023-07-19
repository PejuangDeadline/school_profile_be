@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file"></i></div>
                            Blank Starter
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        @foreach ($branch as $data)
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                {{$data->name}}
                <button class="btn btn-primary btn-sm">Add Feature</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label><b>Abouts</b></label>
                    <p class="my-editor ">{{ $data->about }}</p>
                </div>
                <div class="row mb-3" align="left">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label><b>Vision</b></label>
                            <p class="" id="vision" name="vision" type="text" placeholder="" value="{{ $data->vision }}">{{ $data->vision }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label><b>Mission</b></label>
                            <p class="" id="mission" name="mission" type="text" placeholder="" value="{{ $data->mission }}">{{ $data->mission }}</p>
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><b>Coordinate</b></label>
                        <p class="" id="lat" name="lat" type="text" value="{{ $data->lat }}" autocomplete="off" placeholder="latitude">{{ $data->lat }}.{{ $data->long }}</p>
                        </div>
                    </div>
                    
                </div>
                <div class="mb-3">
                    <label><b>Address</b></label>
                    <p class="" id="addr" name="addr" cols="30" rows="3" placeholder="">{{ old('addr', $data->addr) }}</p>
                </div>
                <div class="row mb-3" align="left">
                    <div class="col-md-3">
                        <span><b>Provinsi</b></span>  <br/>
                        <small class="text-muted" style="font-style: italic;">Province</small>
                    </div>
                    <div class="col-md-3">
                        <p>{{ $data->province }}</p>
                    </div>
                    @csrf
                    <div class="col-md-3">
                        <span><b>Kota</b></span>  <br/>
                        <small class="text-muted" style="font-style: italic;">City</small>
                    </div>
                    <div class="col-md-3">
                        <p>{{ $data->city }}</p>
                    </div>
                </div>
                @csrf
                <div class="row mb-3" align="left">
                    <div class="col-md-3">
                        <span><b>Kecamatan</b></span>  <br/>
                        <small class="text-muted" style="font-style: italic;">District</small>
                    </div>
                    <div class="col-md-3">
                        <p>{{ $data->district }}</p>
                    </div>
                    @csrf
                    <div class="col-md-3">
                        <span><b>Kelurahan</b></span>  <br/>
                        <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                    </div>
                    <div class="col-md-3">
                        <p>{{ $data->sub_district }}</p>
                    </div>
                </div>
                @csrf
                <div class="row mb-3" align="left">
                    <div class="col-md-2">
                        <span><b>Kode Pos</b></span>  <br/>
                        <small class="text-muted" style="font-style: italic;">Postal Code</small>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="zip_code" name="zip_code" class=" text-center" value="{{ $data->zip_code }}" autocomplete="off">{{ $data->zip_code }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span><b>Phone 1</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="phone1" name="phone1" class="" value="{{ $data->phone1 }}" autocomplete="off">{{ $data->phone1 }}</p>
                    </div>
                    <div class="col-md-3">
                        <span><b>Phone 2</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="phone2" name="phone2" class="" value="{{ $data->phone2 }}" autocomplete="off">{{ $data->phone2 }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span><b>Whatsapp</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="whatsapp" name="whatsapp" class="" value="{{ $data->whatsapp }}" autocomplete="off">{{ $data->whatsapp }}</p>
                    </div>
                    <div class="col-md-3">
                        <span><b>Instagram</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="instagram" name="instagram" class="" value="{{ $data->instagram }}" autocomplete="off">{{ $data->instagram }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span><b>Facebook</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="facebook" name="facebook" class="" value="{{ $data->facebook }}" autocomplete="off">{{ $data->facebook }}</p>
                    </div>
                    <div class="col-md-3">
                        <span><b>Twitter</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="twitter" name="twitter" class="" value="{{ $data->twitter }}" autocomplete="off">{{ $data->twitter }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span><b>PIC</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="pic" name="pic" class="" value="{{ $data->pic }}" autocomplete="off">{{ $data->pic }}</p>
                    </div>
                    <div class="col-md-3">
                        <span><b>PIC Phone</b></span>
                    </div>
                    <div class="col-md-3">
                        <p type="text" id="pic_no" name="pic_no" class="" value="{{ $data->pic_no }}" autocomplete="off">{{ $data->pic_no }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label><b>Owner</b></label>
                    <p class="" id="owner" name="owner" type="text" value="{{ $data->owner }}" placeholder="">{{ $data->owner }}</p>
                </div>
                <div class="mb-3">
                    <label><b>Established</b></label>
                    <p class="" id="established" name="established" value="{{ $data->established }}" type="date" placeholder="">{{ $data->established }}</p>
                </div>
            </div>
        </div> 
        @endforeach 
    </div>
</main>
@endsection