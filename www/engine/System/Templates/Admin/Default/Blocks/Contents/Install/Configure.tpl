<div class="ui left aligned segment">

	<form class="ui form" method="post" action="/install.php?checked=1">

		<div class="field">

            <label for="install-site-title">%SETTINGS_FIELD_SITE_TITLE%</label>

			{ block:field_site_title / }

		</div>

		<div class="field">

            <label for="install-system-url">%SETTINGS_FIELD_SYSTEM_URL%</label>

			{ block:field_system_url / }

		</div>

		<div class="field">

            <label for="install-system-timezone">%SETTINGS_FIELD_SYSTEM_TIMEZONE%</label>

			{ block:field_system_timezone / }

		</div>

		<div class="field">

            <label for="install-admin-email">%SETTINGS_FIELD_SYSTEM_EMAIL%</label>

			{ block:field_system_email / }

		</div>

		<h4 class="ui dividing header">%INSTALL_GROUP_DATABASE%</h4>

		<div class="field">

            <label for="install-database-server">%INSTALL_FIELD_DATABASE_SERVER%</label>

			{ block:field_database_server / }

		</div>

		<div class="field">

            <label for="install-database-user">%INSTALL_FIELD_DATABASE_USER%</label>

			{ block:field_database_user / }

		</div>

		<div class="field">

            <label for="install-database-password">%INSTALL_FIELD_DATABASE_PASSWORD%</label>

			{ block:field_database_password / }

		</div>

		<div class="field">

            <label for="install-database-name">%INSTALL_FIELD_DATABASE_NAME%</label>

			{ block:field_database_name / }

		</div>

		<div class="field">

			<input class="ui fluid teal button" type="submit" value="%SUBMIT%" />

		</div>

	</form>

</div>
