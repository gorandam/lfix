$(document).ready(function() {

	$('li.navbar-link').removeClass('active');

	$('li.navbar-link').on('click', function() {

		$('li.navbar-link').removeClass('active');
		$(this).addClass('active');

	});

});