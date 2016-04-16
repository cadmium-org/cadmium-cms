{ block:messages / }

<div class="ui segment">

	<form class="ui auth form" method="post" action="$install_path$/profile/register" autocomplete="off">

		<div class="field">

			<label for="register-name">%USER_FIELD_NAME%</label>

			{ block:field_register_name / }

		</div>

		<div class="field">

			<label for="register-password">%USER_FIELD_PASSWORD%</label>

			{ block:field_register_password / }

		</div>

		<div class="field">

			<label for="register-password-retype">%USER_FIELD_PASSWORD_RETYPE%</label>

			{ block:field_register_password_retype / }

		</div>

		<div class="field">

			<label for="register-email">%USER_FIELD_EMAIL%</label>

			{ block:field_register_email / }

		</div>

		<div class="field">

			<label for="register-captcha">%USER_FIELD_CAPTCHA%</label>

			{ block:field_register_captcha / }

		</div>

		<div class="field">

			<a class="ui fluid labeled icon basic button" id="captcha">

				<i class="refresh icon"></i>

				<img class="ui centered image" width="150" height="40" src="$install_path$/captcha.png" />

			</a>

		</div>

		<div class="field">

			<input class="ui button" type="submit" value="%REGISTER%" />

		</div>

	</form>

</div>
