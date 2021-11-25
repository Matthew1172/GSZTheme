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