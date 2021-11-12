
@include('header')

<section class="login-wrapper">
    <div class="login-middle">
        <div class="text-center">
        <div class="container">
    @if(session()->get('fail'))
    <div class="alert alert-danger" role="alert">
    {{ session()->get('fail') }}
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    @endif
        <img src="{{asset('/images/login-logo.svg')}}" width="260px" />
</div>
        <form action="login_search" method="post">
        @csrf
            <div class="form-wrapper">
                <h4 class="text-uppercase">Login</h4>
                <div class="">
                    <input type="email" name="email" class="form-control"  placeholder="Email" required>
                    <span style="color:red">@error('email'){{$message}}@enderror</span>
                </div>
                <div class="">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span style="color:red">@error('password'){{$message}}@enderror</span>
                </div>
                
                <div class="text-center">
                    <input type="submit" class="btn primary-btn" value="Login">
                </div>
                
                <p class="text-center forgot-pass">
                    <u><a href="">Forgot Password?</a></u>
                </p>
            </div>
        </form>
    </div>

</section>

@include('footer')