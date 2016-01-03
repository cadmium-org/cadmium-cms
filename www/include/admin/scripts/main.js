
// Admin Main Script

var Main = {

	'init' : function() {

		/* Semantic UI settings */

		$('#section-button').popup({ 'position': 'bottom right', 'variation': 'inverted' });

		$('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

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

		$('.main.menu .launcher').click(function() { $('.sidebar.menu').sidebar('show'); });

		$('.sidebar.menu').append($('.main.menu').children('.item').not('.brand').not('.launcher').clone());

		$('.sidebar.menu').find('.ui.dropdown').removeClass('ui dropdown');

		/* Auto hide sidebar */

		$(window).resize(function(event) {

			event.preventDefault(); if (window.matchMedia('(min-width: 768px)').matches) $('.sidebar.menu').sidebar('hide');
		});

		/* Captcha */

		$('#captcha').click(function() { $(this).find('img').attr('src', install_path + '/captcha.png?unique=' + Math.random()); });

		/* Init objects */

		for (object in this) if (typeof this[object] === 'object') this[object].init();
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
	},

	'Pages' : {

		'locked' : false, 'sender' : false, 'list' : [],

		'init' : function() {

			var handler = this;

			$('table#pages-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id'), title = row.data('title');

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['PAGES_CONFIRM_REMOVE'], title, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/pages/edit?id=' + item.id), { 'action': 'remove' });
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

		'menuitem_text' : false, 'menuitem_slug' : false,

		'init' : function() {

			this.id = parseInt($('input:hidden#page-id[name=id]').val());

			this.parent_id = $('input#page-parent-id');

			this.parent_title = $('input#page-parent-title');

			this.menuitem_text = $('input#menuitem-text');

			this.menuitem_slug = $('input#menuitem-slug');
		},

		'load' : function(parent_id) {

			if (this.locked) return;

			parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : this.parent_id);

			this.locked = true; $('#modal-lister').children('.segment').addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/pages?parent_id=' + parent_id), { 'id' : this.id });
		},

		'handle' : function(data) {

			if ((parseInt(data.status) == 1) && (typeof data.contents != 'undefined')) {

				var handler = this, modal = $('#modal-lister'), content = modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), title = row.data('title'), slug = row.data('slug')

					var selector = row.find('.select.button');

					if (id == handler.parent_id.val()) selector.addClass('positive');

					selector.click(function() { handler.select(id, title, slug); });

				}).find('.icon.button').popup({ 'position': 'bottom left', 'variation': 'inverted' });

				content.removeClass('loading'); modal.modal('show');
			}

			this.locked = false; return null;
		},

		'select' : function(parent_id, title, slug) {

			this.parent_id.val(parent_id); this.parent_title.val(title);

			this.menuitem_text.val(title); this.menuitem_slug.val(slug);

			$('#modal-lister').modal('hide');
		}
	},

	'Menuitems' : {

		'list' : [], 'locked' : false, 'sender' : false,

		'init' : function() {

			var handler = this;

			$('table#menuitems-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id'), text = row.data('text');

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['MENUITEMS_CONFIRM_REMOVE'], text, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'text' : text, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/menuitems/edit?id=' + item.id), { 'action': 'remove' });
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

			Main.ajax(this, (install_path + '/admin/content/menuitems?parent_id=' + parent_id), { 'id' : this.id });
		},

		'handle' : function(data) {

			if ((parseInt(data.status) == 1) && (typeof data.contents != 'undefined')) {

				var handler = this, modal = $('#modal-lister'), content = modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), text = row.data('text');

					var selector = row.find('.select.button');

					if (id == handler.parent_id.val()) selector.addClass('positive');

					selector.click(function() { handler.select(id, text); });

				}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

				content.removeClass('loading'); modal.modal('show');
			}

			this.locked = false; return null;
		},

		'select' : function(parent_id, text) {

			this.parent_id.val(parent_id); this.parent_text.val(text);

			$('#modal-lister').modal('hide');
		}
	},

	'Variables' : {

		'locked' : false, 'sender' : false, 'list' : [],

		'init' : function() {

			var handler = this;

			$('table#variables-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id');

				var title = row.data('title'), name = row.data('name');

				row.find('.info.button').click(function() {

					if (!handler.locked) Main.info($('<p>' + lang['VARIABLES_INFO_TEXT'] + '</p><form class="ui form">' +

						'<input type="text" readonly="readonly" value="$' + name + '$" /></form>'));
				});

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['VARIABLES_CONFIRM_REMOVE'], title, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/variables/edit?id=' + item.id), { 'action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Widgets' : {

		'locked' : false, 'sender' : false, 'list' : [],

		'init' : function() {

			var handler = this;

			$('table#widgets-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id');

				var title = row.data('title'), name = row.data('name');

				row.find('.info.button').click(function() {

					if (!handler.locked) Main.info($('<p>' + lang['WIDGETS_INFO_TEXT'] + '</p><form class="ui form">' +

						'<input type="text" readonly="readonly" value="{ widget:' + name + ' / }" /></form>'));
				});

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['WIDGETS_CONFIRM_REMOVE'], title, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'title' : title, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/widgets/edit?id=' + item.id), { 'action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Filemanager' : {

		'locked' : false, 'sender' : false, 'list' : [], 'parent' : false, 'link' : false,

		'upload_form' : false, 'upload_select' : false, 'upload_submit' : false,

		'button_create' : false, 'button_reload' : false, 'modal' : false, 'submitted' : false,

		'init' : function() {

			var handler = this;

			this.parent = $('input:hidden#filemanager-parent[name=parent]').val();

			this.link = (install_path + '/admin/content/filemanager' + (this.parent ? ('?parent=' + this.parent) : ''));

			this.upload_form = $('#filemanager-upload-form');

			this.upload_select = $('#filemanager-upload-select').click(function() { handler.uploadSelect() });

			this.upload_submit = $('#filemanager-upload-submit').click(function() { handler.uploadSubmit() });

			this.button_create = $('#filemanager-button-create').click(function() { handler.create(); });

			this.button_reload = $('#filemanager-button-reload').click(function() { handler.reload(); });

			this.upload_form.submit(function() { handler.upload_submit.addClass('loading'); });

			this.modal_create = $('#filemanager-modal-create').each(function() {

				var form = $(this).find('form'), deny = $(this).find('.deny'), approve = $(this).find('.approve');

				var select = form.find('select#create-type'), input = form.find('input#create-name');

				input.change(function() { $(this).val($(this).val().trim()); });

				form.submit(function() {

					if (input.change().val() != '') handler.submitted = true; else return false;

					select.blur().parent().addClass('disabled'); input.blur().parent().addClass('disabled');

					deny.addClass('disabled'); approve.addClass('disabled').addClass('loading');
				});

				$(this).modal('setting', 'onShow', function() {

					form.trigger('reset'); select.parent().dropdown({ 'duration' : 0 });
				});

				$(this).modal('setting', 'onHide', function() { if (!handler.submitted) handler.enableControls(); });

				$(this).modal('setting', 'onApprove', function() { form.submit(); return false; });
			});

			$('table#filemanager-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, type = row.data('type'), name = row.data('name');

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					var text = ((type == 'dir') ? 'FILEMANAGER_CONFIRM_DIR_REMOVE' : 'FILEMANAGER_CONFIRM_FILE_REMOVE');

					Main.confirm(lang[text], name, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'type' : type, 'name' : name, 'remove' : remove };
			});
		},

		'disableControls' : function() {

			this.locked = true;

			this.upload_select.addClass('disabled'); this.upload_submit.addClass('disabled');

			this.button_create.addClass('disabled'); this.button_reload.addClass('disabled');
		},

		'enableControls' : function() {

			this.locked = false;

			this.upload_select.removeClass('disabled'); this.upload_submit.removeClass('disabled');

			this.button_create.removeClass('disabled'); this.button_reload.removeClass('disabled');
		},

		'uploadSelect' : function() {

			if (!this.locked) { this.upload_form.find('input[type=file]').click(); }
		},

		'uploadSubmit' : function() {

			if (!this.locked) { this.disableControls(); this.upload_form.submit(); }
		},

		'create' : function() {

			if (!this.locked) { this.disableControls(); this.modal_create.modal('show'); }
		},

		'reload' : function() {

			if (!this.locked) { this.disableControls(); window.location.replace(this.link); }
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.disableControls(); this.sender = index; button.addClass('loading');

			var path = (install_path + '/admin/content/filemanager/' + item.type);

			var query = ('?parent=' + this.parent + '&name=' + item.name);

			Main.ajax(this, (path + query), { 'action': 'remove' });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].remove.removeClass('loading');

				if (parseInt(data.status) == 1) this.list[this.sender].row.remove();
			}

			this.sender = false; this.enableControls(); return null;
		}
	},

	'Languages' : {

		'list' : [], 'locked' : false, 'sender' : false, 'section' : false,

		'init' : function() {

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

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.checker.is(checker) || checker.is('.positive')) return;

			this.locked = true; this.sender = index; checker.addClass('loading');

			Main.ajax(this, (install_path + '/admin/extend/languages?list=' + this.section), { 'name': item.name });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].checker.removeClass('loading');

				if (parseInt(data.status) == 1) {

					for (var index in this.list) {

						if (index == this.sender) this.list[index].checker.removeClass('grey').addClass('positive');

						else this.list[index].checker.removeClass('positive').addClass('grey');
					}

					if (this.section == 'admin') return window.location.reload();
				}
			}

			this.sender = false; this.locked = false; return null;
		}
	},

	'Templates' : {

		'list' : [], 'locked' : false, 'sender' : false, 'section' : false,

		'init' : function() {

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

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.checker.is(checker) || checker.is('.positive')) return;

			this.locked = true; this.sender = index; checker.addClass('loading');

			Main.ajax(this, (install_path + '/admin/extend/templates?list=' + this.section), { 'name': item.name });
		},

		'handle' : function(data) {

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].checker.removeClass('loading');

				if (parseInt(data.status) == 1) {

					for (var index in this.list) {

						if (index == this.sender) this.list[index].checker.removeClass('grey').addClass('positive');

						else this.list[index].checker.removeClass('positive').addClass('grey');
					}

					if (this.section == 'admin') return window.location.reload();
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

				var remove = row.find('.remove.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.remove(index, element); };

					Main.confirm(lang['USERS_CONFIRM_REMOVE'], name, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'id' : id, 'name' : name, 'remove' : remove };
			});
		},

		'remove' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; if (!item.remove.is(button)) return;

			this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/system/users/edit?id=' + item.id), { 'action': 'remove' });
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

			var container = $('#ckeditor-container'); if (!container.length) return;

			var language = $('html').attr('lang'), instanceReady = function (event) { container.show(); };

			CKEDITOR.replace('page-contents', { 'language' : language , 'on' : { 'instanceReady' : instanceReady } });
		}
	}
};
