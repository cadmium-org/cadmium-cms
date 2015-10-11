
// Site Main Script

var Main = {

	'init' : function() {

		/* Semantic UI settings */

		$('#section-button').popup({ 'position': 'bottom right', 'variation': 'inverted' });

		$('.icon.button').popup({ 'position': 'bottom left', 'variation': 'inverted' });

		var items = $('.ui.form').find('input, textarea, select');

		items.filter('textarea').css({ 'height' : '6em', 'min-height' : '6em' });

		items.filter('select').not(':disabled').addClass('ui dropdown').filter('[data-search=search]').addClass('search');

		items.filter('[data-error=error]').closest('div.field').addClass('error');

		items.filter(':disabled').closest('div.field').addClass('disabled');

		var onChange = function() { if ($(this).is('select[data-auto=auto]')) $(this).closest('form').submit(); };

		$('.ui.dropdown').dropdown({ 'duration' : 0, 'onChange' : onChange, 'placeholder' : '----' });

		$('.ui.checkbox').checkbox();

		$('.ui.accordion').accordion();

		$('#captcha').click(function() { $(this).find('img').attr('src', '/captcha.png?unique=' + Math.random()); });

		$('.ui.modal').modal('setting', 'transition', 'fade down');

		$('#menu-launcher').click(function() { $('.sidebar').sidebar('show'); });

		/* Window resize handler */

		$(window).resize(function(event) { event.preventDefault(); Main.resize(); }).resize();

		for (object in this) if (typeof this[object] === 'object') this[object].init();
	},

	'resize' : function() {

		var width = $(window).width(), sidebar = $('.sidebar');

		var menu = $('.ui.main.menu');

		var brand = menu.find('#menu-brand'), launcher = menu.find('#menu-launcher');

		var items = menu.find('#menu-items');

		if (sidebar.children().length == 0) {

			sidebar.append(items.children().clone());

			sidebar.find('.ui.dropdown').removeClass('ui dropdown');

			sidebar.find('.item').click(function() { sidebar.sidebar('hide'); });
		}

		if (width < 768) { items.hide(); launcher.show(); }

		else { launcher.hide(); items.show(); sidebar.sidebar('hide'); }
	}
};
