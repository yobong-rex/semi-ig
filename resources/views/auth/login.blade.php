
@extends('layouts.app')

@section('content')

<style>
    @font-face {
        font-family: 'TT Norms Bold';
        font-style: normal;
        font-weight: normal;
        src: local('TT Norms Bold'), url('assets/font/TTNorms-Bold.woff') format('woff');
    }
    *{
        box-sizing: border-box;
    }
    .container login{
        padding: 20px 40px;
        border-radius: 5px;
        font-family: 'TT Norms Bold';
    }
    .container h1{
        text-align: center;
        margin-bottom:30px; 
    }
    .container a{
        text-decoration: none;
        color:lightblue;
    }
    .btn{
        cursor: pointer;
        display: inline-block;
        width: 100%;
        border: 0;
        border-radius: 5px;
        background: lightblue;
        font-size: 20px;
        font-family: 'TT Norms Bold';
        color: #ffffff;
    }

    .btn:focus{
        outline: 0;
    }

    .btn:active{
        transform: scale(0.98);
    }
    .form-control{
        position: relative;
        margin:20px 0 40px;
        width:300px;
    }

    .form-control input{ 
        background-color: transparent;
        border:0;
        border-bottom: 2px lightblue solid;
        display: block;
        width:100%;
        padding: 15px 0;
        font-size: 18px;

    }

    .form-control input:focus,
    .form-control input:valid{
        outline: 0;
        border-bottom-color: lightblue;
    }

    .form-control label{
        position: absolute;
        top: 15px;
        left: 0;
        pointer-events: none;
    }
    .form-control label span{
        display: inline-block;
        font-size: 18px;
        min-width: 5px;;
        transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .form-control input:focus + label span,
    .form-control input:valid + label span{
        color:lightblue;
        transform: translateY(-30px);
    }

</style>

<main class="body">
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        
        <div class="container login">
            <div class="row justify-content-center form-bg-image">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-4 h3" style="font-family: 'TT Norms Bold'; color:lightblue;">Industrial Games XXX <br> Login Form</h1>
                                
                            <form method="POST" action="{{ route('login') }}" class="">
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

        

        <script>
            const labels = document.querySelectorAll(".form-control label");
            labels.forEach((label)=>{
                label.innerHTML=label.innerText
                    .split("")
                    .map(
                        (letter,idx) =>
                        `<span style="transition-delay:${idx*50}ms">${letter}</span>`
                    )
                    .join("");
            });
        </script>
    </section>
    
</main>
@endsection