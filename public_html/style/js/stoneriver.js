$(function () {

	$('#do_search').on('click', function (e) {
		bounce('/shop/search/' + $.trim($('#search').val().toLowerCase().replace(/[^0-9a-z ]/g, '')).replace(/ /g, '+'));
	});

	$('#search').on('keypress touchstart', function (e) {

		if (e.which == 13)
		{
			$('#do_search').trigger('click');
		}

	});

	$('.carousel').carousel({
		interval: 5000 //changes the speed
	});

	$(window).scroll(function () {

		if (($(".navbar").offset().top - $(window).scrollTop()) > 14)
		{
			$(".navbar").removeClass("navbar-shrink");
		}
		else
		{
			$(".navbar").addClass("navbar-shrink");
		}

		if (($("#page-top").offset().top - $(window).scrollTop()) > -500)
		{
			$(".scroll-top").addClass("d-none");
		}
		else
		{
			$(".scroll-top").removeClass("d-none");
		}

	});

	$('#back_button').on('click', function (e) {

		if (history.length > 2) 
		{
			e.preventDefault();

			window.history.back();
		}

	});

	$('#section_select').on('change', function (e) {
		window.location = $(this).val();
	});

});

function site_message(settings)
{
	var config = {
		resizable: false,
		modal: true,
		hide_qtips: true,
		div_id: 'site_message'
	};

	$.extend(config, settings);

	// Require message
	if (!config.message)
	{
		site_message({message: "site_message({message : 'requires message!' })"});
	}
	else
	{
		// Set up buttons object
		if (!config.buttons)
		{
			config.buttons = {};
		}

		// Add confirm button
		if (settings.confirm)
		{
			config.buttons.Confirm = function () {
				settings.confirm();
				// Destroy div
				$(this).remove();
			};
		}

		// Add cancel button with callback, else if add plain cancel if confirm button has been added, else add ok button
		if (settings.cancel)
		{
			config.buttons.Cancel = function () {
				settings.cancel();
				// Destroy hidden div and dialog
				$(this).remove();
			};
		}
		else if (settings.confirm)
		{
			config.buttons.Cancel = function () {
				// Destroy hidden div and dialog
				$(this).remove();
			};
		}
		else if (!settings.noOk)
		{
			config.buttons.Ok = function () {
				// Destroy hidden div and dialog
				$(this).remove();
			};
		}
	}

	// Create hidden message div
	if ($('#' + config.div_id).length == 0)
	{
		var div = $('<div></div>');
		div.attr('id', config.div_id);
		div.attr('style', 'display:none;');
		$(document.body).append(div);
	}

	// Add message to hidden div
	$('#' + config.div_id).html(config.message);

	// Launch the dialog
	$('#' + config.div_id).dialog(config);
}

function bounce(location, target)
{
	if (!location)
	{
		location = '/';
	}

	if (target)
	{
		window.open(location, target);
	}
	else
	{
		window.location.href = location;
	}
}