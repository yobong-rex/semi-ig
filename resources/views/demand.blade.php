@extends('layouts.template')

@section("title", "Demand")

@section('content')

<style>
    .heading{
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        padding:5px;
    }
    .nama_team{
        color:#ea435e;
    }
    .timer{
        background-color:#77dd77; /* misal waktu habis background jadi #ea435e */
        width:150px;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
    }
    .nomor_demand{
        width:50px;
        text-align:center;
    }
    .pemenuhan{
        background-color:#ffffff;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
    }
</style>

@php
$sesi=1;
// $dana={{$teams->dana}};
// $namaTeam={{$teams->nama}};
$nomorSesi=1;   

$timer="00:00";
@endphp

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

        {{--Nama Team dan Timer--}}
        <div class="row align-items-center rounded heading">
            <div class="col-9 nama_team">
                <h1 id="namaTeam">Team {{--{{$teams[0] -> nama}}--}}</h1> 
            </div>
            <div class="col-1"><h3 id="nomorSesi">Sesi {{$nomorSesi}}</h3></div>
            <div class="col-1 text-center align-self-end timer rounded-2"  style="font-family:TT Norms Regular;">
                <h3>Timer</h3>
                <h4 id="timer">{{$timer}}</h4>   
            </div>
        </div>

        <div class="row spacing"></div>

        <div class="card-body pemenuhan rounded">
            <h1>Pemenuhan Demand</h1>

            {{-- Table Pemenuhan Demand --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="nomor_demand" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col" style="text-align:center;">Memenuhi Demand</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i=1
                @endphp
                @foreach ($produk as $p)
                    <tr>
                        <td class="nomor_demand" scope="row">{{$i++}}</td>
                        <td>{{$p->nama}}</td>
                        <td class="inputDemand"><input type="number" class='demand' id='input_{{$p->idproduk}}'min="0" oninput="this.value = 
                            !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                        <td id='total_{{$p->idproduk}}'>
                            @if(count($data) == 0)
                                0
                            @else
                                <?php $triger = 0; ?>
                                @foreach($data as $d)
                                    @if($p->idproduk == $d->idproduk)
                                        {{$d->jumlah}}
                                        <?php $triger += 1 ?>
                                    @endif
                                @endforeach
                                @if($triger == 0)
                                    {{$triger}}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-success" id="konfrim">Konfirmasi</button>
            {{-- <table class="table table-bordered" style="vertical-align: middle;">
                @php
                    $arrproduk = array('Scooter', 'Hoverboard', 'Skateboard', 'Bicycle', 'Claw Machine', 'RC Car', 'RC Helicopter', 'Trampoline', 'Robot', 'Airsoft Gun', 'Rubber Ball', 'Fidget Spinner', 'Bowling Set', 'Action Figure');
                    $col=1;
                @endphp
                <thead class="thead">
                    <tr>
                        <th class="nomor_demand" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col" colspan={{$col}} style="text-align:center;">Memenuhi Demand</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1; $i<=count($arrproduk);$i++)
                    <tr>
                        <th class="nomor_demand" scope="row">{{$i}}</th>
                        <td>{{$arrproduk[$i-1]}}</td>
                        <td id="demand-{{$i}}"><input class="inputDemand" type="number" name='jumlah' id='jumlahDemand' min="0" oninput="this.value = 
                            !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                        <td id="total-{{$i}}">0</td>
                    </tr>
                    @endfor
                    <tr>
                        <th class="nomor_demand" scope="row">1</th>
                        <td>Scooter</td>
                        <td id="demand-1_1">0</td>
                        <td id="demand-1_2">0</td>
                        <td id="demand-1_3">0</td>
                        <td id="total-1">0</td>

                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">2</th>
                        <td>Hoverboard</td>
                        <td id="demand-2_1">0</td>
                        <td id="demand-2_2">0</td>
                        <td id="demand-2_3">0</td>
                        <td id="total-2">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">3</th>
                        <td>Skateboard</td>
                        <td id="demand-3_1">0</td>
                        <td id="demand-3_2">0</td>
                        <td id="demand-3_3">0</td>
                        <td id="total-3">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">4</th>
                        <td>Bicycle</td>
                        <td id="demand-4_1">0</td>
                        <td id="demand-4_2">0</td>
                        <td id="demand-4_3">0</td>
                        <td id="total-4">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">5</th>
                        <td>Claw Machine</td>
                        <td id="demand-5_1">0</td>
                        <td id="demand-5_2">0</td>
                        <td id="demand-5_3">0</td>
                        <td id="total-5">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">6</th>
                        <td>RC Car</td>
                        <td id="demand-6_1">0</td>
                        <td id="demand-6_2">0</td>
                        <td id="demand-6_3">0</td>
                        <td id="total-6">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">7</th>
                        <td>RC Helicopter</td>
                        <td id="demand-7_1">0</td>
                        <td id="demand-7_2">0</td>
                        <td id="demand-7_3">0</td>
                        <td id="total-7">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">8</th>
                        <td>Trampoline</td>
                        <td id="demand-8_1">0</td>
                        <td id="demand-8_2">0</td>
                        <td id="demand-8_3">0</td>
                        <td id="total-8">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">9</th>
                        <td>Robot</td>
                        <td id="demand-9_1">0</td>
                        <td id="demand-9_2">0</td>
                        <td id="demand-9_3">0</td>
                        <td id="total-9">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">10</th>
                        <td>Airsoft Gun</td>
                        <td id="demand-10_1">0</td>
                        <td id="demand-10_2">0</td>
                        <td id="demand-10_3">0</td>
                        <td id="total-10">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">11</th>
                        <td>Rubber Ball</td>
                        <td id="demand-11_1">0</td>
                        <td id="demand-11_2">0</td>
                        <td id="demand-11_3">0</td>
                        <td id="total-11">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">12</th>
                        <td>Fidget Spinner</td>
                        <td id="demand-12_1">0</td>
                        <td id="demand-12_2">0</td>
                        <td id="demand-12_3">0</td>
                        <td id="total-12">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">13</th>
                        <td>Bowling set</td>
                        <td id="demand-13_1">0</td>
                        <td id="demand-13_2">0</td>
                        <td id="demand-13_3">0</td>
                        <td id="total-13">0</td>
                    </tr>
                    <tr>
                        <th class="nomor_demand" scope="row">14</th>
                        <td>Action Figure</td>
                        <td id="demand-14_1">0</td>
                        <td id="demand-14_2">0</td>
                        <td id="demand-14_3">0</td>
                        <td id="total-14">0</td>
                    </tr>
                </tbody>
             </table>--}}
            
            

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                let arrDemand = [];
                $(document).on('change','.demand',function(){
                    let val = parseInt($(this).val());
                    let id = $(this).attr('id');
                    let id_split = id.split('_');
                    let total = parseInt( $('#total_'+id_split[1]).text());
                    total += val;
                    $('#total_'+id_split[1]).text(total);
                    $(this).attr("disabled", true);
                    arrDemand.push({'produk': id_split[1], 'total': total});
                });

                $(document).on('click','#konfrim',function(){
                    $.ajax({
                        type: "POST",
                        url: "{{route('demand.konfrim')}}",
                        data:{
                            '_token': '<?php echo csrf_token()?>',
                            'demand' : arrDemand,
                            'team': 1,
                            'sesi': 1,
                        },
                        success: function(data){
                            alert(data.msg);
                            location.reload();
                        }
                    });
                });
            </script>
        </div>
    </div>
</body>
@endsection