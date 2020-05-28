@extends('layouts.frontend.home')



@section('content')
<!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                    @if ($message = Session::get('success'))
                           <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                 <strong>{{ $message }}</strong>
                           </div>
                        @elseif($message = Session::get('error'))
                           <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                           </div>
                        @endif
                    <form method="post" action="{{route('login')}}">
                        @csrf
                        <h4 class="mtext-105 cl2 txt-center p-b-30">
                            Login
                        </h4>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email" placeholder="Your Email Address">
                            
                        </div>

                        <div class="bor8 m-b-30">
                             <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" name="password" placeholder="Your Password">
                        </div>
                        
                            
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                           
                        

                        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                           Login
                        </button>
                    </form>
                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                     <form method="post" action="{{route('register')}}" id="basic-form">
                        @csrf
                        <h4 class="mtext-105 cl2 txt-center p-b-30" style="color:red">
                           New Member?  Register Here
                        </h4>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="name" placeholder="Your Full Name">
                            
                            
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email" placeholder="Your Email Address">   
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="phone" placeholder="Your Phone Number">   
                        </div>

                        <div class="bor8 m-b-30">
                             <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" name="password" placeholder="Your Password">
                        </div>
                       
                            
                        

                        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>


   <!-- <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="email" placeholder="Email Address" name = "email"/>
                            <input type="password" placeholder="Password" name = "password"/>
                            <span>
                                <input type="checkbox" class="checkbox"> 
                                Keep me signed in                                 <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                 Keep me signed in
                            </span>
                            <span>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </span>
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>-->
@endsection
@section('script')

@endsection