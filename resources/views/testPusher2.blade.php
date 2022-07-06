@extends('layouts.template')

@section("title", "Demand")

@section('content')

<body>
    <h1>Test Pusher 2</h1>
    <script>
        window.Echo.channel('testPusher').listen('.public', (e) => {
            alert(e.test);
        })
    </script>
</body>
@endsection