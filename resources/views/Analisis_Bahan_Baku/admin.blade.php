<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@if(session('status'))
            <div class="alert alert-success" id="status">
                {{session('status')}}
            </div>
@endif
    <form action="{{route('analisis.update')}}" method="post">
        @csrf
        @if($data[0]->analisis == false)
            <h3>Sesi analisis sedang tutup</h3>
            <button type='submit' name='status' value='1'>Buka</button>
        @else
            <h3>Sesi analisis sedang dibuka</h3>
            <button type='submit' name='status' value='0'>Tutup</button>
        @endif
    </form>
</body>
</html>