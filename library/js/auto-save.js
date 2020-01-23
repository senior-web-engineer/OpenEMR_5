$(function() {
	var form = $(FORM_SELECTOR);
	var url = form.attr('action');

	//Save form data if it's changed
	setInterval(function() {
		if (!AUTOSAVE) {
			return;
		}

		AUTOSAVE = false;

		$.ajax({
			url: url,
			type: 'post',
			data: form.serialize(),
			success: function(data) {
				$.toast({
					heading: 'Success',
					text: 'Data was automatically saved, interval time is ' + INTERVAL + ' mins',
					showHideTransition: 'slide',
					icon: 'success',
					position: 'top-right'
				});
			},
			error: function() {
				$.toast({
					heading: 'Opps!',
					text: 'It was occurred some issue while saving data. It will restart after' + INTERVAL + ' mins',
					showHideTransition: 'slide',
					icon: 'error',
					position: 'top-right'
				})
			}
		});
	}, INTERVAL*60*1000);


	//Check form is changed
	$(FORM_SELECTOR + " input," + FORM_SELECTOR + " select," + FORM_SELECTOR + " textarea").change(function () {
		AUTOSAVE = true;
	});
});