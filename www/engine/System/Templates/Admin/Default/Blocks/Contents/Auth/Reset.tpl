<div class="ui segment">

	<form class="ui form" method="post" action="/admin/reset">

		<div class="field">

			<div class="ui left icon input">

				{ block:field_name / }

				<i class="user icon"></i>

			</div>

		</div>

		<div class="field">

			<div class="ui left icon input">

				{ block:field_captcha / }

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

			<input class="ui fluid teal button" type="submit" value="%RESET%" />

		</div>

		<div class="field">

			<a class="ui fluid basic button" href="/admin/login">%LOGIN%</a>

		</div>

	</form>

</div>
