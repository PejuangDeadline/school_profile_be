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
                            Facility Menu
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
                <h3 class="card-title">List of Facility</h3>
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
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-add-label">Add Facility</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/facility/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><b>Facility Name</b></label>
                                            <input class="form-control" id="facility_name" name="facility_name" type="text" placeholder=""/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Description</b></label>
                                            <textarea class="my-editor form-control" id="my-editor" name="description" cols="30" rows="10""></textarea>
                                        </div>
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
                    <table id="tableFacility" class="table table-striped table-hover dt-responsive display nowrap">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Branch Name</th>
                          <th>Facility Name</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php
                            $no=1;
                          @endphp
                          @foreach ($facilities as $data)
                          <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->name." ".$data->city." - ".$data->grade}}</td>
                                <td>{{ $data->facility_name }}</td>
                                <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#seeDescModal{{ $data->id }}">
                                    <i class="fas fa-eye"></i> See Description
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="seeDescModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Preview Description</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $data->description !!}
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-edit{{ $data->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>

                                    <!-- Modal Edit-->
                                    <div class="modal fade" id="modal-edit{{ $data->id }}" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modal-add-label">Edit Facility</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ url('/facility/update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <input class="form-control" id="id_facility" name="id_facility" type="hidden" value="{{ $data->id }}"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label><b>Facility Name</b></label>
                                                            <input class="form-control" id="facility_name" name="facility_name" type="text" value="{{ $data->facility_name }}"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label><b>Description</b></label>
                                                            <textarea class="my-editor-edit form-control" id="my-editor-edit" name="description" cols="30" rows="10">{{ $data->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Delete-->
                                    <div class="modal fade" id="modal-delete{{ $data->id }}" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modal-add-label">Delete Facility</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ url('/facility/delete') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <input class="form-control" id="id_facility" name="id_facility" type="hidden" value="{{ $data->id }}"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label><b>Are you sure delete this facility</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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
    CKEDITOR.replace('my-editor');
    CKEDITOR.replaceAll('my-editor-edit');
</script>
<script>
    $(document).ready(function() {
      var table = $("#tableFacility").DataTable({
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
