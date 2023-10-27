@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl">
            <div class="page-header-content">
                <div class="row text-center">
                    <div class="col-12">
                        <h1 class="text-white">
                            <label id="lblGreetings"></label>
                            &nbsp; {{ $branch_name }}
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
            greet = 'Selamat Pagi, ';
        else if (hrs >= 12 && hrs <= 17)
            greet = 'Selamat Siang, ';
        else if (hrs >= 17 && hrs <= 24)
            greet = 'Selamat Malam, ';

        document.getElementById('lblGreetings').innerHTML =
            '<b>' + greet + '</b>';
    </script>
</main>
@endsection