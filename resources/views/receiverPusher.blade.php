@extends('layouts.template')

@section('title', 'Demand')

@section('content')

    <body>
        <h1>Receiver Pusher</h1>
        <h2>Test</h2>

        {{-- Modal --}}
        <div class="modal fade" id="Notif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="NotifLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NotifLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        <h4><span id='notif'></span></h4>
                    </div>
                    <div class="modal-footer">
                        {{-- button ok --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        window.Echo.channel('testPusher').listen('.public', (e) => {
            $('#notif').text(e.field);
            $('#Notif').modal('show');
        })
    </script>
@endsection
