@extends('Client.main')

@section('main')

    <div class="axil-single-product-area axil-section-gap pb--0 bg-vista-white">
        <div class="single-product-thumb mb--40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb--40">
                        <div class="row">
                            <div class="col-lg-10 order-lg-2">
                                <div class="single-product-thumbnail-wrap zoom-gallery">
                                    <div class="single-product-thumbnail product-large-thumbnail-3 axil-product">
                                        @foreach($product['product_image'] as $data)
                                            <div class="thumbnail">
                                                <a href="{{asset('assets/images/product/'.$data)}}" class="popup-zoom">
                                                    <img src="{{asset('assets/images/product/'.$data)}}" alt="Product Images">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="label-block">

                                    </div>
                                    <divh class="product-quick-view position-view">
                                        <a href="assets/images/product/product-big-01.png" class="popup-zoom">
                                            <i class="far fa-search-plus"></i>
                                        </a>
                                    </divh>
                                </div>
                            </div>
                            <div class="col-lg-2 order-lg-1">
                                <div class="product-small-thumb-3 small-thumb-wrapper">
                                    @foreach($product['product_image'] as $data)
                                    <div class="small-thumb-img">
                                        <img src="{{asset('assets/images/product/'.$data)}}" alt="thumb image">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb--40">
                        <div class="single-product-content">
                            <div class="inner">
                                <h2 class="product-title">{{$product['product_name']}}</h2>
                                <span class="price-amount">@rupiahFormatter($product['product_price'])</span>
                                <div class="product-rating">
                                    <div class="star-rating">

                                    </div>

                                </div>

                                <p class="description">{{$product['product_description']}}</p>

                                <div class="product-variations-wrapper">

                                </div>

                                <!-- Start Product Action Wrapper  -->
                                <div class="product-action-wrapper d-flex-center">

                                    <!-- Start Product Action  -->
                                    <ul class="product-action action-style-two d-flex-center mb--0">
                                        <li class="add-to-cart"><a href="https://api.whatsapp.com/send?phone=6281221569002&text=Halo%20saya%20mau%20beli%20Setcel linen rami" class="axil-btn btn-bg-primary">Beli Sekarang</a></li>
                                        <li class="wishlist"><a href="#" class="axil-btn wishlist-btn"><i class="far fa-heart"></i></a></li>
                                    </ul>
                                    <!-- End Product Action  -->

                                </div>
                                <!-- End Product Action Wrapper  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
