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
                <h3 class="card-title">List of Institution</h3>
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
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-add-label">Add Institution</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/institution/store') }}" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="inst_name" name="inst_name" placeholder="Input Institution Name" required>
                                                </div>
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
                <table id="tableInstitution" class="table table-striped table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Institution Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($institutions as $data)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $data->name }}</td>
                        <td>
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
                            <div class="btn-group mr-2" role="group">
                                @if ($data->id_profile > 0)
                                    <a href="{{ url('/institution/profile-edit/'.encrypt($data->id_profile)) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit Profile</a>
                                @else
                                    <a href="{{ url('/institution/profile/'.encrypt($data->id)) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Add Profile</a>
                                @endif
                            </div>
                            <div class="btn-group mr-2" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-code-branch"></i>Branches</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Button trigger modal -->
                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#addBranchModal{{ $data->id }}"><i class="fas fa-plus"></i> Add Branch</button>
                                        <a class="dropdown-item" href="#!"><i class="fas fa-list"></i> List Branch</a>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="addBranchModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/branch/store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <input class="form-control" id="id_inst" name="id_inst" type="hidden" placeholder="" value="{{ $data->id }}" />
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
                                                    <div class="form-group">
                                                        <select class="form-control" name="province_by_id" id="province_by_id">
                                                            <option value="" selected>- Choose Province -</option>
                                                            @foreach ($provinces as $province)
                                                            <option value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
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
      var table = $("#tableInstitution").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>
@endsection