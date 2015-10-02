<form class="ui form" method="post" action="/admin/register" autocomplete="off">

	<div class="field">

		<div class="ui left icon input">

			{ block:field_register_name / }

			<i class="user icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_register_password / }

			<i class="lock icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_register_password_retype / }

			<i class="lock icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_register_email / }

			<i class="at icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_register_captcha / }

			<i class="protect icon"></i>

		</div>

	</div>

	<div class="field">

		<a class="ui fluid labeled icon basic button" id="captcha">

			<i class="refresh icon"></i>

			<img class="ui centered image" width="150" height="40" src="/captcha.png" />

		</a>

	</div>

	<div class="field">

		<input class="ui fluid teal button" type="submit" value="%REGISTER%" />

	</div>

</form>
