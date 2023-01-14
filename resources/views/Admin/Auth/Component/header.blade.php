<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Owlio - School Admission Admin Dashboard" />

<title>{{$title}}</title>

<meta property="og:title" content="Gallery Rihanna - Admin Panel Login Page" />
<meta property="og:description" content="Login Page for Gallery Rihanna Admin Panel" />
<meta property="og:image" content="{{asset('assets/images/logo/logo-big-rev.png')}}" />

<!-- Favicon icon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/logo/logo.svg')}}">
<link href="{{asset('admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/css/style.css')}}" rel="stylesheet">

{{--Utilities--}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{--Additional--}}
<link href="{{asset('admin/css/custom/list.scss')}}" rel="stylesheet">
