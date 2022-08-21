
@extends('layouts.app')
@section('content')
<!--Script-->
<script src="{{ asset('js/login.js') }}" defer></script>
<!--Style-->
<link href="{{ asset('css/login.css') }}" rel="stylesheet">

<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        
        <div class="container login">
            <div class="row justify-content-center form-bg-image">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-4 h3" style="font-family: 'TT Norms Bold'; color:lightblue;">Industrial Games XXX <br> Login Form</h1>
                                
                            <form method="POST" action="{{ route('login') }}" class="mt-4">
                                @csrf
                                <!-- Form -->         
                                <div class="form-control">
                                    <input type="text" name="name" id="name" required />
                                    <label>Username</label>
                                </div>                 
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="form-control">
                                    <input type="password" name="password" id="password" required />
                                    <label>Password</label>
                                </div>
                                <!-- End of Form -->

                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-gray-800" >Login</button>
                                </div>
                                @foreach($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>
@endsection