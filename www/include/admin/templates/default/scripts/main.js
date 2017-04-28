
// Admin Main Script

var Main = {

	'locked' : false, 'state_id' : 0, 'href' : '', 'save' : false, 'loader' : null, 'title' : null, 'container' : null,

	'init' : function() {

		if (history.pushState) {

			this.loader = $('#loader'); this.title = $('#title'); this.container = $('#container');

			var onSuccess = function() { $(this).fadeOut(500, function() { $(this).progress('reset'); }); };

			this.loader.progress({ 'className' : { 'success' : '' }, 'onSuccess' : onSuccess });

			this.loader.progress('set duration', 500);

			// Add the current page to the history to make it ajax-requestable on navigating back or forward

			var page = { 'title' : $('title').html(), 'url' : window.location.href };

			history.replaceState(page, page.title, page.url);

			window.onpopstate = function(event) { if (event.state) { Main.goto(event.state.url, {}, false); }};

			this.initNavigation($('body'));
		}

		this.initObjects();
	},

	'initNavigation' : function(parent) {

		parent.find('a').not('.logout').not('[target=_blank]').not('[href^="#"]').click(function(event) {

			event.preventDefault(); Main.goto($(this).attr('href'), {}, true);
		});

		parent.find('form').each(function() {

			var form = $(this), action = form.attr('action');

			$(this).submit(function(event) {

				event.preventDefault();

				if (Main.CKEditor.editor) Main.CKEditor.editor.updateElement();

				var data = (window.FormData ? new FormData(form[0]) : form.serialize);

				Main.goto(action, data, true);
			});
		});
	},

	'initObjects' : function() {

		for (object in this) if ((typeof this[object] === 'object') && !(this[object] instanceof jQuery)) this[object].init();
	},

	'ajax' : function(handler, url, data, headers) {

		var state_id = this.state_id;

		if (data instanceof FormData) var contentType = false, processData = false;

		else var contentType = 'application/x-www-form-urlencoded; charset=UTF-8', processData = true;

		$.ajax({ 'type' : 'POST', 'contentType' : contentType, 'cache' : false, 'url' : url,

			'data' : data, 'dataType' : 'json', 'processData' : processData, 'headers' : headers,

			'success' : function(data, status) {

				if (state_id != Main.state_id) return null;

				if (typeof data.status != 'undefined') handler.handle(data);

				else return Main.error(lang['AJAX_ERROR_STATUS']);

				if (!data.status) {

					if (typeof data.error != 'undefined') Main.error(data.error);

					else return Main.error(lang['AJAX_ERROR_UNKNOWN']);
				}

				return null;
			},

			'error' : function(xhr, text) {

				if (state_id != Main.state_id) return null;

				handler.handle({}); console.log(xhr.responseText);

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

	'goto' : function(href, data, save) {

		if (!href || this.locked) return;

		this.locked = true; this.href = href; this.save = save;

		this.loader.show().progress('set percent', 20);

		this.ajax(this, href, data, { 'X-Special-Request' : 'navigate' });
	},

	'handle' : function(data) {

		if (data.status && data.navigate && data.layout && ++this.state_id) {

			console.log('#' + this.state_id + ': ' + this.href);

			var page = { 'title' : data.title, 'url' : this.href };

			if (this.save) history.pushState(page, page.title, page.url);

			$('html').attr('lang', data.language); $('title').html(data.title);

			$('body').scrollTop(0); $('.sidebar.menu').sidebar('hide'); this.title.html(data.layout.title);

			this.container.html(data.layout.messages + data.layout.popup + data.layout.contents);

			View.initComponents(this.container); this.initNavigation(this.container); this.initObjects();
		}

		this.loader.progress('set percent', 100);

		this.href = ''; this.save = false; this.locked = false; return null;
	},

	'confirm' : function(text, name, type, callback) {

		var modal = $('#modal-confirm');

		modal.find('.content').html('<p>' + text + '</p><p><strong>' + name + '</strong></p>');

		modal.find('.approve').off().addClass(type).click(callback);

		modal.modal('show');
	},

	'info' : function(text) {

		var modal = $('#modal-info');

		modal.find('.content').html(text);

		modal.modal('show');
	},

	'error' : function(text) {

		var modal = $('#modal-error');

		modal.find('.content').html(text);

		modal.modal('show');
	}
};

Main.Language = {

	'locked' : false, 'button' : null, 'loader' : null, 'menu' : null,

	'init' : function() {

		this.locked = false;

		var handler = this;

		if (!this.button) this.button = $('#language-button').click(function() { handler.submit(); });

		if (!this.loader) this.loader = $('#language-loader');

		if (!this.menu) this.menu = this.button.find('.menu');

		if (this.menu.children('.item').length) this.initMenu();
	},

	'initMenu' : function() {

		var query = (window.location.search ? window.location.search.replace(/(^\?)/, '').split("&").

			map(function(i) { return i = i.split("="), this[i[0]] = i[1], this; }.bind({}))[0] : {});

		this.menu.children('.item').each(function() {

			var params = query; params.language = $(this).data('name');

			$(this).attr('href', (window.location.pathname + '?' + $.param(params)));
		});
	},

	'submit' : function() {

		if (Main.locked || this.locked || (this.menu.find('.item').length > 0)) return;

		this.locked = true; this.loader.show();

		Main.ajax(this, (install_path + '/admin/extend/languages?list=admin'), { 'action' : 'list' });
	},

	'handle' : function(data) {

		if (data.status) {

			for (var i in data.items) {

				var item = $('<a>').addClass('item').data('name', data.items[i].name);

				if (data.items[i].iso == $('html').attr('lang')) item.addClass('active');

				item.html('<i class="' + data.items[i].country + ' flag"></i>' + data.items[i].title);

				this.menu.append(item);
			}

			this.initMenu(); this.button.dropdown({ 'duration' : 0 }).dropdown('show');
		}

		this.loader.hide(); this.locked = false; return null;
	}
};

Main.Pages = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		$('table#pages-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, id = row.data('id'), title = row.data('title');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				Main.confirm(lang['PAGES_CONFIRM_REMOVE'], title, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
		});
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/content/pages/edit?id=' + item.id);

		Main.ajax(this, url, { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.PagesSelector = {

	'locked' : false, 'id' : null, 'parent_id' : null, 'super_parent_id' : null,

	'menuitem_text' : null, 'menuitem_slug' : null,

	'button_load' : null, 'button_reset' : null,

	'init' : function() {

		this.locked = false;

		this.id = parseInt($('input:hidden#page-id[name=id]').val());

		this.parent_id = $('input#page-parent-id'); this.super_parent_id = $('input#page-super-parent-id');

		this.menuitem_text = $('input#menuitem-text'); this.menuitem_slug = $('input#menuitem-slug');

		this.button_load = $('#pages-selector-load'); this.button_reset = $('#pages-selector-reset');
	},

	'set' : function(title, slug) {

		this.menuitem_text.val(title); this.menuitem_slug.val(slug);
	},

	'submit' : function(parent_id) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.button_load.addClass('loading'); this.button_reset.addClass('disabled');

		var url = (install_path + '/admin/content/pages/edit?id=' + this.id);

		Main.ajax(this, url, { 'action' : 'move', 'parent_id' : parent_id });
	},

	'handle' : function(data) {

		if (data.status) return window.location.replace(install_path + '/admin/content/pages/edit?id=' + this.id);

		this.button_load.removeClass('loading'); this.button_reset.removeClass('disabled');

		this.locked = false; return null;
	}
};

Main.PagesLoader = {

	'locked' : false, 'callback' : null, 'modal' : null,

	'init' : function() {

		this.locked = false; this.callback = null; this.modal = $('#modal-lister');
	},

	'open' : function(parent_id, callback) {

		if (Main.locked || this.locked) return;

		var selector = Main.PagesSelector;

		parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : parseInt(selector.super_parent_id.val()));

		this.locked = true; this.callback = ((typeof callback === 'function') ? callback : null);

		this.modal.children('.segment').addClass('loading');

		var url = (install_path + '/admin/content/pages?parent_id=' + parent_id);

		Main.ajax(this, url, { 'id' : (!this.callback ? selector.id : 0) });
	},

	'load' : function(parent_id) {

		if (Main.locked || this.locked) return;

		var selector = Main.PagesSelector;

		this.locked = true; this.modal.children('.segment').addClass('loading');

		var url = (install_path + '/admin/content/pages?parent_id=' + parent_id);

		Main.ajax(this, url, { 'id' : (!this.callback ? selector.id : 0) });
	},

	'handle' : function(data) {

		if (data.status && (typeof data.contents != 'undefined')) {

			var selector = Main.PagesSelector, handler = this, content = this.modal.children('.segment');

			content.html(data.contents).find('table tbody tr').each(function() {

				var row = $(this), id = row.data('id'), title = row.data('title'), slug = row.data('slug');

				var link = row.find('.browse.button').attr('href');

				var button = row.find('.select.button');

				if (!handler.callback && (id == selector.parent_id.val())) button.addClass('positive');

				button.click(function() {

					if (handler.callback) handler.callback(title, slug, link);

					else if (selector.id) selector.submit(id); else selector.set(title, slug, link);

					handler.modal.modal('hide');
				});

			}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

			content.removeClass('loading'); this.modal.modal('show');
		}

		this.locked = false; return null;
	},
};

Main.Menuitems = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		$('table#menuitems-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, id = row.data('id'), text = row.data('text');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				Main.confirm(lang['MENUITEMS_CONFIRM_REMOVE'], text, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'id' : id, 'text' : text, 'remove' : remove };
		});
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/content/menuitems/edit?id=' + item.id);

		Main.ajax(this, url, { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.MenuitemsSelector = {

	'locked' : false, 'id' : null, 'parent_id' : null, 'super_parent_id' : null,

	'button_load' : null, 'button_reset' : null,

	'init' : function() {

		this.locked = false;

		this.id = parseInt($('input:hidden#menuitem-id[name=id]').val());

		this.parent_id = $('input#menuitem-parent-id'); this.super_parent_id = $('input#menuitem-super-parent-id');

		this.button_load = $('#menuitems-selector-load'); this.button_reset = $('#menuitems-selector-reset');
	},

	'submit' : function(parent_id) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.button_load.addClass('loading'); this.button_reset.addClass('disabled');

		var url = (install_path + '/admin/content/menuitems/edit?id=' + this.id);

		Main.ajax(this, url, { 'action' : 'move', 'parent_id' : parent_id });
	},

	'handle' : function(data) {

		if (data.status) return window.location.replace(install_path + '/admin/content/menuitems/edit?id=' + this.id);

		this.button_load.removeClass('loading'); this.button_reset.removeClass('disabled');

		this.locked = false; return null;
	}
};

Main.MenuitemsLoader = {

	'locked' : false, 'callback' : null, 'modal' : null,

	'init' : function() {

		this.locked = false; this.callback = null; this.modal = $('#modal-lister');
	},

	'open' : function(parent_id, callback) {

		if (Main.locked || this.locked) return;

		var selector = Main.MenuitemsSelector;

		parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : parseInt(selector.super_parent_id.val()));

		this.locked = true; this.callback = ((typeof callback === 'function') ? callback : null);

		this.modal.children('.segment').addClass('loading');

		var url = (install_path + '/admin/content/menuitems?parent_id=' + parent_id);

		Main.ajax(this, url, { 'id' : (!this.callback ? selector.id : 0) });
	},

	'load' : function(parent_id) {

		if (Main.locked || this.locked) return;

		var selector = Main.MenuitemsSelector;

		this.locked = true; this.modal.children('.segment').addClass('loading');

		var url = (install_path + '/admin/content/menuitems?parent_id=' + parent_id);

		Main.ajax(this, url, { 'id' : (!this.callback ? selector.id : 0) });
	},

	'handle' : function(data) {

		if (data.status && (typeof data.contents != 'undefined')) {

			var selector = Main.MenuitemsSelector, handler = this, content = this.modal.children('.segment');

			content.html(data.contents).find('table tbody tr').each(function() {

				var row = $(this), id = row.data('id'), text = row.data('text');

				var link = row.find('.browse.button').attr('href');

				var button = row.find('.select.button');

				if (!handler.callback && (id == selector.parent_id.val())) button.addClass('positive');

				button.click(function() {

					if (handler.callback) handler.callback(text, link);

					else if (selector.id) selector.submit(id);

					handler.modal.modal('hide');
				});

			}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

			content.removeClass('loading'); this.modal.modal('show');
		}

		this.locked = false; return null;
	}
};

Main.Variables = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		$('table#variables-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, id = row.data('id');

			var title = row.data('title'), name = row.data('name');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				Main.confirm(lang['VARIABLES_CONFIRM_REMOVE'], title, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
		});
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/content/variables/edit?id=' + item.id);

		Main.ajax(this, url, { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.VariablesLoader = {

	'locked' : false, 'callback' : null, 'modal' : null,

	'init' : function() {

		this.locked = false; this.callback = null; this.modal = $('#modal-lister');
	},

	'open' : function(callback) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.callback = callback;

		this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/variables'));
	},

	'load' : function() {

		if (Main.locked || this.locked) return;

		this.locked = true; this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/variables'));
	},

	'handle' : function(data) {

		if (data.status && (typeof data.contents != 'undefined')) {

			var handler = this, content = this.modal.children('.segment');

			content.html(data.contents).find('table tbody tr').each(function() {

				var row = $(this), id = row.data('id'), name = row.data('name');

				var button = row.find('.select.button');

				button.click(function() { handler.callback(name); handler.modal.modal('hide'); });

			}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

			content.removeClass('loading'); this.modal.modal('show');
		}

		this.locked = false; return null;
	}
};

Main.Widgets = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		$('table#widgets-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, id = row.data('id');

			var title = row.data('title'), name = row.data('name');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				Main.confirm(lang['WIDGETS_CONFIRM_REMOVE'], title, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
		});
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/content/widgets/edit?id=' + item.id);

		Main.ajax(this, url, { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.WidgetsLoader = {

	'locked' : false, 'callback' : null, 'modal' : null,

	'init' : function() {

		this.locked = false; this.callback = null; this.modal = $('#modal-lister');
	},

	'open' : function(callback) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.callback = callback;

		this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/widgets'));
	},

	'load' : function() {

		if (Main.locked || this.locked) return;

		this.locked = true; this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/widgets'));
	},

	'handle' : function(data) {

		if (data.status && (typeof data.contents != 'undefined')) {

			var handler = this, content = this.modal.children('.segment');

			content.html(data.contents).find('table tbody tr').each(function() {

				var row = $(this), id = row.data('id'), name = row.data('name');

				var button = row.find('.select.button');

				button.click(function() { handler.callback(name); handler.modal.modal('hide'); });

			}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

			content.removeClass('loading'); this.modal.modal('show');
		}

		this.locked = false; return null;
	}
};

Main.Filemanager = {

	'locked' : false, 'sender' : null, 'list' : [], 'parent' : '',

	'upload_form' : null, 'upload_input' : null, 'upload_select' : null, 'upload_submit' : null,

	'create_form' : null, 'create_input' : null, 'button_create' : null, 'button_reload' : null,

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		this.parent = $('input:hidden#filemanager-parent[name=parent]').val();

		// Process upload form

		this.upload_form = $('.managebar form.upload').submit(function() { handler.upload_submit.addClass('loading'); });

		this.upload_input = this.upload_form.find('input').change(function() { handler.upload_submit.removeClass('disabled'); });

		this.upload_select = this.upload_form.find('.select.button').click(function() { handler.upload_input.click(); });

		this.upload_submit = this.upload_form.find('.submit.button').click(function() { handler.upload_form.submit(); });

		// Process create form

		this.create_form = $('.managebar form.create');

		this.create_input = this.create_form.find('input').change(function() { $(this).val($(this).val().trim()); });

		this.button_create = this.create_form.find('.create.button').click(function() { handler.create(); });

		this.button_reload = this.create_form.find('.reload.button').click(function() { handler.reload(); });

		// Process items

		$('table#filemanager-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, type = row.data('type'), name = row.data('name');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				var text = ((type == 'dir') ? 'FILEMANAGER_CONFIRM_DIR_REMOVE' : 'FILEMANAGER_CONFIRM_FILE_REMOVE');

				Main.confirm(lang[text], name, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'type' : type, 'name' : name, 'remove' : remove };
		});
	},

	'create' : function() {

		if (this.create_input.change().val() != '') this.create_form.submit();
	},

	'reload' : function() {

		Main.goto(install_path + '/admin/content/filemanager/uploads' + (this.parent ? ('?parent=' + this.parent) : ''));
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var path = (install_path + '/admin/content/filemanager/uploads/' + item.type);

		var query = ('?parent=' + this.parent + '&name=' + item.name);

		Main.ajax(this, (path + query), { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.FilesLoader = {

	'locked' : false, 'callback' : null, 'modal' : null,

	'init' : function() {

		this.locked = false; this.callback = null; this.modal = $('#modal-lister');
	},

	'open' : function(parent, callback) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.callback = callback;

		this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/filemanager/uploads?parent=' + parent), {});
	},

	'load' : function(parent) {

		if (Main.locked || this.locked) return;

		this.locked = true; this.modal.children('.segment').addClass('loading');

		Main.ajax(this, (install_path + '/admin/content/filemanager/uploads?parent=' + parent), {});
	},

	'handle' : function(data) {

		if (data.status && (typeof data.contents != 'undefined')) {

			var handler = this, content = this.modal.children('.segment');

			content.html(data.contents).find('table tbody tr').each(function() {

				var row = $(this), name = row.data('name'), path = row.data('path');

				var format = row.data('format'), mime = row.data('mime');

				var button_media = row.find('.media.button'), button_link = row.find('.link.button');

				button_media.click(function() { handler.callback(name, path, format, mime); handler.modal.modal('hide'); });

				button_link.click(function() { handler.callback(name, path); handler.modal.modal('hide'); });

			}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

			content.removeClass('loading'); this.modal.modal('show');
		}

		this.locked = false; return null;
	}
};

Main.Addons = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = [];

		var handler = this;

		$('table#addons-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, name = row.data('name');

			var install = row.find('.install.button').click(function() { handler.install(index, $(this)); });

			var uninstall = row.find('.uninstall.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.uninstall(index, element); };

				Main.confirm(lang['ADDONS_CONFIRM_UNINSTALL'], name, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'name' : name, 'install' : install, 'uninstall' : uninstall };
		});
	},

	'install' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/extend/addons');

		Main.ajax(this, url, { 'name': item.name, 'action' : 'install' });
	},

	'uninstall' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/extend/addons');

		Main.ajax(this, url, { 'name': item.name, 'action' : 'uninstall' });
	},

	'handle' : function(data) {

		if (data.status) { window.location.reload(); return null; }

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].install.removeClass('loading');

			this.list[this.sender].uninstall.removeClass('loading');
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.Languages = {

	'locked' : false, 'sender' : null, 'list' : [], 'section' : '',

	'init' : function() {

		this.locked = false; this.sender = null; this.list = []; this.section = '';

		var handler = this, section = $('input:hidden#languages-section[name=section]').val();

		if (typeof section != 'undefined') section = section.toLowerCase();

		if (section == 'admin') this.section = 'admin'; else if (section == 'site') this.section = 'site'; else return;

		$('table#languages-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, name = row.data('name');

			var checker = row.find('.checker.button').click(function() { handler.submit(index, $(this)); });

			handler.list[index] = { 'row' : row, 'name' : name, 'checker' : checker };
		});
	},

	'submit' : function(index, checker) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.checker.is(checker) || checker.is('.positive')) return;

		this.locked = true; this.sender = index; checker.addClass('loading');

		var url = (install_path + '/admin/extend/languages?list=' + this.section);

		Main.ajax(this, url, { 'name': item.name, 'action' : 'activate' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].checker.removeClass('loading');

			if (data.status) {

				for (var index in this.list) {

					if (index == this.sender) this.list[index].checker.removeClass('grey').addClass('positive');

					else this.list[index].checker.removeClass('positive').addClass('grey');
				}

				// if (this.section == 'admin') return window.location.reload();
			}
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.Templates = {

	'locked' : false, 'sender' : null, 'list' : [], 'section' : '',

	'init' : function() {

		this.locked = false; this.sender = null; this.list = []; this.section = '';

		var handler = this, section = $('input:hidden#templates-section[name=section]').val();

		if (typeof section != 'undefined') section = section.toLowerCase();

		if (section == 'admin') this.section = 'admin'; else if (section == 'site') this.section = 'site'; else return;

		$('table#templates-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, name = row.data('name');

			var checker = row.find('.checker.button').click(function() { handler.submit(index, $(this)); });

			handler.list[index] = { 'row' : row, 'name' : name, 'checker' : checker };
		});
	},

	'submit' : function(index, checker) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.checker.is(checker) || checker.is('.positive')) return;

		this.locked = true; this.sender = index; checker.addClass('loading');

		var url = (install_path + '/admin/extend/templates?list=' + this.section);

		Main.ajax(this, url, { 'name': item.name, 'action' : 'activate' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].checker.removeClass('loading');

			if (data.status) {

				for (var index in this.list) {

					if (index == this.sender) this.list[index].checker.removeClass('grey').addClass('positive');

					else this.list[index].checker.removeClass('positive').addClass('grey');
				}

				// if (this.section == 'admin') return window.location.reload();
			}
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.Users = {

	'locked' : false, 'sender' : null, 'list' : [],

	'init' : function() {

		this.locked = false; this.sender = null; this.list = []; this.section = '';

		var handler = this;

		$('table#users-list tbody tr').each(function() {

			var row = $(this), index = handler.list.length, id = row.data('id'), name = row.data('name');

			var remove = row.find('.remove.button').click(function() {

				if (Main.locked || handler.locked) return;

				var element = $(this), callback = function() { handler.remove(index, element); };

				Main.confirm(lang['USERS_CONFIRM_REMOVE'], name, 'negative', callback);
			});

			handler.list[index] = { 'row' : row, 'id' : id, 'name' : name, 'remove' : remove };
		});
	},

	'remove' : function(index, button) {

		if (Main.locked || this.locked || typeof this.list[index] == 'undefined') return;

		var item = this.list[index]; if (!item.remove.is(button)) return;

		this.locked = true; this.sender = index; button.addClass('loading');

		var url = (install_path + '/admin/system/users/edit?id=' + item.id);

		Main.ajax(this, url, { 'action': 'remove' });
	},

	'handle' : function(data) {

		if (typeof this.list[this.sender] != 'undefined') {

			this.list[this.sender].remove.removeClass('loading');

			if (data.status) this.list[this.sender].row.remove();
		}

		this.sender = null; this.locked = false; return null;
	}
};

Main.Information = {

	'init' : function() {

		var menu = $('#information-menu'), segments = $('#information-segments');

		menu.children('.item').click(function() {

			$(this).addClass('active').siblings().removeClass('active');

			segments.children('div').hide().filter('[data-name=' + $(this).data('segment') + ']').show();
		});

		var fragment = window.location.hash.substring(1);

		if (fragment.length) menu.children('.item').filter('[data-segment="' + fragment + '"]').click();
	}
};

Main.Ace = {

	'editor' : null,

	'init' : function() {

		var handler = this, container = $('#ace-container'); if (!container.length) return;

		var textarea = container.find('textarea').hide(), holder = container.find('.holder');

		if (!textarea.length || !holder.length) return;

		var mode = holder.data('mode'), minLines = holder.data('min-lines'), maxLines = holder.data('max-lines');

		this.editor = ace.edit(holder.attr('id'));

		this.editor.setTheme('ace/theme/clouds');

		if (mode) this.editor.session.setMode('ace/mode/' + mode);

		this.editor.setOptions({ 'minLines' : minLines, 'maxLines' : maxLines });

		this.editor.setOptions({ 'showPrintMargin' : false, 'useWorker' : false });

		this.editor.renderer.setScrollMargin(5, 5, 0, 0);

		this.editor.setValue(textarea.val()); this.editor.gotoLine(1, 0);

		this.editor.session.on('change', function() { textarea.val(handler.editor.getValue()); });

		container.show();
	},
};

Main.CKEditor = {

	'editor' : null,

	'init' : function() {

		var handler = this, container = $('#ckeditor-container'); if (!container.length) return;

		var language = $('html').attr('lang'), instanceReady = function (event) { container.show(); };

		this.editor = CKEDITOR.replace('page-contents', { 'language' : language , 'on' : { 'instanceReady' : instanceReady }});

		this.editor.on('fileUploadRequest', function(event) {

			event.data.fileLoader.xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		});

		this.editor.on('fileUploadResponse', function(event) {

			event.stop();

			var data = event.data, xhr = data.fileLoader.xhr;

			try {

				var response = JSON.parse(xhr.responseText);

				if (response.error) data.message = response.error;

				if (response.status) { data.fileName = response.name; data.url = response.url; }

				else event.cancel();

			} catch (error) {

				data.message = data.fileLoader.lang.filetools.responseError;

				CKEDITOR.warn('filetools-response-error', { responseText: xhr.responseText });

				event.cancel();
			}
		});
	}
};
