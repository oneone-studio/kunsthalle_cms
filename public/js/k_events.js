
function toggleEventRepeat(chk) {
	if(chk.checked) {
		$(".event_repeat_opt").prop('disabled', true).prop('checked', false);
		$("#event_day").prop('disabled', true).prop('selectedIndex', 0).trigger("chosen:updated");
		// $("#event_dates").prop('disabled', false);
	} else {
		$(".event_repeat_opt").prop('disabled', false);
		$("#event_day").prop('disabled', false).prop('selectedIndex', 0).trigger("chosen:updated");;
		$("#event_dates").prop('disabled', true);
		$('#event_date').val('');
		$('#single_dates').val('');
		// if($("#event_dates").val() == '') { $("#event_dates").prop('value', ''); }
	}
}

