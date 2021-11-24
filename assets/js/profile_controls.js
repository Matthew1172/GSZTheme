/*Student profile controls*/
(function ($) {
    $(document).ready(function () {
        /*
         *
         *Set the academic information tab on the student profile to be selected
         *
         */
        $("#defaultOpen").click();

        /*
         *
         *Change the dashboard based on window size. On mobile display the dropdown selector, on desktop show the buttons/tabs
         *
         */
        $(window).on('resize', function () {
            var win = $(this);
            if (win.width() > 1000) {
                $('#dashDrp').hide();
                $('#dashBtn').show();
            } else {
                $('#dashBtn').hide();
                $('#dashDrp').show();
            }
        });
		
        var win = $(this);
        if (win.width() > 1000) {
            $('#dashDrp').hide();
            $('#dashBtn').show();
        } else {
            $('#dashBtn').hide();
            $('#dashDrp').show();
        }
		
        /*
         *
         *Give the drop selector on the profile page control of opening tabs
         *
         */
        $('#drop-selector').on('change', function () {
            var selection = $(this).val();
            openPage(selection);
        });
		
		
		/*
         * send msg
         */
        $('#add-msg-form').submit(function (event) {
            event.preventDefault();
			var title = $('#msg-title').val();
			var type = $('#msg-type').val();
			var desc = get_tinymce_content('msg-desc');

			$.ajax({
				type: "POST",
				dataType: 'JSON',
				data: {
					action: 'call_add_msg',
					title: title,
					desc: desc,
					type: type
				},				
				beforeSend: function () {
					$('#loading').show()
				},
				success: function (response) {
					$("#msg-title").removeClass("input-error");
					switch (response['r']) {
						case 'empty':
							$("#msg-title").addClass("input-error");
							empty();
							break;
						case 'notValid':
							$('#msg-title').addClass('input-error');
							fail('Invalid fields.');
							break;
						case 'desc':
							fail('The description is too short.');
							break;
						case 'success':
							$('#msg-title').removeClass('input-error');
							success();
							break;
						default:
							fail(response['r']);
							//appBreak();
							break;
					}
				}
			}).done(function() {
				$('#loading').hide();
			});

        });
		
		/*
		Function to allow a waitlisted student into a class
		*/
		$(document).on('click', '.change-waitlist', function () {
            //event.preventDefault();
            var uidDashTitle = $(this).attr('id');
			var enrollment = $("#"+uidDashTitle+"-enrollment").val();
			$.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_change_waitlist',
                    uidDashTitle: uidDashTitle,
					enrollment: enrollment
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
		
		/*
		Function to assign a grade to a student in a class
		*/
		$(document).on('click', '.assign-grade', function () {
            //event.preventDefault();
            var uidDashTitle = $(this).attr('id');
			var grade = $("#"+uidDashTitle+"-grade").val();
			$.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_assign_grade',
                    uidDashTitle: uidDashTitle,
					grade: grade
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


        /* START AJAX USER ACCOUNT OPERATIONS */
        /**
         * send rem-acc
         */
        $("#delete-acc").submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_delete_acc',
                    delete: 'true'
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
                            window.location.assign(response['url']);
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
        /*
         *
         *Function to handle inputs when update-name is submitted
         *
         */
        $('#update-name').submit(function (event) {
            event.preventDefault();
            var fName = $('#reset-fName').val();
            var lName = $('#reset-lName').val();
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_update_name',
                    fName: fName,
                    lName: lName
                },
				beforeSend: function (response) {
					$('#loading').show()
                },
                success: function (response) {
                    switch (response['r']) {
                        case 'empty':
                            $('#reset-fName').addClass('input-error');
                            $('#reset-lName').addClass('input-error');
                            empty();
                            break;
                        case 'validF':
                            $('#reset-fName').addClass('input-error');
                            $('#reset-lName').addClass('input-error');
                            fail('This first name is not valid.');
                            break;
                        case 'validL':
                            $('#reset-fName').addClass('input-error');
                            $('#reset-lName').addClass('input-error');
                            fail('This last name is not valid.');
                            break;
                        case 'failed':
                            fail();
                            break;
                        case 'success':
                            $('#reset-fName, #reset-lName').removeClass('input-error');
                            $('.form-control').val('');
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

        /*
         *
         *Function to handle inputs when update-email is submitted
         *
         */
        $('#update-email').submit(function (event) {
            event.preventDefault();
            var email = $('#reset-email').val();
            var email2 = $('#reset-email2').val();
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_update_email',
                    email: email,
                    email2: email2
                },
				beforeSend: function (response) {
					$('#loading').show()
                },
                success: function (response) {
                    switch (response['r']) {
                        case 'empty':
                            $('#reset-email').addClass('input-error');
                            $('#reset-email2').addClass('input-error');
                            empty();
                            break;
                        case 'valid':
                            $('#reset-email').addClass('input-error');
                            $('#reset-email2').addClass('input-error');
                            fail('This email is not valid.');
                            break;
                        case 'match':
                            $('#reset-email').addClass('input-error');
                            $('#reset-email2').addClass('input-error');
                            fail('These emails do not match.');
                            break;
                        case 'failed':
                            fail();
                            break;
                        case 'taken':
                            $('#reset-email').addClass('input-error');
                            $('#reset-email2').addClass('input-error');
                            fail('This email is taken.');
                            break;
                        case 'success':
                            $('#reset-email, #reset-email2').removeClass('input-error');
                            $('.form-control').val('');
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
         *
         *Function to handle inputs when update-pw is submitted
         *
         */
        $('#update-pw').submit(function (event) {
            event.preventDefault();
            var pw = $('#reset-pw').val();
            var pw2 = $('#reset-pw2').val();
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                data: {
                    action: 'call_update_pw',
                    pw: pw,
                    pw2: pw2
                },				
				beforeSend: function (response) {
					$('#loading').show()
                },
                success: function (response) {
                    switch (response['r']) {
                        case 'empty':
                            $('#reset-pw').addClass('input-error');
                            $('#reset-pw2').addClass('input-error');
                            empty();
                            break;
                        case 'valid':
                            $('#reset-pw').addClass('input-error');
                            $('#reset-pw2').addClass('input-error');
                            fail('This password is not valid. (must be 8 characters)');
                            break;
                        case 'match':
                            $('#reset-pw').addClass('input-error');
                            $('#reset-pw2').addClass('input-error');
                            fail('These passwords do not match.');
                            break;
                        case 'failed':
                            fail();
                            break;
                        case 'success':
                            $('#reset-pw, #reset-pw2').removeClass('input-error');
                            $('.form-control').val('');
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

    });
})(jQuery);

/**
 * Function to create WYSIWYG editor on the html element
 * @param {html #id} id
 * @returns {unresolved} editor
 */
function get_tinymce_content(id) {
    var content;
	//wp.editor.initialize(id);
	var editor = tinymce.get(id);
    var textArea = jQuery('textarea#' + id);
    if (textArea.length > 0 && textArea.is(':visible')) {
        content = textArea.val();
    } else {
        content = editor.getContent();
    }
    return content;
}

/*
 *
 *Function to change tab styling
 *@param pageName: the id of the div to be shown
 *
 */
function openPage(pageName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        //tablinks[i].style.backgroundColor = "";
		tablinks[i].classList.remove('profile-btn-select');
    }
    document.getElementById(pageName).style.display = "block";
	
	//change value of drop selector to the value of the pageName
	var sel = document.getElementById('drop-selector');
	var opts = sel.options;
	for (var opt, j = 0; opt = opts[j]; j++) {
		if (opt.value == pageName) {
			sel.selectedIndex = j;
			break;
		}
	}
	

    var btn = document.getElementsByClassName('dash-' + pageName + '-btn');
    for (i = 0; i < btn.length; i++) {
        //btn[i].style.backgroundColor = 'grey';
		btn[i].classList.add('profile-btn-select');
    }
}


