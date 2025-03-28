/*
@license
dhtmlxScheduler v.5.0.0 Professional

This software can be used only as part of dhtmlx.com site.
You are not allowed to use it on any other site

(c) XB Software.


*/
Scheduler.plugin(function(e) {
    e.config.occurrence_timestamp_in_utc = !1,
    e.config.recurring_workdays = [1, 2, 3, 4, 5],
    e.form_blocks.recurring = {
        _get_node: function(e) {
            return "string" == typeof e && (e = document.getElementById(e)), "none" == e.style.display && (e.style.display = ""), e
        },
        _outer_html: function(e) {
            function t(e) {
                var t,
                    a = document.createElement("div");
                return a.appendChild(e.cloneNode(!0)), t = a.innerHTML, a = null, t
            }
            return e.outerHTML || t(e)
        },
        render: function(t) {
            if (t.form) {
                var a = e.form_blocks.recurring,
                    n = a._get_node(t.form),
                    i = a._outer_html(n);
                return n.style.display = "none", i
            }
            return e.__recurring_template
        },
        _ds: {},
        _get_form_node: function(e, t, a) {
            var n = e[t];
            if (!n)
                return null;
            if (n.nodeName)
                return n;
            if (n.length)
                for (var i = 0; i < n.length; i++)
                    if (n[i].value == a)
                        return n[i]
        },
        _get_node_value: function(e, t, a) {
            var n = e[t];
            if (!n)
                return "";
            if (n.length) {
                if (a) {
                    for (var i = [], r = 0; r < n.length; r++)
                        n[r].checked && i.push(n[r].value);
                    return i
                }
                for (var r = 0; r < n.length; r++)
                    if (n[r].checked)
                        return n[r].value
            }
            return n.value ? a ? [n.value] : n.value : void 0
        },
        _get_node_numeric_value: function(t, a) {
            var n = e.form_blocks.recurring._get_node_value(t, a);
            return 1 * n || 0
        },
        _set_node_value: function(e, t, a) {
            var n = e[t];
            if (n)
                if (n.name == t)
                    n.value = a;
                else if (n.length)
                    for (var i = "object" == typeof a, r = 0; r < n.length; r++)
                        (i || n[r].value == a) && (n[r].checked = i ? !!a[n[r].value] : !!a)
        },
        _init_set_value: function(t, a, n) {
            function i(e) {
                for (var t = 0; t < e.length; t++) {
                    var a = e[t];
                    if (a.name)
                        if (g[a.name])
                            if (g[a.name].nodeType) {
                                var n = g[a.name];
                                g[a.name] = [n, a]
                            } else
                                g[a.name].push(a);
                        else
                            g[a.name] = a
                }
            }
            function r() {
                b("dhx_repeat_day").style.display = "none",
                b("dhx_repeat_week").style.display = "none",
                b("dhx_repeat_month").style.display = "none",
                b("dhx_repeat_year").style.display = "none",
                b("dhx_repeat_" + this.value).style.display = "block",
                e.setLightboxSize()
            }
            function o(t) {
                var a = [c(g, "repeat")];
                for (y[a[0]](a, t); a.length < 5;)
                    a.push("");
                var n = "",
                    i = d(g);
                if ("no" == i)
                    t.end = new Date(9999, 1, 1),
                    n = "no";
                else if ("date_of_end" == i)
                    t.end = p(c(g, "date_of_end"));
                else {
                    e.transpose_type(a.join("_")),
                    n = Math.max(1, c(g, "occurences_count"));
                    var r = 0;
                    t.end = e.date.add(new Date(t.start), n + r, a.join("_"));
                }
                return a.join("_") + "#" + n
            }
            function d(e) {
                var t = e.end;
                if (t.length) {
                    for (var a = 0; a < t.length; a++)
                        if (t[a].checked)
                            return t[a].value && "on" != t[a].value ? t[a].value : a ? 2 == a ? "date_of_end" : "occurences_count" : "no"
                } else if (t.value)
                    return t.value;
                return "no"
            }
            function l(e, t) {
                var a = e.end;
                if (a.length) {
                    var n = !!a[0].value && "on" != a[0].value;
                    if (n)
                        for (var i = 0; i < a.length; i++)
                            a[i].value == t && (a[i].checked = !0);
                    else {
                        var r = 0;
                        switch (t) {
                        case "no":
                            r = 0;
                            break;
                        case "date_of_end":
                            r = 2;
                            break;
                        default:
                            r = 1
                        }
                        a[r].checked = !0
                    }
                } else
                    a.value = t
            }
            function s(t, a) {
                var n = e.form_blocks.recurring._set_node_value,
                    i = t.split("#");
                switch (t = i[0].split("_"), x[t[0]](t, a), i[1]) {
                case "no":
                    l(g, "no");
                    break;
                case "":
                    l(g, "date_of_end");
                    var r = a.end;
                    e.config.include_end_by && (r = e.date.add(r, -1, "day")),
                    n(g, "date_of_end", v(r));
                    break;
                default:
                    l(g, "occurences_count"),
                    n(g, "occurences_count", i[1])
                }
                n(g, "repeat", t[0]);
                var o = e.form_blocks.recurring._get_form_node(g, "repeat", t[0]);
                "SELECT" == o.nodeName && o.onchange ? o.onchange() : o.onclick && o.onclick()
            }
            var _ = e.form_blocks.recurring,
                c = _._get_node_value,
                u = _._set_node_value;
            e.form_blocks.recurring._ds = {
                start: n.start_date,
                end: n._end_date
            };
            var h = e.date.str_to_date(e.config.repeat_date),
                p = function(t) {
                    var a = h(t);
                    return e.config.include_end_by && (a = e.date.add(a, 1, "day")), a
                },
                v = e.date.date_to_str(e.config.repeat_date),
                m = t.getElementsByTagName("FORM")[0],
                g = {};
            if (i(m.getElementsByTagName("INPUT")), i(m.getElementsByTagName("SELECT")), !e.config.repeat_date_of_end) {
                var f = e.date.date_to_str(e.config.repeat_date);
                e.config.repeat_date_of_end = f(e.date.add(e._currentDate(), 30, "day"));
            }
            u(g, "date_of_end", e.config.repeat_date_of_end);
            var b = function(e) {
                return document.getElementById(e) || {
                        style: {}
                    }
            };
            e.form_blocks.recurring._get_repeat_code = o;
            var y = {
                    month: function(t, a) {
                        var n = e.form_blocks.recurring._get_node_value,
                            i = e.form_blocks.recurring._get_node_numeric_value;
                        "d" == n(g, "month_type") ? (t.push(Math.max(1, i(g, "month_count"))), a.start.setDate(n(g, "month_day"))) : (t.push(Math.max(1, i(g, "month_count2"))), t.push(n(g, "month_day2")), t.push(Math.max(1, i(g, "month_week2"))), e.config.repeat_precise || a.start.setDate(1)),
                        a._start = !0
                    },
                    week: function(t, a) {
                        var n = e.form_blocks.recurring._get_node_value,
                            i = e.form_blocks.recurring._get_node_numeric_value;
                        t.push(Math.max(1, i(g, "week_count"))),
                        t.push(""),
                        t.push("");
                        for (var r = [], o = n(g, "week_day", !0), d = a.start.getDay(), l = !1, s = 0; s < o.length; s++)
                            r.push(o[s]),
                            l = l || o[s] == d;
                        r.length || (r.push(d), l = !0),
                        r.sort(),
                        e.config.repeat_precise ? l || (e.transpose_day_week(a.start, r, 1, 7), a._start = !0) : (a.start = e.date.week_start(a.start), a._start = !0),
                        t.push(r.join(","))
                    },
                    day: function(t) {
                        var a = e.form_blocks.recurring._get_node_value,
                            n = e.form_blocks.recurring._get_node_numeric_value;
                        "d" == a(g, "day_type") ? t.push(Math.max(1, n(g, "day_count"))) : (t.push("week"), t.push(1), t.push(""), t.push(""), t.push(e.config.recurring_workdays.join(",")), t.splice(0, 1))
                    },
                    year: function(t, a) {
                        var n = e.form_blocks.recurring._get_node_value;
                        "d" == n(g, "year_type") ? (t.push("1"), a.start.setMonth(0), a.start.setDate(n(g, "year_day")), a.start.setMonth(n(g, "year_month"))) : (t.push("1"), t.push(n(g, "year_day2")), t.push(n(g, "year_week2")), a.start.setDate(1), a.start.setMonth(n(g, "year_month2"))),
                        a._start = !0
                    }
                },
                x = {
                    week: function(t, a) {
                        var n = e.form_blocks.recurring._set_node_value;
                        n(g, "week_count", t[1]);
                        for (var i = t[4].split(","), r = {}, o = 0; o < i.length; o++)
                            r[i[o]] = !0;
                        n(g, "week_day", r)
                    },
                    month: function(t, a) {
                        var n = e.form_blocks.recurring._set_node_value;
                        "" === t[2] ? (n(g, "month_type", "d"), n(g, "month_count", t[1]), n(g, "month_day", a.start.getDate())) : (n(g, "month_type", "w"), n(g, "month_count2", t[1]), n(g, "month_week2", t[3]), n(g, "month_day2", t[2]))
                    },
                    day: function(t, a) {
                        var n = e.form_blocks.recurring._set_node_value;
                        n(g, "day_type", "d"),
                        n(g, "day_count", t[1]);
                    },
                    year: function(t, a) {
                        var n = e.form_blocks.recurring._set_node_value;
                        "" === t[2] ? (n(g, "year_type", "d"), n(g, "year_day", a.start.getDate()), n(g, "year_month", a.start.getMonth())) : (n(g, "year_type", "w"), n(g, "year_week2", t[3]), n(g, "year_day2", t[2]), n(g, "year_month2", a.start.getMonth()))
                    }
                };
            e.form_blocks.recurring._set_repeat_code = s;
            for (var k = 0; k < m.elements.length; k++) {
                var w = m.elements[k];
                switch (w.name) {
                case "repeat":
                    "SELECT" == w.nodeName ? w.onchange = r : w.onclick = r
                }
            }
            e._lightbox._rec_init_done = !0
        },
        set_value: function(t, a, n) {
            var i = e.form_blocks.recurring;
            e._lightbox._rec_init_done || i._init_set_value(t, a, n),
            t.open = !n.rec_type,
            t.blocked = this._is_modified_occurence(n);
            var r = i._ds;
            r.start = n.start_date,
            r.end = n._end_date,
            i._toggle_block(),
            a && i._set_repeat_code(a, r)
        },
        get_value: function(t, a) {
            if (t.open) {
                var n = e.form_blocks.recurring._ds,
                    i = {};
                this.formSection("time").getValue(i),
                n.start = i.start_date,
                a.rec_type = e.form_blocks.recurring._get_repeat_code(n),
                n._start ? (a.start_date = new Date(n.start), a._start_date = new Date(n.start), n._start = !1) : a._start_date = null,
                a._end_date = n.end,
                a.rec_pattern = a.rec_type.split("#")[0]
            } else
                a.rec_type = a.rec_pattern = "",
                a._end_date = a.end_date;
            return a.rec_type
        },
        _get_button: function() {
            var t = e.formSection("recurring").header;
            return t.firstChild.firstChild
        },
        _get_form: function() {
            return e.formSection("recurring").node
        },
        open: function() {
            var t = e.form_blocks.recurring,
                a = t._get_form();
            a.open || t._toggle_block()
        },
        close: function() {
            var t = e.form_blocks.recurring,
                a = t._get_form();
            a.open && t._toggle_block()
        },
        _toggle_block: function() {
            var t = e.form_blocks.recurring,
                a = t._get_form(),
                n = t._get_button();
            a.open || a.blocked ? (a.style.height = "0px", n && (n.style.backgroundPosition = "-5px 20px", n.nextSibling.innerHTML = e.locale.labels.button_recurring)) : (a.style.height = "auto", n && (n.style.backgroundPosition = "-5px 0px", n.nextSibling.innerHTML = e.locale.labels.button_recurring_open)),
            a.open = !a.open,
            e.setLightboxSize()
        },
        focus: function(e) {},
        button_click: function(t, a, n, i) {
            var r = e.form_blocks.recurring,
                i = r._get_form();
            i.blocked || e.form_blocks.recurring._toggle_block()
        }
    },
    e._rec_markers = {},
    e._rec_markers_pull = {},
    e._add_rec_marker = function(e, t) {
        e._pid_time = t,
        this._rec_markers[e.id] = e,
        this._rec_markers_pull[e.event_pid] || (this._rec_markers_pull[e.event_pid] = {}),
        this._rec_markers_pull[e.event_pid][t] = e
    },
    e._get_rec_marker = function(e, t) {
        var a = this._rec_markers_pull[t];
        return a ? a[e] : null
    },
    e._get_rec_markers = function(e) {
        return this._rec_markers_pull[e] || []
    },
    e._rec_temp = [],
    function() {
        var t = e.addEvent;
        e.addEvent = function(a, n, i, r, o) {
            var d = t.apply(this, arguments);
            if (d && e.getEvent(d)) {
                var l = e.getEvent(d);
                this._is_modified_occurence(l) && e._add_rec_marker(l, 1e3 * l.event_length),
                l.rec_type && (l.rec_pattern = l.rec_type.split("#")[0])
            }
            return d
        }
    }(),
    e.attachEvent("onEventIdChange", function(t, a) {
        if (!this._ignore_call) {
            this._ignore_call = !0,
            e._rec_markers[t] && (e._rec_markers[a] = e._rec_markers[t], delete e._rec_markers[t]),
            e._rec_markers_pull[t] && (e._rec_markers_pull[a] = e._rec_markers_pull[t], delete e._rec_markers_pull[t]);
            for (var n = 0; n < this._rec_temp.length; n++) {
                var i = this._rec_temp[n];
                i.event_pid == t && (i.event_pid = a, this.changeEventId(i.id, a + "#" + i.id.split("#")[1]))
            }
            for (var n in this._rec_markers) {
                var i = this._rec_markers[n];
                i.event_pid == t && (i.event_pid = a, i._pid_changed = !0)
            }
            var r = e._rec_markers[a];
            r && r._pid_changed && (delete r._pid_changed, setTimeout(function() {
                e.callEvent("onEventChanged", [a, e.getEvent(a)])
            }, 1)),
            delete this._ignore_call
        }
    }),
    e.attachEvent("onConfirmedBeforeEventDelete", function(e) {
        var t = this.getEvent(e);
        if (this._is_virtual_event(e) || this._is_modified_occurence(t) && t.rec_type && "none" != t.rec_type) {
            e = e.split("#");
            var a = this.uid(),
                n = e[1] ? e[1] : t._pid_time / 1e3,
                i = this._copy_event(t);
            i.id = a,
            i.event_pid = t.event_pid || e[0];
            var r = n;
            i.event_length = r,
            i.rec_type = i.rec_pattern = "none",
            this.addEvent(i),
            this._add_rec_marker(i, 1e3 * r)
        } else {
            t.rec_type && this._lightbox_id && this._roll_back_dates(t);
            var o = this._get_rec_markers(e);
            for (var d in o)
                o.hasOwnProperty(d) && (e = o[d].id, this.getEvent(e) && this.deleteEvent(e, !0))
        }
        return !0
    }),
    e.attachEvent("onEventDeleted", function(t, a) {
        !this._is_virtual_event(t) && this._is_modified_occurence(a) && (e._events[t] || (a.rec_type = a.rec_pattern = "none", this.setEvent(t, a)));
    }),
    e.attachEvent("onEventChanged", function(e, t) {
        if (this._loading)
            return !0;
        var a = this.getEvent(e);
        if (this._is_virtual_event(e)) {
            var e = e.split("#"),
                n = this.uid();
            this._not_render = !0;
            var i = this._copy_event(t);
            i.id = n,
            i.event_pid = e[0];
            var r = e[1];
            i.event_length = r,
            i.rec_type = i.rec_pattern = "",
            this._add_rec_marker(i, 1e3 * r),
            this.addEvent(i),
            this._not_render = !1
        } else {
            a.rec_type && this._lightbox_id && this._roll_back_dates(a);
            var o = this._get_rec_markers(e);
            for (var d in o)
                o.hasOwnProperty(d) && (delete this._rec_markers[o[d].id],
                this.deleteEvent(o[d].id, !0));
            delete this._rec_markers_pull[e];
            for (var l = !1, s = 0; s < this._rendered.length; s++)
                this._rendered[s].getAttribute("event_id") == e && (l = !0);
            l || (this._select_id = null)
        }
        return !0
    }),
    e.attachEvent("onEventAdded", function(e) {
        if (!this._loading) {
            var t = this.getEvent(e);
            t.rec_type && !t.event_length && this._roll_back_dates(t)
        }
        return !0
    }),
    e.attachEvent("onEventSave", function(e, t, a) {
        var n = this.getEvent(e);
        return n.rec_type || !t.rec_type || this._is_virtual_event(e) || (this._select_id = null), !0
    }),
    e.attachEvent("onEventCreated", function(e) {
        var t = this.getEvent(e);
        return t.rec_type || (t.rec_type = t.rec_pattern = t.event_length = t.event_pid = ""), !0
    }),
    e.attachEvent("onEventCancel", function(e) {
        var t = this.getEvent(e);
        t.rec_type && (this._roll_back_dates(t), this.render_view_data())
    }),
    e._roll_back_dates = function(e) {
        e.event_length = (e.end_date.valueOf() - e.start_date.valueOf()) / 1e3,
        e.end_date = e._end_date,
        e._start_date && (e.start_date.setMonth(0), e.start_date.setDate(e._start_date.getDate()), e.start_date.setMonth(e._start_date.getMonth()),
        e.start_date.setFullYear(e._start_date.getFullYear()))
    },
    e._is_virtual_event = function(e) {
        return -1 != e.toString().indexOf("#")
    },
    e._is_modified_occurence = function(e) {
        return e.event_pid && "0" != e.event_pid
    },
    e._validId = function(e) {
        return !this._is_virtual_event(e)
    },
    e.showLightbox_rec = e.showLightbox,
    e.showLightbox = function(t) {
        var a = this.locale,
            n = e.config.lightbox_recurring,
            i = this.getEvent(t),
            r = i.event_pid,
            o = this._is_virtual_event(t);
        o && (r = t.split("#")[0]);
        var d = function(t) {
            var a = e.getEvent(t);
            return a._end_date = a.end_date,
            a.end_date = new Date(a.start_date.valueOf() + 1e3 * a.event_length), e.showLightbox_rec(t)
        };
        if ((r || 1 * r === 0) && i.rec_type)
            return d(t);
        if (!r || "0" === r || !a.labels.confirm_recurring || "instance" == n || "series" == n && !o)
            return this.showLightbox_rec(t);
        if ("ask" == n) {
            var l = this;
            dhtmlx.modalbox({
                text: a.labels.confirm_recurring,
                title: a.labels.title_confirm_recurring,
                width: "500px",
                position: "middle",
                buttons: [a.labels.button_edit_series, a.labels.button_edit_occurrence, a.labels.icon_cancel],
                callback: function(e) {
                    switch (+e) {
                    case 0:
                        return d(r);
                    case 1:
                        return l.showLightbox_rec(t);
                    case 2:
                        return
                    }
                }
            })
        } else
            d(r)
    },
    e.get_visible_events_rec = e.get_visible_events,
    e.get_visible_events = function(e) {
        for (var t = 0; t < this._rec_temp.length; t++)
            delete this._events[this._rec_temp[t].id];
        this._rec_temp = [];
        for (var a = this.get_visible_events_rec(e), n = [], t = 0; t < a.length; t++)
            a[t].rec_type ? "none" != a[t].rec_pattern && this.repeat_date(a[t], n) : n.push(a[t]);
        return n
    },
    function() {
        var t = e.isOneDayEvent;
        e.isOneDayEvent = function(e) {
            return e.rec_type ? !0 : t.call(this, e);
        };
        var a = e.updateEvent;
        e.updateEvent = function(t) {
            var n = e.getEvent(t);
            n && n.rec_type && (n.rec_pattern = (n.rec_type || "").split("#")[0]),
            n && n.rec_type && !this._is_virtual_event(t) ? e.update_view() : a.call(this, t)
        }
    }(),
    e.transponse_size = {
        day: 1,
        week: 7,
        month: 1,
        year: 12
    },
    e.date.day_week = function(e, t, a) {
        e.setDate(1),
        a = 7 * (a - 1);
        var n = e.getDay(),
            i = 1 * t + a - n + 1;
        e.setDate(a >= i ? i + 7 : i)
    },
    e.transpose_day_week = function(t, a, n, i, r) {
        for (var o = (t.getDay() || (e.config.start_on_monday ? 7 : 0)) - n, d = 0; d < a.length; d++)
            if (a[d] > o)
                return t.setDate(t.getDate() + 1 * a[d] - o - (i ? n : r));
        this.transpose_day_week(t, a, n + i, null, n)
    },
    e.transpose_type = function(t) {
        var a = "transpose_" + t;
        if (!this.date[a]) {
            var n = t.split("_"),
                i = 864e5,
                r = "add_" + t,
                o = this.transponse_size[n[0]] * n[1];
            if ("day" == n[0] || "week" == n[0]) {
                var d = null;
                if (n[4] && (d = n[4].split(","), e.config.start_on_monday)) {
                    for (var l = 0; l < d.length; l++)
                        d[l] = 1 * d[l] || 7;
                    d.sort()
                }
                this.date[a] = function(t, a) {
                    var n = Math.floor((a.valueOf() - t.valueOf()) / (i * o));
                    n > 0 && t.setDate(t.getDate() + n * o),
                    d && e.transpose_day_week(t, d, 1, o)
                },
                this.date[r] = function(t, a) {
                    var n = new Date(t.valueOf());
                    if (d)
                        for (var i = 0; a > i; i++)
                            e.transpose_day_week(n, d, 0, o);
                    else
                        n.setDate(n.getDate() + a * o);
                    return n
                }
            } else
                ("month" == n[0] || "year" == n[0]) && (this.date[a] = function(t, a) {
                    var i = Math.ceil((12 * a.getFullYear() + 1 * a.getMonth() + 1 - (12 * t.getFullYear() + 1 * t.getMonth() + 1)) / o - 1);
                    i >= 0 && t.setMonth(t.getMonth() + i * o),
                    n[3] && e.date.day_week(t, n[2], n[3])
                }, this.date[r] = function(t, a) {
                    var i = new Date(t.valueOf());
                    return i.setMonth(i.getMonth() + a * o), n[3] && e.date.day_week(i, n[2], n[3]), i
                })
        }
    },
    e.repeat_date = function(t, a, n, i, r, o) {
        i = i || this._min_date,
        r = r || this._max_date;
        var d = o || -1,
            l = new Date(t.start_date.valueOf()),
            s = l.getHours(),
            _ = 0;
        for (!t.rec_pattern && t.rec_type && (t.rec_pattern = t.rec_type.split("#")[0]), this.transpose_type(t.rec_pattern), e.date["transpose_" + t.rec_pattern](l, i); l < t.start_date || e._fix_daylight_saving_date(l, i, t, l, new Date(l.valueOf() + 1e3 * t.event_length)).valueOf() <= i.valueOf() || l.valueOf() + 1e3 * t.event_length <= i.valueOf();)
            l = this.date.add(l, 1, t.rec_pattern);
        for (; r > l && l < t.end_date && (0 > d || d > _);) {
            l.setHours(s);
            var c = e.config.occurrence_timestamp_in_utc ? Date.UTC(l.getFullYear(), l.getMonth(), l.getDate(), l.getHours(), l.getMinutes(), l.getSeconds()) : l.valueOf(),
                u = this._get_rec_marker(c, t.id);
            if (u)
                n && ("none" != u.rec_type && _++, a.push(u));
            else {
                var h = new Date(l.valueOf() + 1e3 * t.event_length),
                    p = this._copy_event(t);
                if (p.text = t.text, p.start_date = l, p.event_pid = t.id, p.id = t.id + "#" + Math.ceil(c / 1e3), p.end_date = h, p.end_date = e._fix_daylight_saving_date(p.start_date, p.end_date, t, l, p.end_date), p._timed = this.isOneDayEvent(p), !p._timed && !this._table_view && !this.config.multi_day)
                    return;
                a.push(p),
                n || (this._events[p.id] = p, this._rec_temp.push(p)),
                _++
            }
            l = this.date.add(l, 1, t.rec_pattern)
        }
    },
    e._fix_daylight_saving_date = function(e, t, a, n, i) {
        var r = e.getTimezoneOffset() - t.getTimezoneOffset();
        return r ? r > 0 ? new Date(n.valueOf() + 1e3 * a.event_length - 60 * r * 1e3) : new Date(t.valueOf() - 60 * r * 1e3) : new Date(i.valueOf())
    },
    e.getRecDates = function(t, a) {
        var n = "object" == typeof t ? t : e.getEvent(t),
            i = [];
        if (a = a || 100, !n.rec_type)
            return [{
                start_date: n.start_date,
                end_date: n.end_date
            }];
        if ("none" == n.rec_type)
            return [];
        e.repeat_date(n, i, !0, n.start_date, n.end_date, a);
        for (var r = [], o = 0; o < i.length; o++)
            "none" != i[o].rec_type && r.push({
                start_date: i[o].start_date,
                end_date: i[o].end_date
            });
        return r
    },
    e.getEvents = function(e, t) {
        var a = [];
        for (var n in this._events) {
            var i = this._events[n];
            if (i && i.start_date < t && i.end_date > e)
                if (i.rec_pattern) {
                    if ("none" == i.rec_pattern)
                        continue;
                    var r = [];
                    this.repeat_date(i, r, !0, e, t);
                    for (var o = 0; o < r.length; o++)
                        !r[o].rec_pattern && r[o].start_date < t && r[o].end_date > e && !this._rec_markers[r[o].id] && a.push(r[o])
                } else
                    this._is_virtual_event(i.id) || a.push(i)
        }
        return a
    },
    e.config.repeat_date = "%m.%d.%Y",
    e.config.lightbox.sections = [{
        name: "description",
        map_to: "text",
        type: "textarea",
        focus: !0
    }, {
        name: "recurring",
        type: "recurring",
        map_to: "rec_type",
        button: "recurring"
    }, {
        name: "time",
        height: 72,
        type: "time",
        map_to: "auto"
    }],
    e._copy_dummy = function(e) {
        var t = new Date(this.start_date),
            a = new Date(this.end_date);
        this.start_date = t,
        this.end_date = a,
        this.event_length = this.event_pid = this.rec_pattern = this.rec_type = null
    },
    e.config.include_end_by = !1,
    e.config.lightbox_recurring = "ask",
    e.attachEvent("onClearAll", function() {
        e._rec_markers = {},
        e._rec_markers_pull = {},
        e._rec_temp = []
    }),
    e.__recurring_template = '<div class="dhx_form_repeat"> <form> <div class="dhx_repeat_left"> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="day" />Daily</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="week"/>Weekly</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="month" checked />Monthly</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="year" />Yearly</label> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_center"> <div style="display:none;" id="dhx_repeat_day"> <label><input class="dhx_repeat_radio" type="radio" name="day_type" value="d"/>Every</label><input class="dhx_repeat_text" type="text" name="day_count" value="1" />day<br /> <label><input class="dhx_repeat_radio" type="radio" name="day_type" checked value="w"/>Every workday</label> </div> <div style="display:none;" id="dhx_repeat_week"> Repeat every<input class="dhx_repeat_text" type="text" name="week_count" value="1" />week next days:<br /> <table class="dhx_repeat_days"> <tr> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="1" />Monday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="4" />Thursday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="2" />Tuesday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="5" />Friday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="3" />Wednesday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="6" />Saturday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="0" />Sunday</label><br /><br /> </td> </tr> </table> </div> <div id="dhx_repeat_month"> <label><input class="dhx_repeat_radio" type="radio" name="month_type" value="d"/>Repeat</label><input class="dhx_repeat_text" type="text" name="month_day" value="1" />day every<input class="dhx_repeat_text" type="text" name="month_count" value="1" />month<br /> <label><input class="dhx_repeat_radio" type="radio" name="month_type" checked value="w"/>On</label><input class="dhx_repeat_text" type="text" name="month_week2" value="1" /><select name="month_day2"><option value="1" selected >Monday<option value="2">Tuesday<option value="3">Wednesday<option value="4">Thursday<option value="5">Friday<option value="6">Saturday<option value="0">Sunday</select>every<input class="dhx_repeat_text" type="text" name="month_count2" value="1" />month<br /> </div> <div style="display:none;" id="dhx_repeat_year"> <label><input class="dhx_repeat_radio" type="radio" name="year_type" value="d"/>Every</label><input class="dhx_repeat_text" type="text" name="year_day" value="1" />day<select name="year_month"><option value="0" selected >January<option value="1">February<option value="2">March<option value="3">April<option value="4">May<option value="5">June<option value="6">July<option value="7">August<option value="8">September<option value="9">October<option value="10">November<option value="11">December</select>month<br /> <label><input class="dhx_repeat_radio" type="radio" name="year_type" checked value="w"/>On</label><input class="dhx_repeat_text" type="text" name="year_week2" value="1" /><select name="year_day2"><option value="1" selected >Monday<option value="2">Tuesday<option value="3">Wednesday<option value="4">Thursday<option value="5">Friday<option value="6">Saturday<option value="7">Sunday</select>of<select name="year_month2"><option value="0" selected >January<option value="1">February<option value="2">March<option value="3">April<option value="4">May<option value="5">June<option value="6">July<option value="7">August<option value="8">September<option value="9">October<option value="10">November<option value="11">December</select><br /> </div> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_right"> <label><input class="dhx_repeat_radio" type="radio" name="end" checked/>No end date</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />After</label><input class="dhx_repeat_text" type="text" name="occurences_count" value="1" />occurrences<br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />End by</label><input class="dhx_repeat_date" type="text" name="date_of_end" value="' + e.config.repeat_date_of_end + '" /><br /> </div> </form> </div> <div style="clear:both"> </div>';
});
//# sourceMappingURL=../sources/ext/dhtmlxscheduler_recurring.js.map

