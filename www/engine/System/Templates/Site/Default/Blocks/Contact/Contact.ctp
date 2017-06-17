{ block:messages / }

<div class="ui segment">

	<div class="ui stackable grid">

		<div class="ten wide column">

			<form class="ui sided form" method="post" action="$install_path$/contact" autocomplete="off">

				<div class="field">

					<label for="contact-name">%CONTACT_FIELD_NAME%</label>

					{ block:field_contact_name / }

				</div>

				<div class="field">

					<label for="contact-email">%CONTACT_FIELD_EMAIL%</label>

					{ block:field_contact_email / }

				</div>

				<div class="field">

					<label for="contact-message">%CONTACT_FIELD_MESSAGE%</label>

					{ block:field_contact_message / }

				</div>

				<div class="field">

					<label for="contact-captcha">%CONTACT_FIELD_CAPTCHA%</label>

					{ block:field_contact_captcha / }

				</div>

				<div class="field">

					<a class="ui fluid labeled icon basic button" id="captcha">

						<i class="refresh icon"></i>

						<img class="ui centered image" width="150" height="40" src="$install_path$/captcha.png" />

					</a>

				</div>

				<div class="ui hidden divider"></div>

				<div class="field">

					<input class="ui button" type="submit" value="%CONTACT_SUBMIT%" />

				</div>

			</form>

		</div>

	</div>

</div>
