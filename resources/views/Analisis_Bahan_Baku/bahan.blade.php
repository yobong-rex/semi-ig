
@extends('layouts.template')

@section("title", "Analisis Bahan Baku")

@section("content")
@php
if(isset($_GET['session'])){
    if($_GET['session'] == 1){
        session_start();
    }
}
@endphp

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
        .dana{
            text-align:right;
        }
    table, tbody, tr, th, td{
        border: 1px solid black;
    }
    table{
        padding:5px;
    }
</style>

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

    {{--Nama Team dan Timer--}}
        <div class="row align-items-center rounded heading">
            <div class="col-9 nama_team">
                <h1 id="namaTeam">Team {{--{{$teams[0] -> nama}}--}}</h1> 
            </div>
            <div class="col-1"><h3 id="nomorSesi">Sesi {{--{{$nomorSesi}}--}}</h3></div>
            <div class="col-1 text-center align-self-end timer rounded-2"  style="font-family:TT Norms Regular;">
                <h3>Timer</h3>
                <h4 id="timer">{{--{{$timer}}--}}</h4>
            </div>
        </div>
            
        <div class="row spacing"></div>
        {{--Card Dana--}}
        <div class="card-header rounded" style="background-color:#faf0dc;">
            <div class="row align-items-center">
                <div class="col-1 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                    <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                </svg>
                </div>
                <div class="col-2 label_dana">
                    <h1>Dana : </h1>
                </div>
                <div class="col-9 dana">
                    <h1 id="dana">{{--{{number_format($teams[0] -> dana)}}--}} TC</h1>
                </div>
            </div>
        </div>
        <div class="row spacing"></div>

        <h1>Analisis Bahan Baku</h1>
    <form action="prosesbahan" method="get">
        <table class="table" style="width:100%;">
            <tbody>
                <tr>
                    {{-- Tulisan Bahan Baku --}}
                    <th class="header_bahanbaku" scope="col" colspan="2">Bahan Baku</th>
                    
                    {{-- combobox di kanan atas yang isinya produk --}}
                    <th>
                        <select name="produk" id="produk">
                            @php
                                $arrProduct = array('Scooter', 'RC Car', 'Trampoline', 'Rubber Ball', 'Fidget Spinner', 'Playstation', 'Robot', 'Action Figure', 'Skateboard', 'Bicycle');
                                    foreach ($arrProduct as $key => $product) {
                                        if(isset($_SESSION['produk'])){
                                            if($_SESSION['produk'] === $product){
                                                echo "<option value=\"$product\" selected>$product</option>";
                                            }else{
                                                echo "<option value=\"$product\">$product</option>";
                                            }
                                        }else{
                                            echo "<option value=\"$product\">$product</option>";
                                        }                                            
                                    }
                            @endphp
                        </select>
                    </th>
                    <th scope="col">Status</th>
                </tr>
                <tr>
                    {{-- 3 combobox di bawah yang isinya resource/bahan baku --}}
                    @php
                    for ($i=0;$i<3;$i++){
                        echo "<td>
                                <select name=\"resource$i\" id=\"resource\">";
                                    $arrResource = array('Steel', 'Iron', 'Aluminium Alloy', 'ABS Plastic', 'PP Plastic', 'PC Plastic', 'SBR Rubber', 'PU Rubber', 'NBR Rubber', 'Silicone', 'Acrylic', 'Cable', 'EVA Glue', 'PVA Glue');
                                    foreach ($arrResource as $key => $resource) {
                                        if(isset($_SESSION['produk'])){
                                            if($_SESSION['resource'.$i] === $resource){
                                                echo "<option value=\"$resource\" selected>$resource</option>";
                                            }else{
                                                echo "<option value=\"$resource\">$resource</option>";
                                            }
                                        }else{
                                            echo "<option value=\"$resource\">$resource</option>";
                                        }
                                    }
                                echo "</select>
                            </td>";
                    }
                    @endphp
                    {{-- Table kosong di kanan bawah buat tempat True/False --}}
                    <td>
                        @php
                        if(isset($_GET['session'])){
                            if($_GET['session'] == 1){
                                echo $_SESSION['status'];
                                $_SESSION['status'] = "";
                            }
                        }
                        @endphp
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- Button Submit --}}
        <button class="btn btn-primary" type="submit" value="submit">Submit</button>
    </form>
</body>
@endsection