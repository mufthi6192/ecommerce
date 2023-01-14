@extends('Client.Error.main')

@section('main')

    <section class="error-page onepage-screen-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <span class="title-highlighter highlighter-secondary"> <i class="fal fa-exclamation-circle"></i> Oops! Somthing's missing.</span>
                        <h1 class="title">Page not found</h1>
                        <p>
                            @if(\Illuminate\Support\Facades\Session::get('error_message') !== null)
                            {{\Illuminate\Support\Facades\Session::get('error_message')}}
                            @endif
                        </p>
                        <a href="{{route('home-index')}}" class="axil-btn btn-bg-secondary right-icon">Back To Home <i class="fal fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="thumbnail" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                        <img src="{{asset('assets/images/others/404.png')}}" alt="404">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
