<div class="ui segment">

	<form class="ui auth form" method="post" action="$install_path$/profile/login" autocomplete="off">

		<div class="field">

			<label for="login-name">%USER_FIELD_NAME%</label>

			{ block:field_login_name / }

		</div>

		<div class="field">

			<label for="login-password">%USER_FIELD_PASSWORD%</label>

			{ block:field_login_password / }

		</div>

		<div class="field">

			<input class="ui button" type="submit" value="%LOGIN%" />

			<a class="ui basic button" href="$install_path$/profile/reset">%RESET_TEXT%</a>

		</div>

	</form>

</div>
