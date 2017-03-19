
CKEDITOR.plugins.add('cadmium', {

	'lang' : 'en,ru,uk',

	'icons' : 'addpage,addvariable,addwidget',

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

		editor.ui.addButton('addPage', {

			'label' : editor.lang.cadmium.page,
			'command' : 'addPage',
			'toolbar' : 'cadmium'
		});

		editor.ui.addButton('addVariable', {

			'label' : editor.lang.cadmium.variable,
			'command' : 'addVariable',
			'toolbar' : 'cadmium'
		});

		editor.ui.addButton('addWidget', {

			'label' : editor.lang.cadmium.widget,
			'command' : 'addWidget',
			'toolbar' : 'cadmium'
		});
	}
});
