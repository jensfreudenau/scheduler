@extends('admin.app')

@section('content')
    <script src="{{ asset('js/jquery/jquery.min.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/dhtmlxscheduler.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_recurring.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_agenda_view.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_minical.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_tooltip.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/locale/locale_de.js') }}"></script>
    <link href="{{ asset('css/scheduler/dhtmlxscheduler_material.css') }}?v=5.3.12" rel="stylesheet">
    <style>
        html, body{
            margin:0px;
            padding:0px;
            height:100%;
        }
        /*.dhx_cal_navline .dhx_cal_date {*/
        /*    font-size:16px;*/
        /*    font-weight: 200;*/
        /*}*/
        /*.dhx_cal_event .dhx_title , .dhx_cal_event .dhx_body{*/
        /*    color: #000000;*/
        /*    font-weight: 200;*/
        /*    font-size:11px;*/
        /*}*/
        label:not(.form-check-label):not(.custom-file-label) {
            font-weight: 500;
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
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.colors.show')</h3>
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('quickadmin.users.fields.color')</th>
                                    <th>@lang('quickadmin.colors.fields.name')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-entry-id="{{ $color->id }}">
                                    <td><span style="font-size: 1.5em; color: {{ $color->text }};">
                                          <i class="fas fa-user"></i>
                                        </span></td>
                                    <td>{{ $color->description }}</td>

                                </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.colors.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
{{--            <div class="card card-default">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}

{{--                            <div id="scheduler_here" class="dhx_cal_container panel" style='height:2000px; margin: 30px; margin-right: 100px;'>--}}
{{--                                <div class="dhx_cal_navline">--}}
{{--                                    <div class="dhx_cal_prev_button">&nbsp;</div>--}}
{{--                                    <div class="dhx_cal_next_button">&nbsp;</div>--}}
{{--                                    <div class="dhx_cal_today_button"></div>--}}
{{--                                    <div class="dhx_cal_date"></div>--}}
{{--                                    <div class="dhx_cal_tab" name="day_tab"></div>--}}
{{--                                    <div class="dhx_cal_tab" name="week_tab"></div>--}}
{{--                                    <div class="dhx_cal_tab" name="month_tab"></div>--}}
{{--                                    <div class="dhx_cal_tab" name="agenda_tab"></div>--}}
{{--                                    <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>--}}
{{--                                </div>--}}
{{--                                <div class="dhx_cal_header"></div>--}}
{{--                                <div class="dhx_cal_data"></div>--}}
{{--                            </div>--}}
{{--                            <div class="dhx_cal_header"></div>--}}
{{--                            <div class="dhx_cal_data"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
        <script type="text/javascript">
            {{--scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%d.%m.%Y %H:%i");--}}
            {{--scheduler.config.details_on_dblclick = true;--}}
            {{--scheduler.config.details_on_create = true;--}}
            {{--scheduler.locale.labels.section_color = "Color section";--}}
            {{--let color_options = scheduler.serverList("colors");--}}
            {{--scheduler.date.agenda_start = function(date){--}}
            {{--    return scheduler.date.month_start(new Date(date));--}}
            {{--};--}}

            {{--scheduler.date.add_agenda = function(date, inc){--}}
            {{--    return scheduler.date.add(date, inc, "month");--}}
            {{--};--}}

            {{--let update_select_options = function(select, options) { // helper function--}}
            {{--    select.options.length = 0;--}}
            {{--    for (let i=0; i<options.length; i++) {--}}
            {{--        let option = options[i];--}}
            {{--        select[i] = new Option(option.label, option.key);--}}
            {{--    }--}}
            {{--};--}}

            {{--scheduler.attachEvent("onBeforeLightbox", function(id){--}}
            {{--    let ev = scheduler.getEvent(id);--}}
            {{--    let color_id = ev.color_id;--}}
            {{--    return true;--}}
            {{--});--}}


            {{--let format = scheduler.date.date_to_str("%H:%i");--}}
            {{--scheduler.config.multi_day = true;--}}
            {{--scheduler.config.first_hour = 0;--}}
            {{--scheduler.config.last_hour = 24;--}}
            {{--scheduler.config.limit_time_select = true;--}}
            {{--let readOnly = "{{Auth::user()->hasRole('Pfleger')}}";--}}
            {{--if( readOnly == 1) {--}}
            {{--    scheduler.config.readonly = true;--}}
            {{--}--}}

            {{--scheduler.setLoadMode("month");--}}
            {{--scheduler.config.lightbox.sections = [--}}
            {{--    { name: "Text", height:50, map_to:"text", type:"textarea", focus:true },--}}
            {{--    { name: "Farben", height: 23, type: "select", options: color_options, map_to: "color_id"},--}}
            {{--    { name: "recurring", height:115, type: "recurring", map_to: "rec_type", button: "recurring"},--}}
            {{--    { name: "time", height:72, type:"time", map_to:"auto"}--}}
            {{--];--}}

            {{--scheduler.templates.hour_scale = function(date){--}}
            {{--    let step = 15;--}}
            {{--    let html = "";--}}
            {{--    for (let i=0; i<60/step; i++){--}}
            {{--        html += "<div style='height:22px;line-height:22px;'>"+format(date)+"</div>";--}}
            {{--        date = scheduler.date.add(date, step, "minute");--}}
            {{--    }--}}
            {{--    return html;--}}
            {{--}--}}
            {{--scheduler.init("scheduler_here", new Date(), "agenda");--}}
            {{--scheduler.load("/admin/api/eventdata?agenda=true", "json");--}}
            {{--scheduler.form_blocks["my_editor"] = {--}}
            {{--    render: function (sns) {--}}
            {{--        return "<div class='dhx_cal_ltext' style='height:60px;'>" +--}}
            {{--            "Text&nbsp;<input name='text' type='text'><br/>" +--}}
            {{--            "Details&nbsp;<input name='location' type='text'></div>";--}}
            {{--    },--}}
            {{--    set_value: function (node, value, ev) {--}}
            {{--        node.querySelector("[name='text']").value = value || "";--}}
            {{--        node.querySelector("[name='location']").value = ev.location || "";--}}
            {{--    },--}}
            {{--    get_value: function (node, ev) {--}}
            {{--        ev.location = node.querySelector("[name='location']").value;--}}
            {{--        return node.querySelector("[name='text']").value;--}}
            {{--    },--}}
            {{--    focus: function (node) {--}}
            {{--        var input = node.querySelector("[name='text']");--}}
            {{--        input.select();--}}
            {{--        input.focus();--}}
            {{--    }--}}
            {{--};--}}

            {{--scheduler.locale.labels.section_description = "Details";--}}
            {{--let dp = new dataProcessor("/admin/api/eventdata");--}}
            {{--dp.init(scheduler);--}}
            {{--dp.setTransactionMode({--}}
            {{--    mode:"REST",--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
            {{--    }--}}
            {{--});--}}

            {{--function addNewEv() {--}}
            {{--    scheduler.addEventNow();--}}
            {{--}--}}

            {{--function show_minical() {--}}
            {{--    if (scheduler.isCalendarVisible())--}}
            {{--        scheduler.destroyCalendar();--}}
            {{--    else--}}
            {{--        scheduler.renderCalendar({--}}
            {{--            position: "dhx_minical_icon",--}}
            {{--            date: scheduler.getState().date,--}}
            {{--            navigation: true,--}}
            {{--            handler: function (date, calendar) {--}}
            {{--                scheduler.setCurrentView(date);--}}
            {{--                scheduler.destroyCalendar()--}}
            {{--            }--}}
            {{--        });--}}
            {{--}--}}

            {{--function search(value){--}}
            {{--    scheduler.filter_day =scheduler.filter_week = scheduler.filter_month =function(id, event){--}}
            {{--        let haystack = (event.text || ""), needle = (value || "");--}}
            {{--        return haystack.indexOf(needle) != -1;--}}
            {{--    }--}}

            {{--    scheduler.setCurrentView();--}}
            {{--}--}}

            {{--$(document).ready(function () {--}}
            {{--    $.noConflict();--}}
            {{--    $("#myInput").on("keyup", function() {--}}
            {{--        var value = $(this).val();--}}
            {{--        search(value);--}}
            {{--        //$("#myTable tr").filter(function() {--}}
            {{--        //  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)--}}
            {{--        //});--}}
            {{--    });--}}
            {{--});--}}
        </script>


@stop
