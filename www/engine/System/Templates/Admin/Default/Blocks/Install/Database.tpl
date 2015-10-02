<form class="ui form" method="post" action="/install.php?checked=1">

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
