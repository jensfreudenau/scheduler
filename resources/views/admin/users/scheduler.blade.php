@extends('admin.app')

@section('content')
    <script src="{{ asset('js/scheduler/dhtmlxscheduler.js') }}?v=5.3.11" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_recurring.js') }}?v=5.3.11" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_agenda_view1.js') }}?v=5.3.11" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_minical.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_tooltip.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/locale/locale_de.js') }}"></script>
    <link href="{{ asset('css/scheduler/dhtmlxscheduler_material.css') }}" rel="stylesheet">
    <style type="text/css">
        .dhx_cal_navline .dhx_cal_date {
            font-size:16px;
            font-weight: 200;
        }
        .dhx_cal_event .dhx_title , .dhx_cal_event .dhx_body{
            color: #000000;
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

        .add_event_button:after {
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

            <div class="dhx_cal_tab" name="day_tab"></div>
            <div class="dhx_cal_tab" name="week_tab"></div>
            <div class="dhx_cal_tab" name="month_tab"></div>
            <div class="dhx_cal_tab" name="agenda_tab"></div>
            <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
        </div>
        <div class="dhx_cal_header"></div>
        <div class="dhx_cal_data"></div>
    </div>
    <script type="text/javascript">
        scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%d.%m.%Y %H:%i");
        scheduler.config.details_on_dblclick = true;
        scheduler.config.details_on_create = true;
        scheduler.locale.labels.section_user = "User section";
        let user_options = scheduler.serverList("users");
        let update_select_options = function (select, options) {
            select.options.length = 0;
            for (let i = 0; i < options.length; i++) {
                let option = options[i];
                select[i] = new Option(option.label, option.key);
            }
        };
        scheduler.config.cascade_event_display = true;
        scheduler.config.cascade_event_count = 4;
        scheduler.config.cascade_event_margin = 30;
        scheduler.config.multi_day = true;
        scheduler.config.first_hour = 5;
        scheduler.config.last_hour = 21;
        scheduler.config.limit_time_select = true;
        scheduler.setLoadMode("day");
        scheduler.config.lightbox.sections = [
            { name: "text", height:50, map_to:"text", type:"textarea", focus:true },
            { name: "Mitarbeiter", height: 23, type: "select", options: user_options, map_to: "user_id"},
            { name: "recurring", height:115, type: "recurring", map_to: "rec_type", button: "recurring"},
            { name: "time", height:72, type:"time", map_to:"auto"}
        ];
        scheduler.init("scheduler_here", new Date(), "week");
        scheduler.load("/admin/api/eventdata/user/?id={{ $user->id }}", "json");
        scheduler.form_blocks["my_editor"] = {
            render: function (sns) {
                return "<div class='dhx_cal_ltext' style='height:60px;'>" +
                    "Text&nbsp;<input name='text' type='text'><br/>" +
                    "Details&nbsp;<input name='location' type='text'></div>";
            },
            set_value: function (node, value, ev) {
                node.querySelector("[name='text']").value = value || "";
                node.querySelector("[name='location']").value = ev.location || "";
            },
            get_value: function (node, ev) {
                ev.location = node.querySelector("[name='location']").value;
                return node.querySelector("[name='text']").value;
            },
            focus: function (node) {
                var input = node.querySelector("[name='text']");
                input.select();
                input.focus();
            }
        };

        scheduler.locale.labels.section_description = "Details";
        let dp = new dataProcessor("/admin/api/eventdata/user/?id={{ $user->id }}");
        dp.init(scheduler);
        dp.setTransactionMode({
            mode:"REST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
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
