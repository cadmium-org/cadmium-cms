
// Site View Script

var View = {

	'init' : function() {

		/* Main menu */

		if ($('.main.menu').children('.item').not('.brand').not('.launcher').length) {

			$('.main.menu .launcher').click(function() { $('.sidebar.menu').sidebar('show'); });

			$('.sidebar.menu').append($('.main.menu').children('.item').not('.brand').not('.launcher').clone());

			$('.sidebar.menu').find('.ui.dropdown').removeClass('ui dropdown');

		} else $('.main.menu .launcher').hide();

		$('.main.menu .dropdown').dropdown({ 'duration' : 0, 'action' : 'hide' });

		$('.main.menu .section.item').popup({ 'position': 'bottom right', 'variation': 'inverted' });

		/* Auto hide sidebar */

		$(window).resize(function(event) {

			event.preventDefault(); if (window.matchMedia('(min-width: 768px)').matches) $('.sidebar.menu').sidebar('hide');
		});

		/* Init dynamic components */

		this.initComponents($('#container'));
	},

	'initComponents' : function(parent) {

		/* Forms */

		var items = parent.find('.ui.form').find('input, textarea, select');

		items.filter('select').addClass('ui dropdown').filter('[data-search=search]').addClass('search');

		items.filter('[data-error=error]').closest('.field').addClass('error');

		items.filter(':disabled').closest('.field').addClass('disabled');

		/* Dropdowns */

		var onChange = function() { if ($(this).is('select[data-auto=auto]')) $(this).closest('form').submit(); };

		parent.find('.ui.dropdown').dropdown({ 'duration' : 0, 'onChange' : onChange, 'placeholder' : false });

		/* Captcha */

		parent.find('#captcha').click(function() {

			$(this).find('img').attr('src', install_path + '/captcha.png?unique=' + Math.random());
		});
	}
};
