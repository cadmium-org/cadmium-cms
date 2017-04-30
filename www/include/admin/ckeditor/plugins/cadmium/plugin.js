
CKEDITOR.plugins.add('cadmium', {

	'lang' : 'en,ru,uk',

	'icons' : 'addpage,addvariable,addwidget,addfile',

	'init' : function(editor) {

		editor.addCommand('addPage', {

			'exec' : function(editor) {

				Main.PagesLoader.open(0, function(title, slug, link) {

					editor.insertHtml('<a href="' + link + '">' + title + '</a>');
				});
			}
		});

		editor.addCommand('addVariable', {

			'exec' : function(editor) {

				Main.VariablesLoader.open(function(name) {

					editor.insertHtml('$' + name + '$');
				});
			}
		});

		editor.addCommand('addWidget', {

			'exec' : function(editor) {

				Main.WidgetsLoader.open(function(name) {

					editor.insertHtml('{ widget:' + name + ' / }');
				});
			}
		});

		editor.addCommand('addFile', {

			'exec' : function(editor) {

				Main.FilesLoader.open('', function(name, path, format, mime) {

					var path_full = (install_path + '/uploads/' + path);

					if (format == 'image') {

						editor.insertHtml('<img src="' + path_full + '">');

					} else if (format == 'audio') {

						editor.insertHtml('<div class="ckeditor-html5-audio"><audio controls src="' + path_full + '" type="' + mime + '"></div>');

					} else if (format == 'video') {

						editor.insertHtml('<div class="ckeditor-html5-video"><video controls src="' + path_full + '" type="' + mime + '"></div>');

					} else {

						editor.insertHtml('<a href="' + path_full + '">' + name + '</a>');
					}
				});
			}
		});

		editor.ui.addButton('addPage', {

			'label' : editor.lang.cadmium.page,
			'command' : 'addPage',
			'toolbar' : 'page'
		});

		editor.ui.addButton('addVariable', {

			'label' : editor.lang.cadmium.variable,
			'command' : 'addVariable',
			'toolbar' : 'variable'
		});

		editor.ui.addButton('addWidget', {

			'label' : editor.lang.cadmium.widget,
			'command' : 'addWidget',
			'toolbar' : 'widget'
		});

		editor.ui.addButton('addFile', {

			'label' : editor.lang.cadmium.file,
			'command' : 'addFile',
			'toolbar' : 'file'
		});
	}
});
