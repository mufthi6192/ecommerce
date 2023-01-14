<!-- Start Header Top Area  -->
<div class="axil-header-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-sm-3 col-5">
                <div class="header-brand">
                    <a href="#" class="logo logo-dark">
                        <img src="{{asset('assets/images/logo/logo-small-rev.png')}}" alt="Site Logo">
                    </a>
                    <a href="#" class="logo logo-light">
                        <img src="{{asset('assets/images/logo/logo-small-rev.png')}}" alt="Site Logo">
                    </a>
                </div>
            </div>
            <div class="col-lg-10 col-sm-9 col-7">
                <div class="header-top-dropdown dropdown-box-style">
                    <div class="axil-search">
                        <input type="search" class="placeholder product-search-input" name="search2" id="searchbar" value="" maxlength="128" placeholder="Cari produk...." autocomplete="off">
                        <button id="search-button" type="submit" class="icon wooc-btn-search">
                            <i class="far fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Header Top Area  -->

<!-- Start Mainmenu Area  -->
<div class="axil-mainmenu aside-category-menu">
    <div class="container">
        <div class="header-navbar">
            @if($code == 'home')
                <div class="header-nav-department">
                    <aside class="header-department">
                        <button class="header-department-text department-title">
                            <span class="icon"><i class="fal fa-bars"></i></span>
                            <span class="text">Kategori</span>
                        </button>
                        <nav class="department-nav-menu">
                            <button class="sidebar-close"><i class="fas fa-times"></i></button>
                            <ul class="nav-menu-list">


                                @foreach($category as $key => $data)

                                    <li>
                                        <a href="{{route('category-index',$data['category_id'])}}" class="nav-link">
                                            <span class="menu-icon"><img src="{{asset('/assets/images/categories/'.$data['category_image'])}}" alt="Kategori"></span>
                                            <span class="menu-text">{{$data['category_name']}}</span>

                                        </a>
                                    </li>

                                @endforeach

                            </ul>
                        </nav>
                    </aside>
                </div>
            @endif
            <div class="header-main-nav">
                <!-- Start Mainmanu Nav -->
                <nav class="mainmenu-nav">
                    <button class="mobile-close-btn mobile-nav-toggler"><i class="fas fa-times"></i></button>
                    <div class="mobile-nav-brand">
                        <a href="#" class="logo">
                            <img src="{{asset('assets/images/logo/logo-big-rev.png')}}" alt="Site Logo">
                        </a>
                    </div>
                    <ul class="mainmenu">
                        <li><a href="{{route('home')}}">Home</a></li>
                        @if($code != 'home')
                            <li class="menu-item-has-children">
                                <a href="#">Kategori</a>
                                <ul class="axil-submenu">
                                    @foreach($category as $key => $data)
                                    <li><a href="{{route('category-index',$data['category_id'])}}">{{$data['category_name']}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                        <li><a href="{{route('product-index')}}">Semua Produk</a></li>
                        <li class="menu-item-has-children">
                            <a href="#">Social Media</a>
                            <ul class="axil-submenu">
                                <li><a href="https://www.facebook.com/rihannashop.nurasiyah">Facebook</a></li>
                                <li><a href="#">Instagram</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('payment-index')}}">Metode Pembayaran</a></li>
                    </ul>
                </nav>
                <!-- End Mainmanu Nav -->
            </div>
            <div class="header-action">
                <ul class="action-list">
                    <li class="axil-search d-sm-none d-block">
                        <a href="javascript:void(0)" class="header-search-icon" title="Search">
                            <i class="flaticon-magnifying-glass"></i>
                        </a>
                    </li>
                    <li class="axil-mobile-toggle">
                        <button class="menu-btn mobile-nav-toggler">
                            <i class="flaticon-menu-2"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Mainmenu Area  -->
