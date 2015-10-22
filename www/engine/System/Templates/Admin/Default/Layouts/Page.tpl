<div class="ui left vertical inverted sidebar menu"></div>

<div class="pusher">

	<nav class="ui page grid fixed inverted main menu">

		<a class="brand item" id="menu-brand" href="$install_path$/admin">

			<img src="$install_path$/include/admin/templates/default/images/brand.png" />

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

					<a class="item" href="$install_path$/admin/system/users/edit?id=$id$"><i class="user icon"></i>%TITLE_PROFILE%</a>

					<a class="item" href="$install_path$/admin/logout"><i class="sign out icon"></i>%LOGOUT%</a>

				</div>

			</div>

			{ block:site }

			<a class="item" href="$install_path$/" target="_blank" id="section-button" title="%SECTION_SITE%"><i class="globe icon"></i></a>

			{ / block:site }

		</div>

		{ / block:user }

	</nav>

	<div class="ui one column page grid wrapper">

		<div class="column">

			<h3 class="ui header segment">$title$</h3>

			{ block:messages / }

			{ block:contents / }

			<div class="ui hidden divider"></div>

			<div class="ui two column stackable grid">

				<div class="nine wide column">

					<a class="ui small basic labeled icon button" href="$cadmium_home$" target="_blank">

						<i class="copyright icon"></i>

						Copyright $cadmium_copy$ <b>$cadmium_name$</b>

					</a>

					<a class="ui small disabled button">ver. $cadmium_version$</a>

				</div>

				<div class="seven wide right aligned column">

					{ block:language }

					<div class="ui left bottom pointing dropdown small button">

						<div class="text"><i class="$country$ flag"></i>$title$</div>

						<div class="menu">

							{ for:items }

							<a class="item" href="?language=$name$"><i class="$country$ flag"></i>$title$</a>

							{ / for:items }

						</div>

					</div>

					{ / block:language }

					{ block:template }

					<div class="ui left bottom pointing dropdown small button">

						<div class="text"><i class="theme icon"></i>$title$</div>

						<div class="menu">

							{ for:items }

							<a class="item" href="?template=$name$"><i class="theme icon"></i>$title$</a>

							{ / for:items }

						</div>

					</div>

					{ / block:template }

				</div>

			</div>

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
