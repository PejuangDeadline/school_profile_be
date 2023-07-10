@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-school"></i></div>
                            Institution Menu
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Profile</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <!--alert success -->
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('status') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('failed') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!--alert success -->
                    <!--validasi form-->
                        @if (count($errors)>0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                                <li><strong>Data Process Failed !</strong></li>
                                @foreach ($errors->all() as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!--end validasi form-->
                    <div class="sbp-preview">
                        <div class="sbp-preview-content">
                            <form action="{{ url('/institution/profile/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <input class="form-control" id="id_inst" name="id_inst" type="hidden" placeholder="" value="{{ $id_inst }}" />
                            </div>
                            <div class="mb-3">
                                <label><b>Abouts</b></label>
                                <textarea class="my-editor form-control" id="my-editor" name="about" cols="30" rows="10""></textarea>
                            </div>
                            <div class="mb-3">
                                <label><b>Vision</b></label>
                                <input class="form-control" id="id_inst" name="vision" type="text" placeholder=""/>
                            </div>
                            <div class="mb-3">
                                <label><b>Mission</b></label>
                                <input class="form-control" id="id_inst" name="mission" type="text" placeholder=""/>
                            </div>
                            <div class="row mb-3">
                                <label><b>Coordinate</b></label>
                                <div class="col-md-6">
                                    <input class="form-control" id="latitude" name="latitude" type="text" value="{{ old('latitude') }}" autocomplete="off" placeholder="latitude">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" id="longitude" name="longitude" type="text" value="{{ old('longitude') }}" autocomplete="off" placeholder="longitude">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><b>Address</b></label>
                                <textarea class="form-control" id="addr" name="addr" cols="30" rows="3" placeholder=""></textarea>
                            </div>
                            <div class="row mb-3" align="left">
                                <div class="col-md-3">
                                    <span><b>Provinsi</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">Province</small>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="province_by_id" id="province_by_id">
                                        <option class="text-center" value="" selected>- Select Province -</option>
                                        @foreach ($provinces as $province)
                                        <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @csrf
                                <div class="col-md-3">
                                    <span><b>Kota</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">City</small>
                                </div>
                                <div class="col-md-3">
                                    <select name="city" id="city" class="form-control" required>
                                        <option class="text-center" value="">- Select City -</option>
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <div class="row mb-3" align="left">
                                <div class="col-md-3">
                                    <span><b>Kecamatan</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">District</small>
                                </div>
                                <div class="col-md-3">
                                    <select id="district" name="district" class="form-control">
                                        <option class="text-center" value="">- Select District -</option>
                                    </select>
                                </div>
                                @csrf
                                <div class="col-md-3">
                                    <span><b>Kelurahan</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                                </div>
                                <div class="col-md-3">
                                    <select id="subdistrict" name="subdistrict" class="form-control">
                                        <option class="text-center" value="">- Select Subdistrict -</option>
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <div class="row mb-3" align="left">
                                <div class="col-md-3">
                                    <span><b>Kode Pos</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">Postal Code</small>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="zip_code" name="zip_code" class="form-control text-center" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Phone 1</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="phone1" name="phone1" class="form-control" value="" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Phone 2</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="phone2" name="phone2" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Whatsapp</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Instagram</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="instagram" name="instagram" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Facebook</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="facebook" name="facebook" class="form-control" value="" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Twitter</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="twitter" name="twitter" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>PIC</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="pic" name="pic" class="form-control" value="" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>PIC Phone</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="pic_no" name="pic_no" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><b>Owner</b></label>
                                <input class="form-control" id="owner" name="owner" type="text" placeholder=""/>
                            </div>
                            <div class="mb-3">
                                <label><b>Established</b></label>
                                <input class="form-control" id="established" name="established" type="date" placeholder=""/>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>


</main>
<script>
    CKEDITOR.replace('my-editor');
</script>
<script type="text/javascript">
    //ajax mapping city
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="province_by_id"]').on('change', function() {
                        var provinceID = $(this).val();
                        var url = '{{ route("mappingCity", ":id") }}';
                        // console.log(url);
                        url = url.replace(':id', provinceID);
                        // alert(url);
                        if(provinceID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    $('select[name="city"]').empty();
                                    $('select[name="city"]').append(
                                            '<option class="text-center" value="">- Select City -</option>'
                                    );
                                    $.each(data, function(province, value) {
                                        $('select[name="city"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="city"]').empty('<option class="text-center" value="">- Select City -</option>');
                        }
                    });

            });
</script>
<script type="text/javascript">
    //ajax mapping district
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="city"]').on('change', function() {
                        var cityID = $(this).val();
                        var url = '{{ route("mappingDistrict", ":id") }}';
                        url = url.replace(':id', cityID);
                        // alert(url);
                        if(cityID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {

                                    $('select[name="district"]').empty();
                                    $('select[name="district"]').append(
                                            '<option class="text-center" value="">- Select District -</option>'
                                    );
                                    $.each(data, function(city, value) {
                                        $('select[name="district"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="district"]').empty('<option class="text-center" value="">- Select District -</option>');
                        }
                    });

            });
</script>
<script type="text/javascript">
    // ajax mapping subdistric
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="district"]').on('change', function() {
                        var districtID = $(this).val();
                        var url = '{{ route("mappingSubDistrict", ":id") }}';
                        url = url.replace(':id', districtID);

                        if(districtID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {

                                    $('select[name="subdistrict"]').empty();
                                    $('select[name="subdistrict"]').append(
                                            '<option class="text-center" value="">- Select Subdistrict -</option>'
                                    );
                                    $.each(data, function(district, value) {
                                        $('select[name="subdistrict"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="subdistrict"]').empty('<option class="text-center" value="">- Select Subdistrict -</option>');
                        }
                    });

            });
</script>

<script type="text/javascript">
    //ajax mapping postal code
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="subdistrict"]').on('change', function() {
                        var subdistrictID = $(this).val();
                        var url = '{{ route("mappingZipcode", ":id") }}';
                        url = url.replace(':id', subdistrictID);

                        if(subdistrictID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    $.each(data, function(subdistrict, value) {
                                        $('#zip_code').val(value.kodepos);
                                    });
                                }
                            });
                        }else{
                            $('#zip_code').val("");
                        }

                    });

            });
</script>
@endsection
