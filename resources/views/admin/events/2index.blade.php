@extends('admin.app')

@section('content')
    <link href="{{ asset('css/scheduler/dhtmlxscheduler_material.css') }}" rel="stylesheet">
    <style type="text/css">
        .dhx_cal_navline .dhx_cal_date {
            font-size:16px;
            font-weight: 200;
        }
        .dhx_cal_event .dhx_title , .dhx_cal_event .dhx_body{
            color: black;
            font-weight: 200;
            font-size:11px;
        }

        .add_event_button {
            position: absolute;
            width: 55px;
            height: 55px;
            background: #ff5722;
            border-radius: 50px;
            top: 250px;
            right: 55px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.3);
            z-index: 5;
            cursor: pointer;
        }

        .add_event_button:after {´
            background: #000;
            border-radius: 2px;
            color: #FFF;
            content: attr(data-tooltip);
            margin: 16px 0 0 -137px;
            opacity: 0;
            padding: 4px 9px;
            position: absolute;
            font-family: "Roboto";
            font-size: 14px;
            visibility: hidden;
            transition: all .5s ease-in-out;
        }

        .add_event_button:hover {
            background: #ff774c;
        }

        .add_event_button:hover:after {
            opacity: 0.55;
            visibility: visible;
        }

        .add_event_button span:before {
            content: "";
            background: #fff;
            height: 16px;
            width: 2px;
            position: absolute;
            left: 26px;
            top: 20px;
        }

        .add_event_button span:after {
            content: "";
            height: 2px;
            width: 16px;
            background: #fff;
            position: absolute;
            left: 19px;
            top: 27px;
        }

        .dhx_cal_event div.dhx_event_resize.dhx_footer {
            background-color: transparent !important;
        }
    </style>
    <div class="add_event_button" onclick="addNewEv()" data-tooltip="Create new event"><span></span></div>
    <div id="scheduler_here" class="dhx_cal_container" style='height:1000px; margin: 100px;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
            <div class="dhx_cal_tab" name="day_tab"></div>
            <div class="dhx_cal_tab" name="week_tab"></div>
            <div class="dhx_cal_tab" name="month_tab"></div>
        </div>
        <div class="dhx_cal_header"></div>
        <div class="dhx_cal_data"></div>
    </div>

    <script src="{{ asset('js/scheduler/dhtmlxscheduler.js') }}?v=5.3.11" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_year_view.js') }}" defer></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_quick_info.js') }}" defer></script>
    <script charset="utf-8" type="text/javascript" src="{{ asset('js/scheduler/locale/locale_de.js') }}"></script>

    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_minical.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">

        scheduler.config.time_step = 30;
        scheduler.config.multi_day = true;
        scheduler.locale.labels.section_subject = "Subject";
        scheduler.config.first_hour = 5;
        scheduler.config.last_hour = 21;
        scheduler.config.limit_time_select = true;
        scheduler.config.details_on_dblclick = true;
        scheduler.config.details_on_create = true;
        scheduler.config.readonly_form = true;
        scheduler.config.cascade_event_display = true; // enable rendering, default value = false
        scheduler.config.cascade_event_count = 4; // how many events events will be displayed in cascade style (max), default value = 4
        scheduler.config.cascade_event_margin = 10; // margin between events, default value = 30
        scheduler.config.xml_date = "%d.%m.%Y %H:%i:%s";
        scheduler.setLoadMode("week");
        scheduler.init("scheduler_here", new Date(), "week");
        scheduler.load("/admin/api/eventdata", "json");
        let dp = new dataProcessor("/admin/api/eventdata");
        dp.init(scheduler);
        dp.setTransactionMode(
            mode:"REST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        scheduler.locale.labels.section_user = "User section";

        let user_options = scheduler.serverList("users");

        let update_select_options = function (select, options) { // helper function
            select.options.length = 0;
            for (let i = 0; i < options.length; i++) {
                let option = options[i];
                select[i] = new Option(option.label, option.key);
            }
        };

        scheduler.config.lightbox.sections = [
            {name: "description", height: 130, map_to: "text", type: "textarea", focus: true},
            {name: "Mitarbeiter", height: 23, type: "select", options: user_options, map_to: "user_id"},
            {name: "time", height: 72, type: "time", map_to: "auto"}
        ];



        scheduler.templates.event_class = function (start, end, event) {
            let css = "";

            if (event.subject) // if event has subject property then special class should be assigned
                css += "event_" + event.subject;

            if (event.id == scheduler.getState().select_id) {
                css += " selected";
            }
            return css; // default return
        };

        function addNewEv() {
            scheduler.addEventNow();
        }

        function show_minical() {
            if (scheduler.isCalendarVisible())
                scheduler.destroyCalendar();
            else
                scheduler.renderCalendar({
                    position: "dhx_minical_icon",
                    date: scheduler.getState().date,
                    navigation: true,
                    handler: function (date, calendar) {
                        scheduler.setCurrentView(date);
                        scheduler.destroyCalendar()
                    }
                });
        }
    </script>

@stop
