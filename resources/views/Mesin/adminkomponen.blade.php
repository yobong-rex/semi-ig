@extends('layouts.template')

@section('title', 'Admin Komponen')

@section('content')


<table class="table" style="width:fit-content;">
    {{-- Heading --}}
    <thead class="thead">
        <th style="vertical-align:middle;"><h4>Tim</h4></th>
        <th style="vertical-align:middle;">
            <select name="namaTim" style="width:150px;">
                <option value="nama">--Select--</option>
            </select>
        </th>
        <th><h4>Mesin :</h4></th>
        <th style="vertical-align:middle;">
            <select name="mesin">
            <option value="sorting">Sorting</option>
            <option value="cutting">Cutting</option>
            <option value="bending">Bending</option>
            <option value="assembling">Assembling</option>
            <option value="packing">Packing</option>
            <option value="drilling">Drilling</option>
            <option value="molding">Molding</option>
        </select>
        </th>
    </thead>
    <tbody>
        <tr style="background-color:#faf0dc;">
            <td>Level Mesin : </td>
            <td class="noLevel" id="levelMesin_">1</td>
        </tr>
        <tr>
            <td class="namaKomponen">Komponen A : </td>
            <td class="noLevel" id="komponenA_mesin">1</td>
            <td><button type="button" class="btn btn-warning" id="upgradeA_mesin">Upgrade A</button></td>
        </tr>
        <tr>
            <td class="namaKomponen">Komponen B : </td>
            <td class="noLevel" id="komponenB_mesin">1</td>
            <td><button type="button" class="btn btn-warning" id="upgradeB_mesin">Upgrade B</button></td>
        </tr>
        <tr>
            <td class="namaKomponen">Komponen C : </td>
            <td class="noLevel" id="komponenB_mesin">1</td>
            <td><button type="button" class="btn btn-warning" id="upgradeC_mesin">Upgrade C</button></td>
        </tr>
        <tr>
            <td class="namaKomponen">Komponen D : </td>
            <td class="noLevel" id="komponenB_mesin">1</td>
            <td><button type="button" class="btn btn-warning" id="upgradeD_mesin">Upgrade D</button></td>
        </tr>
    </tbody>
</table>

@endsection