
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
</style>
<body>
    <form action="prosesbahan" method="get">
        <table>
            <tbody>
                <tr>
                    <th scope="col" colspan="3">Bahan Baku</th>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
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
            <input type="submit" type="submit" value="submit">
    </form>
</body>
@endsection