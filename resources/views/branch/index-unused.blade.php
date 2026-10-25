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
                <h3 class="card-title">List of Branch</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3">
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
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                <li><strong>Data Process Failed !</strong></li>
                                @foreach ($errors->all() as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                      @endif
                    <!--end validasi form-->
                </div>
                <table id="tableBranch" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Grade</th>
                        <th>Name</th>
                        <th>City</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($branchs as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->grade }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->city }}</td>
                            <td>
                                <div class="btn-group mr-2 mb-2" role="group">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                              <!-- Button trigger modal -->
                                              <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal{{ $data->id }}"><i class="fas fa-plus"></i> Add User</button>
                                              <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $data->id }}"><i class="fas fa-edit"></i> Edit Branch</button>
                                        </div>
                                    </div>

                                    <!-- Modal Add User-->
                                    <div class="modal fade" id="addUserModal{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ url('/branch/user') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <input type="hidden" name="id_branch" id="id_branch" value="{{ $data->id }}">
                                                        <select name="user" id="user" class="form-control">
                                                            <option value="">- Please Select User Name -</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit-->
                                    <div class="modal fade" id="editBranchModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Branch</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ url('/branch/update') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input class="form-control" id="id_branch" name="id_branch" type="hidden" placeholder="" value="{{ $data->id }}" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <select name="grade" id="grade" class="form-control">
                                                                <option value="">- Please Select Grade -</option>
                                                                @foreach ($dropdownGrades as $grade)
                                                                    <option value="{{ $grade->name_value }}" {{ $grade->name_value == $data->grade ? 'selected' : '' }}>{{ $grade->name_value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input class="form-control" id="name_branch" name="name_branch" type="text" value="{{ $data->name }}" placeholder="Input Branch Name"/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Abouts</b></label>
                                                        <textarea class="my-editor form-control" id="my-editor" name="about" cols="30" rows="10">{{ old('about', $data->about) }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Vision</b></label>
                                                        <input class="form-control" id="vision" name="vision" type="text" value="{{ old('vision', $data->vision) }}" placeholder=""/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Mission</b></label>
                                                        <input class="form-control" id="mission" name="mission" type="text" value="{{ old('mission', $data->mission) }}" placeholder=""/>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label><b>Coordinate</b></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control" id="lat" name="lat" type="text" value="{{ old('lat', $data->lat) }}" autocomplete="off" placeholder="latitude">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control" id="long" name="long" type="text" value="{{ old('long', $data->long) }}" autocomplete="off" placeholder="longitude">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Address</b></label>
                                                        <textarea class="form-control" id="addr" name="addr" cols="30" rows="3" placeholder="">{{ old('addr', $data->addr) }}</textarea>
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
                                                                <option class="text-center" value="{{ $province['id'] }}" {{ $province['nama'] == $data->province ? 'selected' : '' }}>{{ $province['nama'] }}</option>
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
                                                                <option class="text-center" value="{{ $data->city }}" {{ $data->city ? 'selected' : '' }}>{{ $data->city }}</option>
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
                                                                <option class="text-center" value="{{ $data->district }}" {{ $data->district ? 'selected' : '' }}>{{ $data->district }}</option>
                                                            </select>
                                                        </div>
                                                        @csrf
                                                        <div class="col-md-3">
                                                            <span><b>Kelurahan</b></span>  <br/>
                                                            <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select id="subdistrict" name="subdistrict" class="form-control">
                                                                <option class="text-center" value="{{ $data->subdistrict }}" {{ $data->subdistrict ? 'selected' : '' }}>{{ $data->subdistrict }}</option>
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
                                                            <input type="text" id="zip_code" name="zip_code" class="form-control text-center" value="{{ $data->zip_code }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <span><b>Phone 1</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="phone1" name="phone1" class="form-control" value="{{ $data->phone1 }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span><b>Phone 2</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="phone2" name="phone2" class="form-control" value="{{ $data->phone2 }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <span><b>Whatsapp</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="{{ $data->whatsapp }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span><b>Instagram</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="instagram" name="instagram" class="form-control" value="{{ $data->instagram }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <span><b>Facebook</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="facebook" name="facebook" class="form-control" value="{{ $data->facebook }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span><b>Twitter</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="twitter" name="twitter" class="form-control" value="{{ $data->twitter }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <span><b>PIC</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="pic" name="pic" class="form-control" value="{{ $data->pic }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span><b>PIC Phone</b></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" id="pic_no" name="pic_no" class="form-control" value="{{ $data->pic_no }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Open At</b></label>
                                                        <input class="form-control" id="open_at" name="open_at" type="time" value="{{ $data->open_at }}" placeholder=""/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Email</b></label>
                                                        <input class="form-control" id="email" name="email" type="email" value="{{ $data->email }}" placeholder=""/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Owner</b></label>
                                                        <input class="form-control" id="owner" name="owner" type="text" value="{{ $data->owner }}" placeholder=""/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label><b>Established</b></label>
                                                        <input class="form-control" id="established" name="established" type="date" value="{{ $data->established }}" placeholder=""/>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

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
<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tableBranch").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
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
