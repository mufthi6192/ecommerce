<!doctype html>
<html class="no-js" lang="en">

<head>
@include('Client.Component.header')
</head>


<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://google.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
<!-- Start Header -->
<header class="header axil-header header-style-2">
    @include('Client.Component.topbar')
</header>

<main class="main-wrapper">

    @yield('main')

</main>

{{--Modal--}}
@include('Client.Component.modal')

<!-- Start Footer Area  -->
<footer class="axil-footer-area footer-style-2">
    @include('Client.Component.footer')
</footer>
<!-- End Footer Area  -->



<!-- JS
============================================ -->
<!-- Modernizer JS -->
@include('Client.Component.script')

</body>

</html>
