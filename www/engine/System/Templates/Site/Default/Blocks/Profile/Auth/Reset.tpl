{ block:messages / }

<div class="ui segment">

	<div class="ui stackable grid">

		<div class="ten wide column">

			<form class="ui sided form" method="post" action="$install_path$/profile/reset" autocomplete="off">

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

						<img class="ui centered image" width="150" height="40" src="$install_path$/captcha.png" />

					</a>

				</div>

				<div class="ui hidden divider"></div>

				<div class="field">

					<input class="ui button" type="submit" value="%RESET%" />

				</div>

			</form>

		</div>

	</div>

</div>
