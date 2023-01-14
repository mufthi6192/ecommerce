@extends('Client.main')

@section('main')
    <!-- Start Expolre Product Area  -->
    <div class="axil-product-area bg-color-white axil-section-gap">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-primary"> <i class="far fa-shopping-basket"></i>Halaman Kategori</span>
                <h2 class="title">Seluruh Produk</h2>
            </div>
            <div class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                <div class="slick-single-layout">
                    <div class="row row--15" id="list-product">

                        {{--Product--}}

                        {{--End Product--}}

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center text-center mt--20 mt_sm--0" id="pagination-container">

                </div>
            </div>

        </div>
    </div>
    <!-- End Expolre Product Area  -->



    <div class="clearfix mb-3"></div>

@endsection
