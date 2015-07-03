
// Site Main Script

var Main = {

	'init' : function() {

		/* Semantic UI settings */

		$('#section-button, .icon.button').popup({ 'position': 'bottom right', 'variation': 'inverted' });

		var items = $('.ui.form').find('input, textarea, select');

		items.filter('textarea').css({ 'height' : '6em', 'min-height' : '6em' });

		items.filter('select').not(':disabled').addClass('ui dropdown').filter('[data-type=search]').addClass('search');

		items.filter('[data-error=error]').closest('div.field').addClass('error');

		items.filter(':disabled').closest('div.field').addClass('disabled');

		$('.ui.dropdown').dropdown({ 'duration' : 0 });

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

		var brand = $('#menu-brand'), launcher = $('#menu-launcher');

		var items = $('.ui.main.menu').find('.item').not('#menu-brand, #menu-launcher');

		if (sidebar.children().length == 0) {

			sidebar.append(items.clone().show());

			sidebar.find('.dropdown').removeClass('dropdown');
		}

		if (width < 768) { items.hide(); launcher.show(); }

		else { launcher.hide(); items.show(); sidebar.sidebar('hide'); }
	}
};
