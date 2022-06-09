
@extends('layouts.app')

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
    table, tbody, tr, th, td{
        border: 1px solid black;
    }
    table{
        padding:5px;
    }
</style>

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
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