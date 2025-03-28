/*

@license
dhtmlxScheduler v.5.3.12 Standard

To use dhtmlxScheduler in non-GPL projects (and get Pro version of the product), please obtain Commercial/Enterprise or Ultimate license on our site https://dhtmlx.com/docs/products/dhtmlxScheduler/#licensing or contact us at sales@dhtmlx.com

(c) XB Software Ltd.

*/
Scheduler.plugin(function(scheduler){scheduler.locale = {
	date: {
		month_full: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
		month_short: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
		day_full: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
		day_short: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"]
	},
	labels: {
		dhx_cal_today_button: "Hari Ini",
		day_tab: "Hari",
		week_tab: "Minggu",
		month_tab: "Bulan",
		new_event: "Acara Baru",
		icon_save: "Simpan",
		icon_cancel: "Batal",
		icon_details: "Detail",
		icon_edit: "Edit",
		icon_delete: "Hapus",
		confirm_closing: "", /*Perubahan tidak akan disimpan ?*/
		confirm_deleting: "Acara akan dihapus",
		section_description: "Keterangan",
		section_time: "Periode",
		full_day: "Hari penuh",

		/*recurring events*/
		confirm_recurring: "Apakah acara ini akan berulang?",
		section_recurring: "Acara Rutin",
		button_recurring: "Tidak Difungsikan",
		button_recurring_open: "Difungsikan",
		button_edit_series: "Mengedit seri",
		button_edit_occurrence: "Mengedit salinan",

		/*agenda view extension*/
		agenda_tab: "Agenda",
		date: "Tanggal",
		description: "Keterangan",

		/*year view extension*/
		year_tab: "Tahun",

		/*week agenda view extension*/
		week_agenda_tab: "Agenda",

		/*grid view extension*/
		grid_tab: "Tabel",

		/* touch tooltip*/
		drag_to_create:"Drag to create",
		drag_to_move:"Drag to move",

		/* dhtmlx message default buttons */
		message_ok:"OK",
		message_cancel:"Cancel",

		/* wai aria labels for non-text controls */
		next: "Next",
		prev: "Previous",
		year: "Year",
		month: "Month",
		day: "Day",
		hour:"Hour",
		minute: "Minute"
	}
};});