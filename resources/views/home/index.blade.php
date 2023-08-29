@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-2">
                        <h1 class="page-header-title">
                            {{-- <div class="page-header-icon"><i data-feather="file"></i></div> --}}
                            <label id="lblGreetings"></label>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    {{-- <div class="container-xl px-4 mt-n10">
        <div class="card">
            {{-- <div class="card-header">Example Card</div> --}}
            <div class="card-body">
                
            </div>
        </div>
    </div> --}}
    <script>
        var myDate = new Date();
        var hrs = myDate.getHours();

        var greet;

        if (hrs < 12)
            greet = 'Selamat Pagi';
        else if (hrs >= 12 && hrs <= 17)
            greet = 'Selamat Siang';
        else if (hrs >= 17 && hrs <= 24)
            greet = 'Selamat Malam';

        document.getElementById('lblGreetings').innerHTML =
            '<b>' + greet + '</b> <br>Selamat Datang di Sekolah Islam Kharisma';
    </script>
</main>
@endsection