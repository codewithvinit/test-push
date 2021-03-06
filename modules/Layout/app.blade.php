<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$html_class ?? ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php event(new \Modules\Layout\Events\LayoutBeginHead()); @endphp
    @php
        $favicon = setting_item('site_favicon');
    @endphp
    @if($favicon)
        @php
            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
        @endphp
        @if(!empty($file))
            <link rel="icon" type="{{$file['file_type']}}" href="{{asset('uploads/'.$file['file_path'])}}" />
        @else:
            <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}" />
        @endif
    @endif

    @include('Layout::parts.seo-meta')
    <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/notification.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css?_ver='.config('asset.layout.css')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel='stylesheet' id='google-font-css-css' href='https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap' type='text/css' media='all' />
    {!! \App\Helpers\Assets::css() !!}
    {!! \App\Helpers\Assets::js() !!}
    <script>
        var bookingCore = {
            url:'{{url( app_get_locale() )}}',
            url_root:'{{ url('') }}',
            booking_decimals:{{(int)get_current_currency('currency_no_decimal',2)}},
            thousand_separator:'{{get_current_currency('currency_thousand')}}',
            decimal_separator:'{{get_current_currency('currency_decimal')}}',
            currency_position:'{{get_current_currency('currency_format')}}',
            currency_symbol:'{{currency_symbol()}}',
			currency_rate:'{{get_current_currency('rate',1)}}',
            date_format:'{{get_moment_date_format()}}',
            map_provider:'{{setting_item('map_provider')}}',
            map_gmap_key:'{{setting_item('map_gmap_key')}}',
            routes:{
                login:'{{route('auth.login')}}',
                register:'{{route('auth.register')}}',
                checkout:'{{is_api() ? route('api.booking.doCheckout') : route('booking.doCheckout')}}'
            },
            module:{
                hotel:'{{route('hotel.search')}}',
                car:'{{route('car.search')}}',
                tour:'{{route('tour.search')}}',
                space:'{{route('space.search')}}',
            },
            currentUser: {{(int)Auth::id()}},
            isAdmin : {{is_admin() ? 1 : 0}},
            rtl: {{ setting_item_with_lang('enable_rtl') ? "1" : "0" }},
            markAsRead:'{{route('core.notification.markAsRead')}}',
            markAllAsRead:'{{route('core.notification.markAllAsRead')}}',
            loadNotify : '{{route('core.notification.loadNotify')}}',
            pusher_api_key : '{{setting_item("pusher_api_key")}}',
            pusher_cluster : '{{setting_item("pusher_cluster")}}',
        };
        var i18n = {
            warning:"{{__("Warning")}}",
            success:"{{__("Success")}}",
        };
        var daterangepickerLocale = {
            "applyLabel": "{{__('Apply')}}",
            "cancelLabel": "{{__('Cancel')}}",
            "fromLabel": "{{__('From')}}",
            "toLabel": "{{__('To')}}",
            "customRangeLabel": "{{__('Custom')}}",
            "weekLabel": "{{__('W')}}",
            "first_day_of_week": {{ setting_item("site_first_day_of_the_weekin_calendar","1") }},
            "daysOfWeek": [
                "{{__('Su')}}",
                "{{__('Mo')}}",
                "{{__('Tu')}}",
                "{{__('We')}}",
                "{{__('Th')}}",
                "{{__('Fr')}}",
                "{{__('Sa')}}"
            ],
            "monthNames": [
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
    </script>
    <style type="text/css">
        body{
            font-family: 'Quicksand', sans-serif;
        }

        .bravo-header-sticky{
            transition: all 1s ease;
        }

        @keyframes zoomUp{
            100%{
                -webkit-transform: scale(1.15);
                -ms-transform: scale(1.15);
                transform: scale(1.15);
            }
        }

        .bravo-forms-search-bg{
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -10;
            background-size: cover;
            overflow: hidden;
            background-position: center;
            animation: zoomUp 15s ease-in 0s 1 normal forwards;
        }

        a.anim > span {
            transition: all .5s ease;
        }

        a.anim:hover > span {
            transform: translateX(8px) rotate(90deg);
        }
    </style>
    @php
        $route = \Request::route()->getName();

        //avoid rendering the transparent menu on detail pages of each module as the detail page doesn't
        //have any visible backgrounds on header.
        $render_transparent_menu = ($row->transparent_menu ?? false);

        $rex = "/(^news|^page).(detail|index)/i";
        $searchRex = "/.search/i";
        if(preg_match($rex, $route) || preg_match($searchRex, $route)) {
            // render transparent menu in all generic page.detail
            $render_transparent_menu = true;
        }
    @endphp
    @if($render_transparent_menu)
        <style type="text/css">

            .bravo-form-search-all {
                position: relative;
                overflow: hidden;
                height: 100vh;
                margin-top: -94px;
            }

            /*.bravo_wrap .bravo_header{*/
            /*    background: none;*/
            /*    z-index: 10;*/
            /*}*/

            /*.bravo_wrap .bravo_header .content{*/
            /*    background: none;*/
            /*}*/

            .bravo_header .content img{
                transition: all .3s ease-out;
            }

            .bravo_wrap .bravo_header.fixed-top .content .header-left .bravo-menu ul li a {
                color: #1a2b48;
            }

            .bravo_wrap .bravo_header .content .header-left .bravo-menu ul li a{
                transition: all .2s ease-out;
                color: white;
                text-transform: none;
                font-weight: bold;
            }
            .bravo_header.fixed-top .container-fluid,  .bravo_header.fixed-top .container-fluid {
                transition: background-color .2s ease-out;
                padding: 0;
            }
            .bravo_header.fixed-top .container-fluid,  .bravo_header.fixed-top .container-fluid .content {
                background-color: white;
                box-shadow: 1px 0 1px #1a2b48;
                /*box-shadow: 2px 3px 8px rgba(0,0,0,.1);*/
            }

            .bravo_header.fixed-top{
                background-color: unset;
            }
            .bravo_header .content img{
                max-height: 65px;
                filter: brightness(0) invert(1);
            }
            .bravo_header .content img.fixed-logo{
                max-height: 60px;
                filter: none;
            }
            .bravo_wrap .page-template-content .bravo-form-search-all .text-heading{
                text-align: center;
            }
            .bravo_wrap .page-template-content .bravo-form-search-all .sub-heading{
                text-align: center;
            }
            .bravo_wrap .page-template-content .bravo-form-search-all{
                padding: 200px 0;
            }
        </style>
    @else
        <style type="text/css">
            .bravo-contact-block .section{
                padding: 80px 0 !important;
            }

            .bravo_header.fixed-top{
                background-color: white;
            }

            .bravo_wrap .bravo_header .content .header-left .bravo-menu ul li a{
                transition: all .2s ease-out;
                color: #1a2b48;
                text-transform: none;
                font-weight: bold;
            }

            .bravo_header .content img{
                max-height: 65px;
                filter: unset;
            }

            .bravo_header .container-fluid{
                background-color: white;
                box-shadow: 1px 0 1px #1a2b48;
                /*box-shadow: 2px 3px 8px rgba(0,0,0,.1);*/
            }
        </style>
    @endif

    <!-- Styles -->
    @yield('head')
    {{--Custom Style--}}
    <link href="{{ route('core.style.customCss') }}" rel="stylesheet">
    <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
    @if(setting_item_with_lang('enable_rtl'))
        <link href="{{ asset('dist/frontend/css/rtl.css') }}" rel="stylesheet">
    @endif

    {!! setting_item('head_scripts') !!}
    {!! setting_item_with_lang_raw('head_scripts') !!}

    @php event(new \Modules\Layout\Events\LayoutEndHead()); @endphp
</head>

<body class="frontend-page {{$body_class ?? ''}} @if(setting_item_with_lang('enable_rtl')) is-rtl @endif @if(is_api()) is_api @endif">
    @php event(new \Modules\Layout\Events\LayoutBeginBody()); @endphp

    {!! setting_item('body_scripts') !!}
    {!! setting_item_with_lang_raw('body_scripts') !!}
    <div class="bravo_wrap">
        @if(!is_api())
            @include('Layout::parts.topbar')
            @include('Layout::parts.header')
        @endif
        @yield('content')
        @include('Layout::parts.footer')
    </div>
    {!! setting_item('footer_scripts') !!}
    {!! setting_item_with_lang_raw('footer_scripts') !!}
    @php event(new \Modules\Layout\Events\LayoutEndBody()); @endphp
    <script>
        if ($(window).width() > 992) {
            $(window).scroll(function(){
                if ($(this).scrollTop() > 400) {
                    $('.bravo-header-sticky').addClass("fixed-top");
                    $('#app-logo').addClass('fixed-logo');
                    // add padding top to show content behind navbar
                    //$('body').css('padding-top', $('.navbar').outerHeight() + 'px');
                }else{
                    $('.bravo-header-sticky').removeClass("fixed-top");
                    $('#app-logo').removeClass('fixed-logo');
                    // remove padding top from body
                    //$('body').css('padding-top', '0');
                }
            });
        }

        //z-index fix for map overlapping the header
        $('#map_content').css('z-index', '-5');

        $('img').bind('contextmenu', function(e) {
            return false;
        });
    </script>
</body>
</html>
