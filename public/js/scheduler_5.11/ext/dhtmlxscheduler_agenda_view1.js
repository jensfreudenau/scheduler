/*

@license
dhtmlxScheduler v.5.3.11 Professional

This software can be used only as part of dhtmlx.com site.
You are not allowed to use it on any other site

(c) XB Software Ltd.

*/
Scheduler.plugin(function(t){t.date.add_agenda=function(e){return t.date.add(e,1,"year")},t.templates.agenda_time=function(e,i,a){return a._timed?this.day_date(a.start_date,a.end_date,a)+" "+this.event_date(e):t.templates.day_date(e)+" &ndash; "+t.templates.day_date(i)},t.templates.agenda_text=function(t,e,i){return i.text},t.templates.agenda_date=function(){return""},t.date.agenda_start=function(){return t.date.date_part(t._currentDate())},t.attachEvent("onTemplatesReady",function(){
    function e(e){if(e){var i=t.locale.labels,a=t._waiAria.agendaHeadAttrString(),n=t._waiAria.agendaHeadDateString(i.date),r=t._waiAria.agendaHeadDescriptionString(i.description);t._els.dhx_cal_header[0].innerHTML="<div "+a+" class='dhx_agenda_line'><div "+n+">"+i.date+"</div><span class = 'description_header' style='padding-left:25px' "+r+">"+i.description+"</span></div>",t._table_view=!0,t.set_sizes()}}function i(){var e=(t._date,t.get_visible_events());e.sort(function(t,e){
        return t.start_date>e.start_date?1:-1});for(var i,a=t._waiAria.agendaDataAttrString(),n="<div class='dhx_agenda_area' "+a+">",r=0;r<e.length;r++){var s=e[r],o=s.color?"background:"+s.color+";":"",d=s.textColor?"color:"+s.textColor+";":"",l=t.templates.event_class(s.start_date,s.end_date,s);i=t._waiAria.agendaEventAttrString(s);var _=t._waiAria.agendaDetailsBtnString()
    ;n+="<div "+i+" class='dhx_agenda_line"+(l?" "+l:"")+"' event_id='"+s.id+"' style='"+d+o+(s._text_style||"")+"'><div class='dhx_agenda_event_time'>"+(t.config.rtl?t.templates.agenda_time(s.end_date,s.start_date,s):t.templates.agenda_time(s.start_date,s.end_date,s))+"</div>",n+="<div "+_+" class='dhx_event_icon icon_details'>&nbsp;</div>",n+="<span>"+t.templates.agenda_text(s.start_date,s.end_date,s)+"</span></div>"}n+="<div class='dhx_v_border'></div></div>",t._els.dhx_cal_data[0].innerHTML=n,
        t._els.dhx_cal_data[0].childNodes[0].scrollTop=t._agendaScrollTop||0;var h=t._els.dhx_cal_data[0].childNodes[0];h.childNodes[h.childNodes.length-1].style.height=h.offsetHeight<t._els.dhx_cal_data[0].offsetHeight?"100%":h.offsetHeight+"px";var c=t._els.dhx_cal_data[0].firstChild.childNodes,u=t._getNavDateElement();u&&(u.innerHTML=t.templates.agenda_date(t._min_date,t._max_date,t._mode)),t._rendered=[];for(var r=0;r<c.length-1;r++)t._rendered[r]=c[r]}var a=t.dblclick_dhx_cal_data
    ;t.dblclick_dhx_cal_data=function(){if("agenda"==this._mode)!this.config.readonly&&this.config.dblclick_create&&this.addEventNow();else if(a)return a.apply(this,arguments)};var n=t.render_data;t.render_data=function(t){if("agenda"!=this._mode)return n.apply(this,arguments);i()};var r=t.render_view_data;t.render_view_data=function(){return"agenda"==this._mode&&(t._agendaScrollTop=t._els.dhx_cal_data[0].childNodes[0].scrollTop,t._els.dhx_cal_data[0].childNodes[0].scrollTop=0),
        r.apply(this,arguments)},t.agenda_view=function(a){t._min_date=t.config.agenda_start||t.date.agenda_start(t._date),t._max_date=t.config.agenda_end||t.date.add_agenda(t._min_date,1),e(a),a?(t._cols=null,t._colsS=null,t._table_view=!0,i()):t._table_view=!1}})});
