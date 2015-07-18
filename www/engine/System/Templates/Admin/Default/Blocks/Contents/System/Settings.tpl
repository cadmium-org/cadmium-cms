<form class="ui form segment" method="post" action="/admin/system/settings">

	<div class="ui two column stackable grid">

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_SITE%</h4>

			<div class="field">

				<label for="settings-site-title">%SETTINGS_FIELD_SITE_TITLE%</label>

				{ block:field_site_title / }

			</div>

			<div class="field">

				<label for="settings-site-status">%SETTINGS_FIELD_SITE_STATUS%</label>

				{ block:field_site_status / }

			</div>

			<div class="field">

				<label for="settings-site-description">%SETTINGS_FIELD_SITE_DESCRIPTION%</label>

				{ block:field_site_description / }

			</div>

			<div class="field">

				<label for="settings-site-keywords">%SETTINGS_FIELD_SITE_KEYWORDS%</label>

				{ block:field_site_keywords / }

			</div>

		</div>

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_SYSTEM%</h4>

			<div class="field">

				<label for="settings-system-url">%SETTINGS_FIELD_SYSTEM_URL%</label>

				{ block:field_system_url / }

			</div>

			<div class="field">

				<label for="settings-system-timezone">%SETTINGS_FIELD_SYSTEM_TIMEZONE%</label>

				{ block:field_system_timezone / }

			</div>

			<div class="field">

				<label for="settings-admin-email">%SETTINGS_FIELD_SYSTEM_EMAIL%</label>

				{ block:field_system_email / }

			</div>

			<h4 class="ui dividing header">%SETTINGS_GROUP_EXTRA%</h4>

			<div class="field">

				<div class="ui slider checkbox">

					{ block:field_users_registration / }

					<label for="settings-users-registration">%SETTINGS_FIELD_USERS_REGISTRATION%</label>

				</div>

			</div>

		</div>

	</div>

	<div class="ui divider"></div>

	<input class="ui teal button" type="submit" value="%SAVE%" />

</form>
