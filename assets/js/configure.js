(function($) {
	$(document).ready(function() {
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