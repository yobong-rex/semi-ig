@extends('layouts.template')

@section('title', 'Demand')

@section('content')

    <body>
        <h1>Test Pusher 1</h1>
        <form action="" method="post">
            <input type="text" name="line" id="line" placeholder="test pusher">
            <button id="send" type="button">Send Pusher</button>
        </form>
        <script>
            $('#send').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('coba.pusher') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'test': $('#line').val()
                    },
                    success: function(data) {
                        if (data.status) {
                            alert('success');
                        }
                    },
                    error: function() {
                        alert('error');
                    }
                })
            })
        </script>
    </body>
@endsection
