<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

    {{-- CDN Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    {{-- CSS Internal --}}
    <style>
        @font-face {
            font-family: 'TT Norms Light';
            font-style: normal;
            font-weight: bold;
            src: local('TT Norms Light'), url('assets/font/TTNorms-Light.otf');
        }

        @font-face {
            font-family: 'TT Norms Medium';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Medium'), url('assets/font/TTNorms-Medium.woff') format('woff');
        }

        @font-face {
            font-family: 'TT Norms Bold';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Bold'), url('assets/font/TTNorms-Bold.woff') format('woff');
        }
        @font-face {
            font-family: 'TT Norms Regular';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Regular'), url('assets/font/TTNorms-Regular.woff') format('woff');
        }
        
        .nav-link,
        .nav-link:focus {
            font-family: 'TT Norms Bold';
            color: #ea435e;
            border-radius: 5px;
        }

        .nav-link:hover {
            color: #ffff;
            background-color: #ea435e;
            border-radius: 5px;
        }
        .spacing{
        margin:15px;
        padding:10px;
        }
        .logOut{
            background-color:#6868ac;
            border-radius: 5px;
        }
        
        
    </style>

    {{-- CSS Tambahan Internal --}}
    @yield('css')

    {{-- CDN JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-lg" style="background-color: #ffff; box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.3);">
        <div class="container-fluid gap-5">
    

            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content:center;">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets') }}/logo/Logo_IG_Header.png" alt="Logo IGXXX" style="max-height: 40px">
            </a>
                <ul class="navbar-nav mb-2 mb-lg-0 gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @can('isMarketing')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('komponen') }}">Mesin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('demand') }}">Demand</a>
                        </li>
                    @elsecan('isResearcher')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('bahan') }}">Analisis Bahan</a>
                        </li>
                    @elsecan('isProduction_Manager')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('kapasitas') }}">Kapasitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('produksi') }}">Produksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('analisis') }}">Analisis Produksi</a>
                        </li>
                    @endcan
                    <li class="nav-item logOut">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-light nav-link active" aria-current="page" style="text-decoration:none;"> {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Body --}}
    <div class="container-fluid p-0">
        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
             {{-- Nama Team dan Timer --}}
             <div class="row align-items-center rounded heading">
                <div class="col-md-9 nama_team">
                    <h1 id="namaTeam">Team {{ $user[0]->nama }}</h1>
                </div>
                <div class="col-md-1">
                    <h3 id="nomorSesi">Sesi <span id="sesi">{{$sesi[0]->sesi}}</span></h3>
                </div>
                <div class="col-md-1 text-center align-self-end timer rounded-2" style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">- - : - -</h4>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- modal info analisis-->
        <div class="modal fade" id="modalInfoAnalisis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                    </div>
                    <div class="modal-body flex" id='info-body-analisis'>
                        Sesi analisis telah <span id='analisis-status'></span>
                    </div>
                    <div class="modal-footer" id='footer-analisis'>
                        
                    </div>
                </div>
            </div>
        </div>
    <!-- end modal info analisis-->
    
    @yield('ajaxquery')
    
    {{-- CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        window.Echo.channel('analisisChannel').listen('.analisis', (e) => { 
            console.log(e.analisis.sesi);
           if(e.analisis.sesi == "2"){
                console.log('a')
                $('footer-analisis').html(`<a href="{{ route('analisis') }}" class="btn btn-secondary mdl-close"
                                    data-bs-dismiss="modal">OK!</a>`);
           }
           else{
                $('footer-analisis').html('<button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">Close</button>');
           }

           if(e.analisis.status == true){
                $('#analisis-status').text('dibuka');
           }
           else{
                $('#analisis-status').text('ditutup');
           }

           $('#modalInfoAnalisis').modal('show');
        });
    </script>
</body>
</html>