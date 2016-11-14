
// Site View Script

var View = {

	'init' : function() {

		/* Semantic UI settings */

		$('#section-button').popup({ 'position': 'bottom right', 'variation': 'inverted' });

		$('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

		$('.fixed.button').popup({ 'position': 'left center', 'variation': 'inverted' }).transition('jiggle');

		var items = $('.ui.form').find('input, textarea, select');

		items.filter('textarea').css({ 'height' : '6em', 'min-height' : '6em' });

		items.filter('select').addClass('ui dropdown').filter('[data-search=search]').addClass('search');

		items.filter('[data-error=error]').closest('.field').addClass('error');

		items.filter(':disabled').closest('.field').addClass('disabled');

		var onChange = function() { if ($(this).is('select[data-auto=auto]')) $(this).closest('form').submit(); };

		$('.ui.dropdown').dropdown({ 'duration' : 0, 'onChange' : onChange, 'placeholder' : false });

		$('.ui.checkbox').checkbox();

		$('.ui.accordion').accordion();

		$('.ui.sticky').sticky({ 'offset' : 60 });

		$('.ui.modal').modal('setting', 'transition', 'fade down');

		/* Main menu */

		if ($('.main.menu').children('.item').not('.brand').not('.launcher').length) {

			$('.main.menu .launcher').click(function() { $('.sidebar.menu').sidebar('show'); });

			$('.sidebar.menu').append($('.main.menu').children('.item').not('.brand').not('.launcher').clone());

			$('.sidebar.menu').find('.ui.dropdown').removeClass('ui dropdown');

		} else $('.main.menu .launcher').hide();

		/* Auto hide sidebar */

		$(window).resize(function(event) {

			event.preventDefault(); if (window.matchMedia('(min-width: 768px)').matches) $('.sidebar.menu').sidebar('hide');
		});

		/* Captcha */

		$('#captcha').click(function() { $(this).find('img').attr('src', install_path + '/captcha.png?unique=' + Math.random()); });
	}
};
