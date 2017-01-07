
// Admin Main Script

var Main = {

	'init' : function() {

		/* Init objects */

		for (object in this) if (typeof this[object] === 'object') this[object].init();
	},

	'ajax' : function(handler, url, data) {

		$.ajax({ 'type' : 'POST', 'contentType' : 'application/x-www-form-urlencoded; charset=UTF-8',

			'cache' : false, 'url' : url, 'data' : data, 'dataType' : 'json',

			'success' : function(data, status) {

				if (typeof data.status != 'undefined') handler.handle(data);

				else return Main.error(lang['AJAX_ERROR_STATUS']);

				if (!data.status) {

					if (typeof data.error != 'undefined') Main.error(data.error);

					else return Main.error(lang['AJAX_ERROR_UNKNOWN']);
				}

				return null;
			},

			'error' : function(xhr, text) {

				handler.handle({}); /* alert(xhr.responseText); */

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

	'Personalizer' : {

		'locked' : false, 'button' : [], 'loader' : null,

		'init' : function() {

			var handler = this;

			this.button = $('.footer .language.button').click(function() { handler.submit(); });

			this.loader = $('.footer .loading.button');
		},

		'submit' : function() {

			if (this.locked || (this.button.find('.menu .item').length > 0)) return;

			this.locked = true; this.loader.show();

			Main.ajax(this, (install_path + '/admin/extend/languages?list=admin'), { 'action' : 'list' });
		},

		'handle' : function(data) {

			if (data.status) for (var i in data.items) {

				var item = $('<a>').addClass('item').attr('href', '?language=' + data.items[i].name);

				item.html('<i class="' + data.items[i].country + ' flag"></i>' +  data.items[i].title);

				this.button.find('.menu').append(item);
			}

			this.loader.hide(); this.button.dropdown('refresh').dropdown('show');

			this.locked = false; return null;
		}
	},

	'Pages' : {

		'locked' : false, 'sender' : null, 'list' : [],

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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'PagesSelector' : {

		'locked' : false, 'id' : null, 'parent_id' : null, 'super_parent_id' : null,

		'menuitem_text' : null, 'menuitem_slug' : null,

		'button_load' : null, 'button_reset' : null,

		'init' : function() {

			this.id = parseInt($('input:hidden#page-id[name=id]').val());

			this.parent_id = $('input#page-parent-id'); this.super_parent_id = $('input#page-super-parent-id');

			this.menuitem_text = $('input#menuitem-text'); this.menuitem_slug = $('input#menuitem-slug');

			this.button_load = $('#pages-selector-load'); this.button_reset = $('#pages-selector-reset');
		},

		'set' : function(title, slug) {

			this.menuitem_text.val(title); this.menuitem_slug.val(slug);
		},

		'submit' : function(parent_id) {

			if (this.locked) return;

			this.locked = true; this.button_load.addClass('loading'); this.button_reset.addClass('disabled');

			var data = { 'action' : 'move', 'parent_id': parent_id };

			Main.ajax(this, (install_path + '/admin/content/pages/edit?id=' + this.id), data);
		},

		'handle' : function(data) {

			if (data.status) return window.location.replace(install_path + '/admin/content/pages/edit?id=' + this.id);

			this.button_load.removeClass('loading'); this.button_reset.removeClass('disabled');

			this.locked = false; return null;
		}
	},

	'PagesLoader' : {

		'locked' : false, 'modal' : null,

		'init' : function() {

			this.modal = $('#modal-lister');
		},

		'load' : function(parent_id) {

			if (this.locked) return;

			var selector = Main.PagesSelector;

			parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : parseInt(selector.super_parent_id.val()));

			this.locked = true; this.modal.children('.segment').addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/pages?parent_id=' + parent_id), { 'id' : selector.id });
		},

		'handle' : function(data) {

			if (data.status && (typeof data.contents != 'undefined')) {

				var selector = Main.PagesSelector, handler = this, content = this.modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), title = row.data('title'), slug = row.data('slug')

					var button = row.find('.select.button');

					if (id == selector.parent_id.val()) button.addClass('positive');

					button.click(function() {

						if (selector.id) selector.submit(id); else selector.set(title, slug);

						handler.modal.modal('hide');
					});

				}).find('.icon.button').popup({ 'position': 'bottom left', 'variation': 'inverted' });

				content.removeClass('loading'); this.modal.modal('show');
			}

			this.locked = false; return null;
		},
	},

	'Menuitems' : {

		'locked' : false, 'sender' : null, 'list' : [],

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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'MenuitemsSelector' : {

		'locked' : false, 'id' : null, 'parent_id' : null, 'super_parent_id' : null,

		'button_load' : null, 'button_reset' : null,

		'init' : function() {

			this.id = parseInt($('input:hidden#menuitem-id[name=id]').val());

			this.parent_id = $('input#menuitem-parent-id'); this.super_parent_id = $('input#menuitem-super-parent-id');

			this.button_load = $('#menuitems-selector-load'); this.button_reset = $('#menuitems-selector-reset');
		},

		'submit' : function(parent_id) {

			if (this.locked) return;

			this.locked = true; this.button_load.addClass('loading'); this.button_reset.addClass('disabled');

			var data = { 'action' : 'move', 'parent_id': parent_id };

			Main.ajax(this, (install_path + '/admin/content/menuitems/edit?id=' + this.id), data);
		},

		'handle' : function(data) {

			if (data.status) return window.location.replace(install_path + '/admin/content/menuitems/edit?id=' + this.id);

			this.button_load.removeClass('loading'); this.button_reset.removeClass('disabled');

			this.locked = false; return null;
		}
	},

	'MenuitemsLoader' : {

		'locked' : false, 'modal' : null,

		'init' : function() {

			this.modal = $('#modal-lister');
		},

		'load' : function(parent_id) {

			if (this.locked) return;

			var selector = Main.MenuitemsSelector;

			parent_id = ((typeof parent_id != 'undefined') ? parseInt(parent_id) : parseInt(selector.super_parent_id.val()));

			this.locked = true; this.modal.children('.segment').addClass('loading');

			Main.ajax(this, (install_path + '/admin/content/menuitems?parent_id=' + parent_id), { 'id' : selector.id });
		},

		'handle' : function(data) {

			if (data.status && (typeof data.contents != 'undefined')) {

				var selector = Main.MenuitemsSelector, handler = this, content = this.modal.children('.segment');

				content.html(data.contents).find('table tbody tr').each(function() {

					var row = $(this), id = row.data('id'), text = row.data('text');

					var button = row.find('.select.button');

					if (id == selector.parent_id.val()) button.addClass('positive');

					button.click(function() { selector.submit(id); handler.modal.modal('hide'); });

				}).find('.icon.button').popup({ 'position': 'bottom center', 'variation': 'inverted' });

				content.removeClass('loading'); this.modal.modal('show');
			}

			this.locked = false; return null;
		}
	},

	'Variables' : {

		'locked' : false, 'sender' : null, 'list' : [],

		'init' : function() {

			var handler = this, modal = $('#variables-modal');

			var modal_input = modal.find('input'), modal_button = modal.find('button');

			modal_button.popup({ 'position': 'top center', 'variation': 'tiny inverted', 'on' : 'manual' });

			$(document).keydown(function(e) { if (e.keyCode == 27) modal_button.popup('hide'); });

			(new Clipboard('#variable-shortcode-button')).on('success', function(e) {

				modal_button.popup('show').mouseout(function() { modal_button.popup('hide'); }); e.clearSelection();
			});

			$('table#variables-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id');

				var title = row.data('title'), name = row.data('name');

				row.find('.info.button').click(function() {

					if (!handler.locked) { modal.find('input').val('$' + name + '$').select(); modal.modal('show'); }
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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'Widgets' : {

		'locked' : false, 'sender' : null, 'list' : [],

		'init' : function() {

			var handler = this, modal = $('#widgets-modal');

			var modal_input = modal.find('input'), modal_button = modal.find('button');

			modal_button.popup({ 'position': 'top center', 'variation': 'tiny inverted', 'on' : 'manual' });

			$(document).keydown(function(e) { if (e.keyCode == 27) modal_button.popup('hide'); });

			(new Clipboard('#widget-shortcode-button')).on('success', function(e) {

				modal_button.popup('show').mouseout(function() { modal_button.popup('hide'); }); e.clearSelection();
			});

			$('table#widgets-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, id = row.data('id');

				var title = row.data('title'), name = row.data('name');

				row.find('.info.button').click(function() {

					if (!handler.locked) { modal.find('input').val('{ widget:' + name + ' / }').select(); modal.modal('show'); }
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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'Filemanager' : {

		'locked' : false, 'sender' : null, 'list' : [], 'parent' : '', 'link' : '',

		'upload_form' : null, 'upload_select' : null, 'upload_submit' : null,

		'button_create' : null, 'button_reload' : null, 'modal_create' : null, 'submitted' : false,

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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.enableControls(); return null;
		}
	},

	'Addons' : {

		'locked' : false, 'sender' : null, 'list' : [],

		'init' : function() {

			var handler = this;

			$('table#addons-list tbody tr').each(function() {

				var row = $(this), index = handler.list.length, name = row.data('name');

				var install = row.find('.install.button').click(function() { handler.install(index, $(this)); });

				var uninstall = row.find('.uninstall.button').click(function() {

					if (handler.locked) return;

					var element = $(this), callback = function() { handler.uninstall(index, element); };

					Main.confirm(lang['ADDONS_CONFIRM_UNINSTALL'], name, 'negative', callback);
				});

				handler.list[index] = { 'row' : row, 'name' : name, 'install' : install, 'uninstall' : uninstall };
			});
		},

		'install' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/extend/addons'), { 'name': item.name, 'action' : 'install' });
		},

		'uninstall' : function(index, button) {

			if (this.locked || typeof this.list[index] == 'undefined') return;

			var item = this.list[index]; this.locked = true; this.sender = index; button.addClass('loading');

			Main.ajax(this, (install_path + '/admin/extend/addons'), { 'name': item.name, 'action' : 'uninstall' });
		},

		'handle' : function(data) {

			if (data.status) { window.location.reload(); return null; }

			if (typeof this.list[this.sender] != 'undefined') {

				this.list[this.sender].install.removeClass('loading');

				this.list[this.sender].uninstall.removeClass('loading');
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'Languages' : {

		'locked' : false, 'sender' : null, 'list' : [], 'section' : '',

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

			var link = (install_path + '/admin/extend/languages?list=' + this.section);

			Main.ajax(this, link, { 'name': item.name, 'action' : 'activate' });
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
	},

	'Templates' : {

		'locked' : false, 'sender' : null, 'list' : [], 'section' : '',

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

			var link = (install_path + '/admin/extend/templates?list=' + this.section);

			Main.ajax(this, link, { 'name': item.name, 'action' : 'activate' });
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
	},

	'Users' : {

		'locked' : false, 'sender' : null, 'list' : [],

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

				if (data.status) this.list[this.sender].row.remove();
			}

			this.sender = null; this.locked = false; return null;
		}
	},

	'Information' : {

		'init' : function() {

			var menu = $('#information-menu'), segments = $('#information-segments');

			menu.children('.item').click(function() {

				$(this).addClass('active').siblings().removeClass('active');

				segments.children('div').hide().filter('[data-name=' + $(this).data('segment') + ']').show();

			}).filter('[data-segment=' + window.location.hash.substring(1) + ']').click();
		}
	},

	'Editor' : {

		'init' : function() {

			this.initAce(); this.initCKEditor();
		},

		'initAce' : function() {

			var container = $('#ace-container'); if (!container.length) return;

			var textarea = container.find('textarea').hide(), holder = container.find('.holder');

			var mode = holder.data('mode'), minLines = holder.data('min-lines'), maxLines = holder.data('max-lines');

			var editor = ace.edit(holder.attr('id'));

			editor.setTheme('ace/theme/clouds'); editor.session.setMode('ace/mode/' + mode);

			editor.setOptions({ 'minLines' : minLines, 'maxLines' : maxLines });

			editor.setOptions({ 'showPrintMargin' : false, 'useWorker' : false });

			editor.renderer.setScrollMargin(5, 5, 0, 0);

			editor.setValue(textarea.val()); editor.gotoLine(1, 0);

			editor.session.on('change', function() { textarea.val(editor.getValue()); });

			container.show();
		},

		'initCKEditor' : function() {

			var container = $('#ckeditor-container'); if (!container.length) return;

			var language = $('html').attr('lang'), instanceReady = function (event) { container.show(); };

			var editor = CKEDITOR.replace('page-contents', { 'language' : language , 'on' : { 'instanceReady' : instanceReady }});

			editor.on('fileUploadRequest', function(event) {

				event.data.fileLoader.xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			});

			editor.on('fileUploadResponse', function(event) {

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
	}
};
