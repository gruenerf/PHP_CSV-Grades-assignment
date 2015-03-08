$(document).ready(function () {

	// Gives current menu item an active class
	$('#menu li a').each(function () {
		var href = window.location.search;

		// For first time loading page add an active class to list_courses
		if (href == '') {
			href = '?route=list_courses';
		}

		if ($(this).attr('href') == href) {
			$(this).parent().addClass('active');
		}
	});
});