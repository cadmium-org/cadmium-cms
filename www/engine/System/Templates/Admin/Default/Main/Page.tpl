<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="robots" content="NOINDEX,FOLLOW" />

		<title>$head_title$</title>

		<link rel="icon" type="image/png" href="/include/admin/favicon.png" />

		<link rel="stylesheet" type="text/css" href="/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="/include/admin/templates/default/styles/main.css" />

		<script src="/include/common/jquery.core.js"></script>

		<script src="/include/semantic/semantic.min.js"></script>

		<script src="/include/admin/editor/ckeditor.js"></script>

		<script src="/include/admin/scripts/main.js"></script>

		<script>

			var lang = {

				"AJAX_ERROR_400":			"%AJAX_RESPONSE_ERROR_400%",
				"AJAX_ERROR_404":			"%AJAX_RESPONSE_ERROR_404%",
				"AJAX_ERROR_500":			"%AJAX_RESPONSE_ERROR_500%",
				"AJAX_ERROR_ABORT":			"%AJAX_RESPONSE_ERROR_ABORT%",
				"AJAX_ERROR_PARSER":		"%AJAX_RESPONSE_ERROR_PARSER%",
				"AJAX_ERROR_STATUS":		"%AJAX_RESPONSE_ERROR_STATUS%",
				"AJAX_ERROR_TIMEOUT":		"%AJAX_RESPONSE_ERROR_TIMEOUT%",
				"AJAX_ERROR_UNKNOWN":		"%AJAX_RESPONSE_ERROR_UNKNOWN%",

				"PAGES_CONFIRM_REMOVE":		"%PAGES_ITEM_CONFIRM_REMOVE%",
				"MENUITEMS_CONFIRM_REMOVE":	"%MENUITEMS_ITEM_CONFIRM_REMOVE%",
				"USERS_CONFIRM_REMOVE":		"%USERS_ITEM_CONFIRM_REMOVE%"
			};

			$(document).ready(function() { Main.init(); });

		</script>

	</head>

	<body>

		<div class="ui left vertical inverted sidebar menu"></div>

		<div class="pusher">

			<nav class="ui page grid fixed inverted main menu">

				<a class="brand item" id="menu-brand" href="/admin">

					<img src="/include/admin/templates/default/images/brand.png" />

				</a>

				<a class="item" id="menu-launcher" style="display:none;"><i class="bars icon"></i></a>

				<div class="menu" id="menu-items" style="display:none; padding:0;">

					{ block:menu / }

				</div>

				{ block:user }

				<div class="right menu">

					<div class="ui dropdown item">

						<img class="ui right spaced avatar image" src="http://www.gravatar.com/avatar/$gravatar$?s=28&d=mm" />

						<b>$name$</b><i class="dropdown icon"></i>

						<div class="menu">

							<a class="item" href="/admin/system/users?id=$id$"><i class="user icon"></i>%TITLE_PROFILE%</a>

							<a class="item" href="/admin/logout"><i class="sign out icon"></i>%LOGOUT%</a>

						</div>

					</div>

					{ block:site }

					<a class="item" href="/" target="_blank" id="section-button" title="%SECTION_SITE%"><i class="globe icon"></i></a>

					{ / block:site }

				</div>

				{ / block:user }

			</nav>

			<div class="ui one column page grid wrapper">

				<div class="column">

					<h3 class="ui header segment">$title$</h3>

					{ block:messages / }

					{ block:contents / }

					<div class="ui basic segment">

						$cadmium_copy$ &copy; <a class="copy" href="$cadmium_home$" target="_blank">$cadmium_name$</a> - $cadmium_version$

					</div>

				</div>

			</div>

			<div class="ui long large modal" id="modal-lister">

				<i class="close icon"></i>

				<div class="ui basic segment"></div>

			</div>

			<div class="ui small modal" id="modal-confirm">

				<i class="close icon"></i>

				<div class="header">%MODAL_HEADER_CONFIRM%</div>

				<div class="content"></div>

				<div class="actions">

					<div class="ui deny black button">%MODAL_ACTION_NO%</div>

					<div class="ui negative approve right labeled icon button"><i class="remove icon"></i>%MODAL_ACTION_YES%</div>

				</div>

			</div>

			<div class="ui small modal" id="modal-error">

				<i class="close icon"></i>

				<div class="header">%MODAL_HEADER_ERROR%</div>

				<div class="content"></div>

			</div>

		</div>

		{ block:report }

		<script>

			console.log('%REPORT_SCRIPT_TIME%: $script_time$');

			console.log('%REPORT_DB_TIME%: $db_time$');

		</script>

		{ / block:report }

	</body>

</html>
