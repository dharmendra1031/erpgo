<!DOCTYPE html>
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_favicon=Utility::getValByName('company_favicon');

    $SITE_RTL = Cookie::get('SITE_RTL');

@endphp
<html lang="en" dir="{{$SITE_RTL == 'on'?'rtl':''}}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'ERPGO')}} - @yield('page-title')</title>
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
{{--    @if(Auth::check())--}}
{{--        <link rel="stylesheet" href="{{ asset('css/custom-'.\Auth::user()->mode.'.css') }}" id="stylesheet">--}}
{{--    @else--}}
{{--        <link rel="stylesheet" href="{{ asset('css/site-light.css') }}" id="stylesheet">--}}
{{--    @endif   --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ac.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @if($SITE_RTL=='on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif
</head>

<body>
@yield('content')

<!-- General JS Scripts -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/nicescroll/jquery.nicescroll.min.js')}} "></script>
@stack('custom-scripts')
</body>
</html>
