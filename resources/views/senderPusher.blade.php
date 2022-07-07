@extends('layouts.template')

@section('title', 'Demand')

@section('content')

    <body>
        <h1>Sender Pusher</h1>
        <h2>Test</h2>
        <input type="text" id="line" placeholder="test pusher">
        <button type="button" id="send">Send Pusher</button>
        <script>
            $('#send').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('coba.pusher') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'message': $('#line').val()
                    },
                    success: function(data) {
                        if (data.success) {

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
