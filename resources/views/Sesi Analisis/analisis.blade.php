@extends('layouts.app')

@section("title", "Sesi Analisis")

@section("content")
<<<<<<< Updated upstream
<style>
.nomor{
    width:50px;
    text-align:center;
}
.penomoran{
    width:110px;
    text-align: center;
}
</style>

{{-- DOKUMENTASI ID --}}
{{-- 
    proses_{nomor proses produksi}_{urutan ke}
    button_{nomor proses produksi}
    --}}

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

        <h1>Sesi Analisis</h1>

        {{--tabel analisis--}}
        <table class="table table-bordered" style="vertical-align: middle;">
            <thead class="thead">
                <tr>
                    <th scope="col"> </th>
                    <th scope="col" colspan="9" style="text-align:center;">Urutan Produksi Produk</th>
                    <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;">Konfirmasi</th>
                </tr>
                <tr>
                    <th class="nomor" scope="col">Nomor</th>
                    @for ($i=1;$i<=9;$i++)
                    <th class="penomoran" scope="col">{{$i}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                {{-- id proses_(prosesId) --}}
                @for($i=1;$i<=3;$i++)
                <tr id="tr_{{$i}}">
                    <th class="nomor" scope="row">Proses Produksi {{$i}}</th>
                    @for($j=1;$j<=9;$j++)
                    <td>
                        <select name="proses" id="proses_{{$i}}_{{$j}}">
                            <option value="">-Select-</option>
                            <option value="sorting">Sorting</option>
                            <option value="cutting">Cutting</option>
                            <option value="bending">Bending</option>
                            <option value="assembling">Assembling</option>
                            <option value="packing">Packing</option>
                            <option value="drilling">Drilling</option>
                            <option value="molding">Molding</option>
                        </select>
                    </td>
                    @endfor
                    <td><button class="btn btn-success" id="button_{{$i}}">Konfirmasi</button></td>
                </tr>
                @endfor
            </tbody>
        </table>
        </div>
    </div>
=======
@php
    $notEff1 = array('Sorting', 'Cutting', 'Drilling', 'Assembling', 'Cutting', 'Assembling', 'Sorting', 'Wrapping', 'Packing');
    $notEff2 = array('Sorting', 'Cutting', 'Assembling', 'Drilling', 'Assembling', 'Wrapping', 'Packing');
    $notEff3 = array('Sorting', 'Molding', 'Assembling', 'Sorting', 'Wrapping', 'Packing');
    $eff1 = array('Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing');
    $eff2 = array('Sorting', 'Cutting', 'Drilling', 'Assembling', 'Packing');
    $eff3 = array('Sorting', 'Molding', 'Assembling', 'Packing');
@endphp
<body>
    
>>>>>>> Stashed changes
</body>
@endsection