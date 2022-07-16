<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- @if(session('status'))
            <div class="alert alert-success" id="status">
                {{session('status')}}
            </div>
@endif -->
        @if($data[0]->analisis == false)
            <h3>Sesi analisis sedang tutup</h3>
            <button type='button' id='update' name='status' value='1'>Buka</button>
        @else
            <h3>Sesi analisis sedang dibuka</h3>
            <button type='button' id='update' name='status' value='0'>Tutup</button>
        @endif

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).on('click','#update',function(){
                let status = $(this).val();

                $.ajax({
                type: "POST",
                url: "{{ route('analisis.update') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'status': status
                },
                success: function(data) {
                   location.reload();
                },
                error: function() {
                    // alert('error');
                }
            });
            })
        </script>
</body>
</html>