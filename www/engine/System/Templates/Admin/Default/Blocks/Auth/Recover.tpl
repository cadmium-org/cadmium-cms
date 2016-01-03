<form class="ui form" method="post" action="$install_path$/admin/recover?code=$code$" autocomplete="off">

	<div class="field">

		<div class="ui left icon input">

			{ block:field_recover_password_new / }

			<i class="privacy icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_recover_password_retype / }

			<i class="privacy icon"></i>

		</div>

	</div>

	<div class="field">

		<input class="ui fluid teal button" type="submit" value="%SUBMIT%" />

	</div>

</form>
