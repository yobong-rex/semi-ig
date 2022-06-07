@extends('layouts.app')

@section("title", "Upgrade Kapasitas")

@section("content")
<style>
    table, tr, th, td{
        border: 1px solid black;
    }
</style>
<body>
    <div class="container e-50">
        <table>
            <thead>
                <tr>
                    {{-- <th scope="col">#</th>
                    <th scope="col">nama mesin</th>
                    <th scope="col">defect</th>
                    <th scope="col">cycle</th> --}}
                    <th scope="col">mesin_idmesin</th>
                    <th scope="col">level</th>
                    <th scope="col">kapasitas</th>
                    <th scope="col">harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kapasitas as $k)
                <tr>
                    {{-- <th scope="row">{{$k -> idmesin}}</th>
                    <td>{{$k -> nama}}</td>
                    <td>{{$k -> defect}}</td>
                    <td>{{$k -> cycle}}</td> --}}
                    <td>{{$k -> mesin_idmesin}}</td>
                    <td>{{$k -> level}}</td>
                    <td>{{$k -> kapasitas}}</td>
                    <td>{{$k -> harga}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection