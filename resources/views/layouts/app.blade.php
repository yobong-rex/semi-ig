<!DOCTYPE html>
<html lang="en">

<head>
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
        
        
    </style>

    {{-- CSS Tambahan Internal --}}
    @yield('css')

    {{-- CDN JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-lg" style="background-color: #ffff; box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.3);">
        <div class="container fluid gap-5">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets') }}/logo/Logo_IG_Header.png" alt="Logo IGXXX" style="max-height: 40px">
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-5">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('market') }}">Market</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('komponenMesin') }}">Mesin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('analisis') }}">Analisis</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Body --}}
    <div class="container-fluid p-0">
        @yield('content')
    </div>
    
    @yield('ajaxquery')
    
    {{-- CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>
</html>