(function($) {
	$(document).ready(function() {
		
			$('#footer').css('margin-top',
			  $(document).height() 
			  - ( $('#header').height() + $('#content').height() )
			  + $('#footer').height()/3
			);
		
			//Style the sign in form in javascript because we're using the wordpress function to display the form
			$('#login_form').addClass("text-center");
			$('#login_username').addClass("form-control");
			$('#login_password').addClass("form-control");
			$('#login_submit').addClass("form-control btn btn-outline-primary w-50");
			$('#login_remember').addClass("");
		
			/* Append the logout button to the navbar*/
			$("#logoutNav").append(gsz.logOut);
			
			/* Set up the ajax framework to display loading bar, configure the WP url, and display certain errors explicitly */
			$.ajaxSetup({
				url: gsz.url
			});
	})
})(jQuery);


/* START BOOTBOX PROMPTS */
function success() {
	alert("Success.");
	document.location.reload(true);
}

function fail(m) {
    var msg = (typeof m === 'string' || m instanceof String) ? m : "Something went wrong.";
	alert(msg);
	//document.location.reload(true);
}

function appBreak() {
    var msg = "Something went wrong.";
	alert(msg);
	document.location.reload(true);
}

function ajaxBreak(m) {
    var msg = (typeof m === 'string' || m instanceof String) ? m : "Something went wrong.";
	alert(msg);
	document.location.reload(true);
}

function empty() {
	alert("Empty fields.");
}