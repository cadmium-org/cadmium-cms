<div class="ui segment">

	<form class="ui auth form" method="post" action="/profile/reset" autocomplete="off">

		<div class="field">

			<label for="reset-name">%USER_FIELD_NAME%</label>

			{ block:field_reset_name / }

		</div>

		<div class="field">

			<label for="reset-captcha">%USER_FIELD_CAPTCHA%</label>

			{ block:field_reset_captcha / }

		</div>

		<div class="field">

			<a class="ui fluid labeled icon basic button" id="captcha">

				<i class="refresh icon"></i>

				<img class="ui centered image" width="150" height="40" src="/captcha.png" />

			</a>

		</div>

		<div class="field">

			<input class="ui button" type="submit" value="%RESET%" />

		</div>

	</form>

</div>
