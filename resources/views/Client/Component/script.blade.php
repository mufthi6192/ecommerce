<script src="{{asset("assets/js/vendor/modernizr.min.js")}}"></script>
<!-- jQuery JS -->
<script src="{{asset("assets/js/vendor/jquery.js")}}"></script>
<!-- Bootstrap JS -->
<script src="{{asset("assets/js/vendor/popper.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/bootstrap.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/slick.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/js.cookie.js")}}"></script>
<!-- <script src="assets/js/vendor/jquery.style.switcher.js"></script> -->
<script src="{{asset("assets/js/vendor/jquery-ui.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/jquery.countdown.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/sal.js")}}"></script>
<script src="{{asset("assets/js/vendor/jquery.magnific-popup.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/imagesloaded.pkgd.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/isotope.pkgd.min.js")}}"></script>
<script src="{{asset("assets/js/vendor/counterup.js")}}"></script>
<script src="{{asset("assets/js/vendor/waypoints.min.js")}}"></script>

<!-- Main JS -->
<script src="{{asset("assets/js/main.js")}}"></script>

@if($code!=null)
<script src="{{asset("assets/js/vendor/pagination.min.js")}}"></script>
<script src="{{asset("assets/js/client/".$code.".js")}}"></script>
@endif

<script src="{{asset("assets/js/client/global.js")}}"></script>
