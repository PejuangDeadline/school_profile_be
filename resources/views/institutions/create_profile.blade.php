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
@endsection