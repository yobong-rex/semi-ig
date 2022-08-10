<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard IG XXX</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

    {{-- CDN Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <style>
        @font-face {
            font-family: 'TT Norms Bold';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Bold'), url('assets/font/TTNorms-Bold.woff') format('woff');
        }

        @font-face {
            font-family: 'TT Norms Light';
            font-style: normal;
            font-weight: bold;
            src: local('TT Norms Light'), url('assets/font/TTNorms-Light.otf');
        }
        .leaderboard_title{
            font-family: "TT Norms Bold";
            background-color: #ea435e;
            color: white;
            vertical-align: middle;
        }
        .spacing {
            margin: 10px;
            padding: 5px;
        }
        .timer {
            background-color: #77dd77;
            /* misal waktu habis background jadi #ea435e */
            width: 150px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
            position: fixed;
            top:4%;
        }
    </style>
</head>
<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container-fluid p-0">
        <div class="container px-4 py-5" style="font-family: TT Norms Light;">
            <div class="row justify-content-end">
                <div class="col-md-2 flex text-center align-self-center timer rounded-2"
                        style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">- - : - -</h4>
                </div>
            </div>

            <div class="row text-center rounded leaderboard_title">
                <h1>LEADERBOARD</h1>
            </div>

            <div class="row spacing"></div>

            <div class="row leaderboard_body">

                <div class="col">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr style="font-family:TT Norms Bold;">
                                <th style="text-align:center;width:75px;">Ranking</th>
                                <th>Nama Team</th>
                                <th>Customer Value</th>
                            </tr>
                        </thead>
                        <tbody id ='awal'>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr style="font-family:TT Norms Bold;">
                                <th scope="col" style="text-align:center;width:75px;">Ranking</th>
                                <th>Nama Team</th>
                                <th>Customer Value</th>
                            </tr>
                        </thead>
                        <tbody id = 'akhir'>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <script src="../../js/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function getLeaderboard(){
            $.ajax({
                type: "POST",
                url: "{{ route('leaderboard') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    $('#awal').empty()
                    $('#akhir').empty()
                    let nomer = 1;
                    $.each(data.data1, function(key, value) {
                    if(nomer<=13){
                            $('#awal').append(`
                                <tr>
                                    <td style="text-align:center;font-family:TT Norms Bold;">`+nomer+`</td>
                                    <td style="vertical-align:middle;">`+value.nama+`</td>
                                    <td style="vertical-align:middle;">`+value.customer_value+`</td>
                                </tr>
                            `);
                        }
                        else{
                            $('#akhir').append(`
                                <tr>
                                    <td style="text-align:center;font-family:TT Norms Bold;">`+nomer+`</td>
                                    <td style="vertical-align:middle;">`+value.nama+`</td>
                                    <td style="vertical-align:middle;">`+value.customer_value+`</td>
                                </tr>
                            `);
                        }
                        nomer += 1;
                    });
                }
            });
        }
        $( document ).ready(function(){
            getLeaderboard();
        });

        window.Echo.channel('leaderboardChannel').listen('.updateLeaderboard', (e) => {
           if(e.msg == 'berhasil'){
                getLeaderboard();
           }
        })
    </script>
</body>
</html>
