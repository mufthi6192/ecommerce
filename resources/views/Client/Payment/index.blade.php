@extends('Client.main')

@section('main')

    <!-- Start About Area  -->

    <div class="clearfix mb-5"></div>
    <div class="clearfix mb-5"></div>
    <div class="clearfix mb-5"></div>

    <div class="about-info-area">
        <div class="container">
            <div class="row row--20">
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{asset('assets/images/payment/big/1.png')}}" alt="Shape">
                        </div>
                        <div class="content">
                            <h3 class="title">Bank BCA</h3>
                            <h6>7750869551<br><br>
                                An. Nur Asiyah
                            </h6>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{asset('assets/images/payment/big/2.png')}}" alt="Shape">
                        </div>
                        <div class="content">
                            <h3 class="title">Bank BRI</h3>
                            <h6>0765-01-005186-53-4<br><br>
                                An. Nur Asiyah
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{asset('assets/images/payment/big/3.png')}}" alt="Shape">
                        </div>
                        <div class="content">
                            <h3 class="title">Bank Mandiri</h3>
                            <h6>900-00-2084763-9<br><br>
                                An. Nur Asiyah
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Area  -->

    <div class="clearfix mb-5"></div>
    <div class="clearfix mb-5"></div>
    <div class="clearfix mb-5"></div>

@endsection()
