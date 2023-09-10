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
                            Branch Menu
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
                    <h3 class="card-title">Edit Branch</h3>
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
                            <form action="{{ url('/branch/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <input class="form-control" id="id_branch" name="id_branch" type="hidden" placeholder="" value="{{ $id_branch }}" />
                                <input class="form-control" id="id_institution" name="id_institution" type="hidden" placeholder="" value="{{ $branch->id_institution }}" />
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <select name="grade" id="grade" class="form-control">
                                        <option value="">- Please Select Grade -</option>
                                        {{-- <option value="{{$branch->grade}}" selected>{{$branch->grade}}</option> --}}
                                        @foreach ($dropdownGrades as $grade)
                                            {{-- <option value="{{ $grade->name_value }}">{{ $grade->name_value }}</option> --}}
                                            <option value="{{$branch->grade}}" {{ $grade->name_value == $branch->grade ? 'selected' : '' }}>{{ $grade->name_value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" id="name" name="name" type="text" value="{{ $branch->name }}" placeholder="Input Branch Name"/>
                            </div>
                            <div class="mb-3">
                                <label><b>Abouts</b></label>
                                <textarea id="editabout" class="form-control" name="about" rows="10" cols="50">{{ $branch->about }}</textarea>
                                <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
                                <script>
                                      CKEDITOR.replace('editabout', {
                                          language:'en-gb'
                                      });
                                  </script>
                            </div>
                            <div class="mb-3">
                                <label><b>Vision</b></label>
                                <input class="form-control" id="vision" name="vision" type="text" placeholder="" value="{{ $branch->vision }}"/>
                            </div>
                            <div class="mb-3">
                                <label><b>Mission</b></label>
                                <textarea id="editmission" class="form-control" name="mission" rows="10" cols="50">{{ $branch->mission }}</textarea>
                                <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
                                <script>
                                      CKEDITOR.replace('editmission', {
                                          language:'en-gb'
                                      });
                                  </script>
                            </div>
                            <div class="row mb-3">
                                <label><b>Coordinate</b></label>
                                <div class="col-md-6">
                                    <input class="form-control" id="lat" name="lat" type="text" value="{{ $branch->lat }}" autocomplete="off" placeholder="latitude">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" id="long" name="long" type="text" value="{{ $branch->long }}" autocomplete="off" placeholder="longitude">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><b>Address</b></label>
                                <textarea class="form-control" id="addr" name="addr" cols="30" rows="3" placeholder="">{{ old('addr', $branch->addr) }}</textarea>
                            </div>
                            <div class="row mb-3" align="left">
                                <div class="col-md-3">
                                    <span><b>Provinsi</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">Province</small>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="province_by_id" id="province_by_id">
                                        <option class="text-center" value="{{ $branch->province }}" selected>{{ $branch->province }}</option>
                                        @foreach ($provinces as $province)
                                        <option class="text-center" value="{{ $province['id'] }}" {{ $province['nama'] == $branch->province ? 'selected' : '' }}>{{ $province['nama'] }}</option>
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
                                        <option class="text-center" value="{{ $branch->city }}" {{ $branch->city ? 'selected' : '' }}>{{ $branch->city }}</option>
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
                                        <option class="text-center" value="{{ $branch->district }}" {{ $branch->district ? 'selected' : '' }}>{{ $branch->district }}</option>
                                    </select>
                                </div>
                                @csrf
                                <div class="col-md-3">
                                    <span><b>Kelurahan</b></span>  <br/>
                                    <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                                </div>
                                <div class="col-md-3">
                                    <select id="subdistrict" name="subdistrict" class="form-control">
                                        <option class="text-center" value="{{ $branch->sub_district }}" {{ $branch->sub_district ? 'selected' : '' }}>{{ $branch->sub_district }}</option>
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
                                    <input type="text" id="zip_code" name="zip_code" class="form-control text-center" value="{{ $branch->zip_code }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Phone 1</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="phone1" name="phone1" class="form-control" value="{{ $branch->phone1 }}" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Phone 2</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="phone2" name="phone2" class="form-control" value="{{ $branch->phone2 }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Whatsapp</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="{{ $branch->whatsapp }}" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Instagram</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="instagram" name="instagram" class="form-control" value="{{ $branch->instagram }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>Facebook</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="facebook" name="facebook" class="form-control" value="{{ $branch->facebook }}" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>Twitter</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="twitter" name="twitter" class="form-control" value="{{ $branch->twitter }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <span><b>PIC</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="pic" name="pic" class="form-control" value="{{ $branch->pic }}" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <span><b>PIC Phone</b></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="pic_no" name="pic_no" class="form-control" value="{{ $branch->pic_no }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><b>Open At</b></label>
                                <input class="form-control" id="open_at" name="open_at" type="time" value="{{ $branch->open_at }}" placeholder=""/>
                            </div>
                            <div class="mb-3">
                                <label><b>Email</b></label>
                                <input class="form-control" id="email" name="email" type="email" value="{{ $branch->email }}" placeholder=""/>
                            </div>
                            <div class="mb-3">
                                <label><b>Owner</b></label>
                                <input class="form-control" id="owner" name="owner" type="text" value="{{ $branch->owner }}" placeholder=""/>
                            </div>
                            <div class="mb-3">
                                <label><b>Established</b></label>
                                <input class="form-control" id="established" name="established" value="{{ $branch->established }}" type="date" placeholder=""/>
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
<script>
    var about = document.getElementById("about");
    var vision = document.getElementById("vision");
    var mission = document.getElementById("mission");

    CKEDITOR.replace(about{
        language:'en-gb'
    });
    CKEDITOR.replace(vision{
        language:'en-gb'
    });
    CKEDITOR.replace(mission{
        language:'en-gb'
    });

</script>
@endsection
