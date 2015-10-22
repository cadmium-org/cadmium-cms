<form class="ui form" method="post" action="$install_path$/admin/login" autocomplete="off">

	<div class="field">

		<div class="ui left icon input">

			{ block:field_login_name / }

			<i class="user icon"></i>

		</div>

	</div>

	<div class="field">

		<div class="ui left icon input">

			{ block:field_login_password / }

			<i class="lock icon"></i>

		</div>

	</div>

	<div class="field">

		<input class="ui fluid teal button" type="submit" value="%LOGIN%" />

	</div>

	<div class="field">

		<a class="ui fluid basic button" href="$install_path$/admin/reset">%RESET%</a>

	</div>

</form>
