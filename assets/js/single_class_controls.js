(function($) {
	$(document).ready(function() {
		/*
	Function for student to enroll in a class
	*/
		$(document).on('click', '.enroll-class', function () {
			var titleDashUidDashEnroll = $(this).attr('id');
			$.ajax({
				type: "POST",
				dataType: 'JSON',
				data: {
					action: 'call_enroll_class',
					titleDashUidDashEnroll: titleDashUidDashEnroll
				},
				beforeSend: function (response) {
					$('#loading').show()
				},
				success: function (response) {
					switch (response['r']) {
						case 'suffGrade':
							fail("You have already passed this class.");
							break;
						case 'tooMany':
							fail("You're already enrolled into four classes.");
							break;
						case 'full':
							fail("This class is full.");
							break;
						case 'failed':
							fail();
							break;
						case 'success':
							success();
							break;
						default:
							appBreak();
							break;
					}
				}
			}).done(function() {
				$('#loading').hide();
			});
		});

		/*
		Function for student to drop a class
		*/
		$(document).on('click', '.drop-class', function () {
			var titleDashUidDashWithdraw = $(this).attr('id');
			$.ajax({
				type: "POST",
				dataType: 'JSON',
				data: {
					action: 'call_drop_class',
					titleDashUidDashWithdraw: titleDashUidDashWithdraw
				},
				beforeSend: function () {
					$('#loading').show()
				},
				success: function (response) {
					switch (response['r']) {
						case 'failed':
							fail();
							break;
						case 'success':
							success();
							break;
						default:
							appBreak();
							break;
					}
				}
			}).done(function() {
				$('#loading').hide();
			});
		});


		/*
		Function for a student to waitlist into a class
		*/
		$(document).on('click', '.waitlist-class', function () {
			var titleDashUidDashWaitlist = $(this).attr('id');
			$.ajax({
				type: "POST",
				dataType: 'JSON',
				data: {
					action: 'call_waitlist_class',
					titleDashUidDashWaitlist: titleDashUidDashWaitlist
				},
				beforeSend: function (response) {
					$('#loading').show()
				},
				success: function (response) {
					switch (response['r']) {
						case 'failed':
							fail();
							break;
						case 'success':
							success();
							break;
						default:
							appBreak();
							break;
					}
				}
			}).done(function() {
				$('#loading').hide()
			});
		});

	})
})(jQuery);
