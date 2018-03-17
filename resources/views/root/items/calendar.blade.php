@extends('root.layouts.main')

@section('styles')
    <link href="/root/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="col-lg-12"> 
        <!--begin::Portlet-->
        <div class="m-portlet" id="m_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-business"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{ $item->name }}
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">
                <div id="m_calendar"></div>
            </div>
        </div>  
        <!--end::Portlet-->
    </div>
@endsection

@section('scripts')
    <script src="/root/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
    <script>
        var CalendarBasic = function() {
            return {
                //main function to initiate the module
                init: function() {
                    $('#m_calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: ''
                        },
                        editable: false,
                        eventLimit: false,
                        navLinks: false,
                        events: [
                            @foreach($item_calendar as $index => $calendar_day)
                                {
                                    title: '{{ $calendar_day->quantity }}',
                                    start: '{{ $calendar_day->date }}',
                                    className: "m-fc-event--solid-{{ $calendar_day->class }} m-fc-event--light",
                                    description: 'Lorem ipsum dolor sit amet, labore'
                                },
                            @endforeach
                        ],
                    });
                }
            };
        }();

        jQuery(document).ready(function() {
            CalendarBasic.init();
        });
    </script>
@endsection