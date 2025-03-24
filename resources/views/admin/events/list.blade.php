@extends('admin.app')

@section('content')
    <script src="{{ asset('js/jquery/jquery.min.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/dhtmlxscheduler.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_recurring.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/ext/dhtmlxscheduler_agenda_view.js') }}?v=5.3.12" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/scheduler/locale/locale_de.js') }}"></script>
    <link href="{{ asset('css/scheduler/dhtmlxscheduler_material.css') }}?v=5.3.12" rel="stylesheet">
    <style>
        html, body{
            margin:0px;
            padding:0px;
            height:100%;
        }
        .dhx_agenda_line div{
            width: 300px;
        }
        .dhx_v_border{
            left: 299px;
        }
        .dhx_cal_event div.dhx_event_resize.dhx_footer {
            background-color: transparent !important;
        }
        .agendasearch {
            height:30px;
        }
        .agenda_tab {
            left:0 !important;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.events.show')</h3>

            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/admin/events/search" method="POST">
                                @csrf
                                <input id="search" type="text" name="search" class="agendasearch" placeholder="suche ...">
                                {!! Form::submit(trans('quickadmin.search'), ['class' => 'btn btn-warning']) !!}
                            </form>

                            <div id="scheduler_here" class="dhx_cal_container panel" style='height:2000px; margin: 30px; margin-right: 100px;'>
                                <div class="dhx_cal_navline">
                                    <div class="dhx_cal_prev_button">&nbsp;</div>
                                    <div class="dhx_cal_next_button">&nbsp;</div>
                                    <div class="dhx_cal_today_button"></div>
                                    <div class="dhx_cal_tab" name="agenda_tab"></div>
                                </div>
                                <div class="dhx_cal_header"></div>
                                <div class="dhx_cal_data"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            scheduler.config.readonly = true;
            scheduler.date.agenda_start = function(date){
                return scheduler.date.month_start(new Date(date));
            };

            scheduler.date.add_agenda = function(date, inc){
                return scheduler.date.add(date, inc, "month");
            };

            scheduler.templates.agenda_text = function(start, end, event){
                return "<span style='font-size: 0.90em; color:" + event.agenda +";'><i class='fas fa-circle'></i></span> " + event.text;
            }

            const templates = scheduler.templates;
            scheduler.templates.agenda_time = function(start, end, event){

                if (scheduler.isOneDayEvent(event)) {
                    return templates.day_date(start) + " " + templates.event_date(start)+ " - "+ templates.day_date(end) + ' ' + templates.event_date(end);
                }
                else {
                    return templates.day_date(start) + " " + templates.event_date(start) + " &ndash; " + templates.day_date(end) + ' ' + templates.event_date(end);
                }
            };

            let format = scheduler.date.date_to_str("%H:%i");
            scheduler.config.multi_day = true;
            scheduler.config.first_hour = 0;
            scheduler.config.last_hour = 24;
            scheduler.setLoadMode("month");
            scheduler.init("scheduler_here", new Date(), "agenda");
            scheduler.load("/admin/api/eventdata?agenda=true&search={{$search}}", "json");
            scheduler.locale.labels.section_description = "Details";

        </script>


@stop
