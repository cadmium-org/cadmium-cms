
// Admin Main Script

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
		}

		if (width < 768) { items.hide(); launcher.show(); }

		else { launcher.hide(); items.show(); sidebar.sidebar('hide'); }
	},

	'ajax' : function(handler, url, data) {

		$.ajax({ 'type' : 'POST', 'contentType' : 'application/x-www-form-urlencoded; charset=UTF-8',

			'cache' : false, 'url' : url, 'data' : data, 'dataType' : 'json',

			'success' : function(data, status) {

				if (typeof data.status != 'undefined') handler.handle(data);

				else return Main.error(lang['AJAX_ERROR_STATUS']);

				if (parseInt(data.status) != 1) {

					if (typeof data.error != 'undefined') Main.error(data.error);

					else return Main.error(lang['AJAX_ERROR_UNKNOWN']);
				}

				return null;
			},

			'error' : function(xhr, text) {

				handler.handle({}); alert(xhr.responseText);

				if (text == 'abort') return Main.error(lang['AJAX_ERROR_ABORT']);

				if (text == 'parsererror') return Main.error(lang['AJAX_ERROR_PARSER']);

				if (text == 'timeout') return Main.error(lang['AJAX_ERROR_TIMEOUT']);

				if (xhr.status == 401) return window.location.replace("/admin/login");

				if (xhr.status == 400) return Main.error(lang['AJAX_ERROR_400']);

				if (xhr.status == 404) return Main.error(lang['AJAX_ERROR_404']);

				if (xhr.status == 500) return Main.error(lang['AJAX_ERROR_500']);

				return Main.error(lang['AJAX_ERROR_UNKNOWN']);
			}
		});
	},

	'confirm' : function(text, name, callback) {

		$('#modal-confirm').find('.content').html('<p>' + text + '</p><p><strong>' + name + '</strong></p>');

		$('#modal-confirm').modal('setting', 'onApprove', callback);

		$('#modal-confirm').modal('show');
	},

	'error' : function(text) {

		$('#modal-error').find('.content').html(text);

		$('#modal-error').modal('show');
	},

	'Pages' : {

		'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this;

			$('table#pages-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id'), title = row.data('title');

				var remove = row.find('a[data-action=remove]').click(function() {

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['PAGES_CONFIRM_REMOVE'], title, callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, ('/admin/content/pages/edit?id=' + item.id), { 'ajax_action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'PagesLoader' : {

		'locked' : false, 'id' : false, 'parent_id' : false, 'parent_title' : false,

		'menuitem_text' : false, 'menuitem_link' : false,

		'init' : function() {

			this.id = parseInt($('input:hidden#page-id[name=id]').val());

			this.parent_id = $('input#page-parent-id');

			this.parent_title = $('input#page-parent-title');

			this.menuitem_text = $('input#menuitem-text');

			this.menuitem_link = $('input#menuitem-link');
		},

		'load' : function(parent_id) {

			if (this.locked) return;

			parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : this.parent_id);

			this.locked = true; $('#modal-lister').children('.segment').addClass('loading');

			Main.ajax(this, ('/admin/content/pages?parent_id=' + parent_id), { 'ajax_id' : this.id });
		},

		'handle' : function(data) {

			if ((parseInt(data.status) == 1) && (typeof data.contents != 'undefined')) {

				var handler = this, modal = $('#modal-lister'), content = modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), title = row.data('title'), link = row.data('link');

					var selector = row.find('a[data-action=select]');

					if (id == handler.parent_id.val()) selector.addClass('positive');

					selector.click(function() { handler.select(id, title, link); });

				}).find('.icon.button').popup({ 'position': 'bottom left', 'variation': 'inverted' });

				content.removeClass('loading'); modal.modal('show');
			}

			this.locked = false; return null;
		},

		'select' : function(parent_id, title, link) {

			this.parent_id.val(parent_id); this.parent_title.val(title);

			this.menuitem_text.val(title); this.menuitem_link.val(link);

			$('#modal-lister').modal('hide');
		}
	},

	'Menuitems' : {

		'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this;

			$('table#menuitems-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id'), text = row.data('text');

				var remove = row.find('a[data-action=remove]').click(function() {

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['MENUITEMS_CONFIRM_REMOVE'], text, callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'text' : text, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, ('/admin/content/menuitems/edit?id=' + item.id), { 'ajax_action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'MenuitemsLoader' : {

		'locked' : false, 'id' : false, 'parent_id' : false, 'parent_text' : false,

		'init' : function() {

			this.id = parseInt($('input:hidden#menuitem-id[name=id]').val());

			this.parent_id = $('input#menuitem-parent-id');

			this.parent_text = $('input#menuitem-parent-text');
		},

		'load' : function(parent_id) {

			if (this.locked) return;

			parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : this.parent_id);

			this.locked = true; $('#modal-lister').children('.segment').addClass('loading');

			Main.ajax(this, ('/admin/content/menuitems?parent_id=' + parent_id), { 'ajax_id' : this.id });
		},

		'handle' : function(data) {

			if ((parseInt(data.status) == 1) && (typeof data.contents != 'undefined')) {

				var handler = this, modal = $('#modal-lister'), content = modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), text = row.data('text');

					var selector = row.find('a[data-action=select]');

					if (id == handler.parent_id.val()) selector.addClass('positive');

					selector.click(function() { handler.select(id, text); });

				}).find('.icon.button').popup({ 'position': 'bottom left', 'variation': 'inverted' });

				content.removeClass('loading'); modal.modal('show');
			}

			this.locked = false; return null;
		},

		'select' : function(parent_id, text) {

			this.parent_id.val(parent_id); this.parent_text.val(text);

			$('#modal-lister').modal('hide');
		}
	},

	'Languages' : {

		'section' : false, 'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this, section = $('input:hidden#languages-section[name=section]').val();

			if (typeof section != 'undefined') section = section.toLowerCase();

			if (section == 'admin') this.section = 'admin'; else if (section == 'site') this.section = 'site'; else return;

			$('table#languages-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, name = row.data('name');

				var checker = row.find('a[data-checker=is-active]').click(function() { handler.submit(index, $(this)); });

				if (checker.data('value') == 1) checker.addClass('positive');

				handler.list[index] = { 'row' : row, 'name' : name, 'checker' : checker };
			});
		},

		'submit' : function(index, checker) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.checker.is(checker) || checker.data('value') == 1) return;

			this.locked = true; this.sender = index; checker.addClass('loading');

			Main.ajax(this, false, { 'ajax_name': item.name });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].checker.removeClass('loading');

				if (parseInt(data.status) == 1) {

					if (this.section == 'admin') return location.reload();

					for (var index in this.list) {

						if (index == this.sender) this.list[index].checker.data('value', 1).addClass('positive');

						else this.list[index].checker.data('value', 0).removeClass('positive');
					}
				}
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Templates' : {

		'section' : false, 'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this, section = $('input:hidden#templates-section[name=section]').val();

			if (typeof section != 'undefined') section = section.toLowerCase();

			if (section == 'admin') this.section = 'admin'; else if (section == 'site') this.section = 'site'; else return;

			$('table#templates-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, name = row.data('name');

				var checker = row.find('a[data-checker=is-active]').click(function() { handler.submit(index, $(this)); });

				if (checker.data('value') == 1) checker.addClass('positive');

				handler.list[index] = { 'row' : row, 'name' : name, 'checker' : checker };
			});
		},

		'submit' : function(index, checker) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.checker.is(checker) || checker.data('value') == 1) return;

			this.locked = true; this.sender = index; checker.addClass('loading');

			Main.ajax(this, false, { 'ajax_name': item.name });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].checker.removeClass('loading');

				if (parseInt(data.status) == 1) {

					if (this.section == 'admin') return location.reload();

					for (var index in this.list) {

						if (index == this.sender) this.list[index].checker.data('value', 1).addClass('positive');

						else this.list[index].checker.data('value', 0).removeClass('positive');
					}
				}
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Users' : {

		'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this;

			$('table#users-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id'), name = row.data('name');

				var remove = row.find('a[data-action=remove]').click(function() {

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['USERS_CONFIRM_REMOVE'], name, callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'name' : name, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, ('/admin/system/users/edit?id=' + item.id), { 'ajax_action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Editor' : {

		'init' : function() {

			var container = $('#editor-container');

			if (!container.length) return;

			var language = $('html').attr('lang'), instanceReady = function (event) { container.show(); };

			CKEDITOR.replace('page-contents', { 'language' : language , 'on' : { 'instanceReady' : instanceReady } });
		}
	}
};
