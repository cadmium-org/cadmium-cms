<div class="ui segment">

	<form class="ui auth form" method="post" action="$install_path$/profile/recover?code=$code$" autocomplete="off">

		<div class="field">

			<label for="recover-password-new">%USER_FIELD_PASSWORD_NEW%</label>

			{ block:field_recover_password_new / }

		</div>

		<div class="field">

			<label for="recover-password-retype">%USER_FIELD_PASSWORD_RETYPE%</label>

			{ block:field_recover_password_retype / }

		</div>

		<div class="field">

			<input class="ui button" type="submit" value="%SUBMIT%" />

		</div>

	</form>

</div>
