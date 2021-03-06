@extends('layouts.app')
@section('head')
    {{--Guesthouse module is clone of hotel, leaving the css as is--}}
    <link href="{{ asset('dist/frontend/module/hotel/css/hotel.css?v='.config('asset.guesthouse.css')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
@section('content')
    <div class="bravo_detail_hotel">
        @include('Guesthouse::frontend.layouts.details.guesthouse-banner')
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        @php $review_score = $row->review_data @endphp
                        @include('Guesthouse::frontend.layouts.details.guesthouse-detail')
                        @include('Guesthouse::frontend.layouts.details.guesthouse-review')
                    </div>
                    <div class="col-md-12 col-lg-3 mb-4">
                        <div class="" style="position: sticky; position: -webkit-sticky; top: 100px;">
                            @include('Tour::frontend.layouts.details.vendor')
                            @include('Guesthouse::frontend.layouts.details.guesthouse-form-enquiry')
                            {{--@include('Guesthouse::frontend.layouts.details.guesthouse-related-list')--}}
{{--                            <div class="g-all-attribute is_pc">--}}
{{--                                @include('Guesthouse::frontend.layouts.details.guesthouse-attributes')--}}
{{--                            </div>--}}
                            @include('Guesthouse::frontend.layouts.details.sidebar')
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('Guesthouse::frontend.layouts.details.guesthouse-form-enquiry-mobile')
    </div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                }
            });
            @endif
        })
    </script>
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        var bravo_booking_i18n = {
			no_date_select:'{{__('Please select Start and End date')}}',
            no_guest_select:'{{__('Please select at least one guest')}}',
            load_dates_url:'{{route('space.vendor.availability.loadDates')}}',
            name_required:'{{ __("Name is Required") }}',
            email_required:'{{ __("Email is Required") }}',
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/guesthouse/js/single-hotel.js?_ver='.config('asset.guesthouse.js')) }}"></script>
@endsection
