<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="robots" content="NOINDEX,FOLLOW" />

		<title>$title$</title>

		<link rel="icon" type="image/png" href="$install_path$/include/favicon.png" />

		<link rel="stylesheet" type="text/css" href="$install_path$/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="$install_path$/admin/assets/$template_name$/styles/main.css" />

		<script src="$install_path$/include/common/jquery.core.js"></script>

		<script src="$install_path$/include/semantic/semantic.min.js"></script>

		<script src="$install_path$/include/ace/ace.js"></script>

		<script src="$install_path$/include/ckeditor/ckeditor.js"></script>

		<script src="$install_path$/admin/assets/$template_name$/scripts/view.js"></script>
		<script src="$install_path$/admin/assets/$template_name$/scripts/main.js"></script>

		<script>

			var install_path = '$install_path$';

			var lang = {

				'AJAX_ERROR_400':                   '%AJAX_RESPONSE_ERROR_400%',
				'AJAX_ERROR_404':                   '%AJAX_RESPONSE_ERROR_404%',
				'AJAX_ERROR_500':                   '%AJAX_RESPONSE_ERROR_500%',
				'AJAX_ERROR_ABORT':                 '%AJAX_RESPONSE_ERROR_ABORT%',
				'AJAX_ERROR_PARSER':                '%AJAX_RESPONSE_ERROR_PARSER%',
				'AJAX_ERROR_STATUS':                '%AJAX_RESPONSE_ERROR_STATUS%',
				'AJAX_ERROR_TIMEOUT':               '%AJAX_RESPONSE_ERROR_TIMEOUT%',
				'AJAX_ERROR_UNKNOWN':               '%AJAX_RESPONSE_ERROR_UNKNOWN%',

				'PAGES_CONFIRM_REMOVE':             '%PAGES_ITEM_CONFIRM_REMOVE%',
				'MENUITEMS_CONFIRM_REMOVE':         '%MENUITEMS_ITEM_CONFIRM_REMOVE%',
				'VARIABLES_CONFIRM_REMOVE':         '%VARIABLES_ITEM_CONFIRM_REMOVE%',
				'WIDGETS_CONFIRM_REMOVE':           '%WIDGETS_ITEM_CONFIRM_REMOVE%',

				'FILEMANAGER_CONFIRM_DIR_REMOVE':   '%FILEMANAGER_CONFIRM_DIR_REMOVE%',
				'FILEMANAGER_CONFIRM_FILE_REMOVE':  '%FILEMANAGER_CONFIRM_FILE_REMOVE%',

				'ADDONS_CONFIRM_UNINSTALL':         '%ADDONS_ITEM_CONFIRM_UNINSTALL%',

				'USERS_CONFIRM_REMOVE':             '%USERS_ITEM_CONFIRM_REMOVE%'
			};

			$(function() { View.init(); Main.init(); });

		</script>

	</head>

	<body>

		{ block:layout / }

	</body>

</html>
