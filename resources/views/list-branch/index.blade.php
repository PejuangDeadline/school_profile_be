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
                            {{$institution->name}} Branch
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
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i>
                        </button>

                          <!-- Modal -->
                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/branch/store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <input class="form-control" id="id_inst" name="id_inst" type="hidden" placeholder="" value="{{ $institution->id_institution }}" />
                                            <input class="form-control" id="id_branch" name="id_branch" type="hidden" placeholder="" value="{{ $id_branch }}" />
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <select name="grade" id="grade" class="form-control">
                                                    <option value="">- Please Select Grade -</option>
                                                    @foreach ($dropdownGrades as $grade)
                                                        <option value="{{ $grade->name_value }}">{{ $grade->name_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control" id="name_branch" name="name_branch" type="text" placeholder="Input Branch Name"/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Abouts</b></label>
                                            <textarea id="editabout" class="form-control" name="about" rows="10" cols="50"></textarea>
                                            <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
                                            <script>
                                                CKEDITOR.replace('editabout', {
                                                    language:'en-gb'
                                                });
                                            </script>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Vision</b></label>
                                            <input class="form-control" id="vision" name="vision" type="text" placeholder="" value=""/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Mission</b></label>
                                            <textarea id="editmission" class="form-control" name="mission" rows="10" cols="50"></textarea>
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
                                                <input class="form-control" id="lat" name="lat" type="text" value="{{ old('lat') }}" autocomplete="off" placeholder="latitude">
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" id="long" name="long" type="text" value="{{ old('long') }}" autocomplete="off" placeholder="longitude">
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
                                            <label><b>Open At</b></label>
                                            <input class="form-control" id="open_at" name="open_at" type="time" placeholder=""/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Email</b></label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder=""/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Owner</b></label>
                                            <input class="form-control" id="owner" name="owner" type="text" placeholder=""/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Established</b></label>
                                            <input class="form-control" id="established" name="established" type="date" placeholder=""/>
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
                <div class="table-responsive">
                    <table id="tableInstitution" class="table table-striped">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Branch Name</th>
                          <th>Address</th>
                          <th>Owner</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php
                            $no=1;
                          @endphp
                          @foreach ($branch as $data)
                          <tr>
                              <td>{{ $no++ }}</td>
                              <td>
                                    {{ $data->name }}
                                    <br>
                                    <b>Established: </b>{{ $data->established }}
                                    <br>
                                    @if ($data->is_active == '1')
                                      <div class="text-success">
                                          <b><i>Active</i></b>
                                      </div>
                                    @else
                                        <div class="text-danger">
                                            <b><i>Inactive</i></b>
                                        </div>
                                    @endif
                              </td>
                              <td>
                                <strong>{{ $data->province }},</strong>
                                <i>{{$data->city}},{{$data->district}},{{$data->sub_district}}</i>
                                <p>{{$data->addr}}</p>

                              </td>
                              <td>{{ $data->owner }}</td>
                              <td>
                                  <div class="btn-group mr-2 mb-2" role="group">
                                    {{-- <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $data->id }}"><i class="fas fa-edit"></i> Edit Branch</button> --}}
                                    <a href="{{ url('/branch/edit/'.encrypt($data->id)) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                  </div>
                                  <div class="btn-group mr-2 mb-2" role="group">
                                    <button title="Delete Rule" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                        <i class="fas fa-trash-alt"></i>Delete
                                      </button>
                                  </div>
                                  <div class="btn-group mr-2 mb-2" role="group">
                                    <button title="Upload Logo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-upload{{ $data->id }}">
                                        <i class="fas fa-upload"></i>Upload Logo
                                      </button>
                                  </div>
                              </td>
                                {{-- Modal Upload --}}
                                <div class="modal fade" id="modal-upload{{ $data->id }}" tabindex="-1" aria-labelledby="modal-upload{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modal-upload{{ $data->id }}-label">Upload Logo</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('/branch/upload-logo/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input class="form-control" id="logo" name="logo" type="file"/>
                                            </div>
                                            <div class="mb-3">
                                                <img src="{{ asset($data->logo) }}" class="img-fluid" alt="...">
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
                                {{-- Modal Upload --}}

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="modal-delete{{ $data->id }}" tabindex="-1" aria-labelledby="modal-delete{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modal-delete{{ $data->id }}-label">Delete Rule</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('/branch/delete/'.$data->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-body">
                                            <div class="form-group">
                                            Are you sure you want to delete <label for="rule">{{ $data->name }}</label>?
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
                                {{-- Modal Delete --}}
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
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
<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tableInstitution").DataTable({
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
