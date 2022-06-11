<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Memenuhi Demand</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($produk as $p)
            <tr>
                <td>{{$p->nama}}</td>
                <td><input type="number" class='demand' id='input_{{$p->idproduk}}'></td>
                <td id='total_{{$p->idproduk}}'>
                    @if(count($data) == 0)
                        0
                    @else
                        @foreach($data as $d)
                            @if($p->idproduk == $d->idproduk)
                                {{$d->jumlah}}
                            @else
                                0
                            @endif
                        @endforeach
                    @endif
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <button id='konfrim'>Konfirmasi</button>

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
                    alert('berhasil melakukan demand');
                }
            });
        });
    </script>
</body>
</html>