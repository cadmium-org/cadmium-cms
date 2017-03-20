<div class="ui left vertical inverted sidebar menu"></div>

<div class="ui teal progress" id="loader" style="display:none;">

	<div class="bar"></div>

</div>

<div class="pusher">

	<nav class="ui page grid fixed inverted main menu">

		<a class="brand item" href="$install_path$/admin">

			<img src="$install_path$/include/admin/templates/$template_name$/images/brand.png" />

		</a>

		<a class="launcher icon item"><i class="sidebar icon"></i></a>

		{ block:menu / }

		<div class="right menu">

			{ block:user }

			<div class="ui user dropdown item">

				<img class="ui right spaced avatar image" src="http://www.gravatar.com/avatar/$gravatar$?s=28&d=mm" />

				<b class="name">$name$</b><i class="dropdown icon"></i>

				<div class="menu">

					<a class="item" href="$install_path$/admin/system/users/edit?id=$id$"><i class="user icon"></i>%TITLE_PROFILE%</a>

					<a class="item logout" href="$install_path$/admin?logout"><i class="sign out icon"></i>%LOGOUT%</a>

				</div>

			</div>

			{ / block:user }

			<a class="section icon item" href="$index_page$" target="_blank" title="%SECTION_SITE%"><i class="globe icon"></i></a>

		</div>

	</nav>

	<div class="ui page grid wrapper">

		<div class="column">

			<h3 class="ui header segment" id="title">$title$</h3>

			<div id="container">

				{ block:messages / }

				{ block:popup / }

				{ block:contents / }

			</div>

			<div class="ui hidden divider"></div>

			{ block:language }

			<div class="ui left bottom small pointing dropdown button" id="language-button">

				<div class="text"><i class="$country$ flag"></i>$title$</div>

				<div class="menu"></div>

			</div>

			<div class="ui small loading disabled basic button" id="language-loader" style="display:none;">&nbsp;</div>

			{ / block:language }

			<a class="ui small right floated basic copyright button" href="$cadmium_home$" target="_blank">

				&copy; <span class="year">$cadmium_copy$ <b>$cadmium_name$</b></span>

			</a>

			<a class="ui small right floated disabled version button">v. $cadmium_version$</a>

		</div>

	</div>

	<div class="ui large modal" id="modal-lister">

		<i class="close icon"></i>

		<div class="ui basic segment"></div>

	</div>

	<div class="ui small modal" id="modal-confirm">

		<i class="close icon"></i>

		<div class="header">%MODAL_HEADER_CONFIRM%</div>

		<div class="content"></div>

		<div class="actions">

			<div class="ui black deny button">%NO%</div>

			<div class="ui right labeled icon approve button"><i class="remove icon"></i>%YES%</div>

		</div>

	</div>

	<div class="ui small modal" id="modal-info">

		<i class="close icon"></i>

		<div class="header">%MODAL_HEADER_INFO%</div>

		<div class="content"></div>

		<div class="actions">

			<div class="ui black deny button">%CLOSE%</div>

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
