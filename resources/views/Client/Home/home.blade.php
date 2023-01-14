@extends('Client.main')

@section('main')

    <!-- Start Slider Area -->
    <div class="axil-main-slider-area main-slider-style-2">
        <div class="container">
            <div class="slider-offset-left">
                <div class="row row--20">
                    <div class="col-lg-9">
                        <div class="slider-box-wrap">
                            <div class="slider-activation-one axil-slick-dots">
                                <div class="single-slide slick-slide">
                                    <div class="main-slider-content">
                                        <h1 class="title">Belanja lebih mudah di Gallery Rihanna</h1>
                                        <div class="shop-btn">
                                            <a href="/client/product" class="axil-btn">Belanja Sekarang <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="main-slider-thumb">
                                        <img src="{{asset('assets/images/main/2.png')}}" alt="Product">
                                    </div>
                                </div>
                                <div class="single-slide slick-slide">
                                    <div class="main-slider-content">
                                        <h1 class="title">Menjual berbagai macam produk busana muslim</h1>
                                        <div class="shop-btn">
                                            <a href="/client/product" class="axil-btn">Belanja Sekarang <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="main-slider-thumb">
                                        <img src="{{asset('assets/images/main/3.png')}}" alt="Product">
                                    </div>
                                </div>
                                <div class="single-slide slick-slide">
                                    <div class="main-slider-content">
                                        <h1 class="title">Cari gamis ? Gallery Rihanna solusinya</h1>
                                        <div class="shop-btn">
                                            <a href="/client/product" class="axil-btn">Belanja Sekarang <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="main-slider-thumb">
                                        <img src="{{asset('assets/images/main/main.png')}}" alt="Product">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="slider-product-box">
                            <div class="product-thumb">
                                <a href="/client/product">
                                    <img src="{{asset('assets/images/main/main.png')}}" alt="Product">
                                </a>
                            </div>
                            <h6 class="title"><a href="/client/product">Produk murah berkualitas</a></h6>
                            <span class="price">RP. X1.XXX</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slider Area -->

    <div class="service-area">
        <div class="container">
            <div class="row row-cols-xl-5 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 row--20">
                <div class="col">
                    <div class="service-box">
                        <div class="icon">
                            <img src="{{asset("assets/images/icons/service1.png")}}" alt="Service">
                        </div>
                        <h6 class="title">Pengiriman Aman &amp; Tepat</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="service-box">
                        <div class="icon">
                            <img src="{{asset("assets/images/icons/service2.png")}}" alt="Service">
                        </div>
                        <h6 class="title">Garansi Produk Terbaik</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="service-box">
                        <div class="icon">
                            <img src="{{asset("assets/images/icons/service3.png")}}" alt="Service">
                        </div>
                        <h6 class="title">Pengiriman Tercepat</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="service-box">
                        <div class="icon">
                            <img src="{{asset("assets/images/icons/service4.png")}}" alt="Service">
                        </div>
                        <h6 class="title">Garansi Barang Kembali !</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="service-box">
                        <div class="icon">
                            <img src="{{asset("assets/images/icons/service5.png")}}" alt="Service">
                        </div>
                        <h6 class="title">Kualitas dan Mutu Terjamin</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Expolre Product Area  -->
    <div class="axil-product-area bg-color-white axil-section-gap">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-primary"> <i class="far fa-shopping-basket"></i> Our Products</span>
                <h2 class="title">Explore our Products</h2>
            </div>
            <div class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                <div class="slick-single-layout">
                    <div class="row row--15">

                        {{--Product--}}
                        @foreach($product as $key => $data)
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                                <div class="axil-product product-style-one">
                                    <div class="thumbnail">

                                            <img data-sal="fade" data-sal-delay="400" data-sal-duration="1500" src="{{asset('assets/images/product/'.$data['product_image'])}}" alt="Product Images">

                                        <div class="label-block label-right">
                                            <div class="product-badget">{{$data['product_category']}}</div>
                                        </div>
                                        <div class="product-hover-action">
                                            <ul class="cart-action">
                                                <li class="quickview"><a href="/client/product/{{$data['product_id']}}"><i class="far fa-eye"></i></a></li>
                                                <li class="select-option"><a href="https://api.whatsapp.com/send?phone=6281221569002&text=Halo%20saya%20mau%20beli%20{{$data['product_name']}}">Beli</a></li>
                                                <li class="wishlist"><a href="#"><i class="far fa-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="inner">
                                            <h5 class="title">{{$data['product_name']}}</h5>
                                            <div class="product-price-variant">
                                                <span class="price current-price">@rupiahFormatter($data['product_price'])</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--End Product--}}

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 text-center mt--20 mt_sm--0">
                    <a href="{{route('product-index')}}" class="axil-btn btn-bg-lighter btn-load-more">Semua Produk</a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Expolre Product Area  -->



    <div class="clearfix mb-3"></div>

@endsection
