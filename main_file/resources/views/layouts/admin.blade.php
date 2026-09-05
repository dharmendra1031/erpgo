@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_favicon=Utility::getValByName('company_favicon');
    $SITE_RTL = Cookie::get('SITE_RTL');

@endphp
    <!DOCTYPE html>
<html lang="en" dir="{{$SITE_RTL == 'on'?'rtl':''}}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'ERPGO')}} - @yield('page-title')</title>
    <meta name="url" content="{{ url('').'/'.config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">


    {{-- <script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script> --}}
    <script src="{{ asset('js/chatify/autosize.js') }}"></script>
    <script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

    <link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
    <link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet"/>


    <script src="{{ asset('js/letter.avatar.js')}}"></script>
    <script>
        LetterAvatar.transform();
    </script>


    @stack('css-page')


    @if(Auth::check())
        <link rel="stylesheet" href="{{ asset('css/site-'.Auth::user()->mode.'.css') }}" id="stylesheet">
    @else
        <link rel="stylesheet" href="{{asset('assets/css/site.css') }}">
    @endif
    <link rel="stylesheet" href="{{asset('assets/css/ac.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/stylesheet.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css') }}">
    @if(Auth::check() && Auth::user()->mode =='dark')
        <link rel="stylesheet" href="{{ asset('css/mode-dark.css') }}" id="stylesheet">
    @endif

    @if($SITE_RTL=='on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif

</head>

<body class="application application-offset">
<div class="container-fluid container-application">
    @include('partials.admin.menu')
    <div class="main-content position-relative">
        @include('partials.admin.header')
        <div class="page-content">
            <div class="page-title">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-4 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                        <div class="d-inline-block">
                            <h5 class="h4 d-inline-block font-weight-400 mb-0 ">@yield('page-title')</h5>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 d-flex align-items-center justify-content-between justify-content-md-end">
                        @yield('action-button')
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</div>

<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div>
                <h4 class="h4 font-weight-400 float-left modal-title" id="exampleModalLabel"></h4>
                <a href="#" class="more-text widget-text float-right close-icon" data-dismiss="modal" aria-label="Close">{{__('Close')}}</a>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

{{--Side Modal--}}
<div class="modal fade fixed-right" id="commonModal-right" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="scrollbar-inner">
        <div class="min-h-300 mh-300">
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/site.core.js') }}"></script>

<script src="{{ asset('assets/libs/progressbar.js/dist/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/nicescroll/jquery.nicescroll.min.js')}} "></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script>moment.locale('en');</script>
@stack('theme-script')

<script>
    var dataTabelLang = {
        paginate: {previous: "{{__('Previous')}}", next: "{{__('Next')}}"},
        lengthMenu: "{{__('Show')}} _MENU_ {{__('entries')}}",
        zeroRecords: "{{__('No data available in table')}}",
        info: "{{__('Showing')}} _START_ {{__('to')}} _END_ {{__('of')}} _TOTAL_ {{__('entries')}}",
        infoEmpty: " ",
        search: "{{__('Search:')}}"
    }
</script>

<script src="{{ asset('assets/js/site.js') }}"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>

<script src="{{ asset('assets/js/jscolor.js') }} "></script>
<script>
    var toster_pos = "{{$SITE_RTL=='on' ?'left' : 'right'}}";
</script>
<script src="{{ asset('assets/js/custom.js') }} "></script>
@if(Utility::getValByName('gdpr_cookie') == 'on')
    <script type="text/javascript">

        var defaults = {
            'messageLocales': {
                /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                'en': "{{Utility::getValByName('cookie_text')}}"
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'cookieNoticePosition': 'bottom',
            'learnMoreLinkEnabled': false,
            'learnMoreLinkHref': '/cookie-banner-information.html',
            'learnMoreLinkText': {
                'it': 'Saperne di più',
                'en': 'Learn more',
                'de': 'Mehr erfahren',
                'fr': 'En savoir plus'
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'expiresIn': 30,
            'buttonBgColor': '#d35400',
            'buttonTextColor': '#fff',
            'noticeBgColor': '#051c4b',
            'noticeTextColor': '#fff',
            'linkColor': '#009fdd'
        };
    </script>
    <script src="{{ asset('assets/js/cookie.notice.js')}}"></script>
@endif
<script>
    var date_picker_locale = {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
            "{{__('Sun')}}",
            "{{__('Mon')}}",
            "{{__('Tue')}}",
            "{{__('Wed')}}",
            "{{__('Thu')}}",
            "{{__('Fri')}}",
            "{{__('Sat')}}"
        ],
        monthNames: [
            "{{__('January')}}",
            "{{__('February')}}",
            "{{__('March')}}",
            "{{__('April')}}",
            "{{__('May')}}",
            "{{__('June')}}",
            "{{__('July')}}",
            "{{__('August')}}",
            "{{__('September')}}",
            "{{__('October')}}",
            "{{__('November')}}",
            "{{__('December')}}"
        ],
    };
    var calender_header = {
        today: "{{__('today')}}",
        month: '{{__('month')}}',
        week: '{{__('week')}}',
        day: '{{__('day')}}',
        list: '{{__('list')}}'
    };
</script>
@if($message = Session::get('success'))
    <script>
        show_toastr('Success', '{!! $message !!}', 'success');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('Error', '{!! $message !!}', 'error');
    </script>
@endif

@include('Chatify::layouts.footerLinks')
@stack('script-page')
</body>
</html>
