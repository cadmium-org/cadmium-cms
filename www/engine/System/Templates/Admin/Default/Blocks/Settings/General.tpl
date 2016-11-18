<form class="ui form segment" method="post" action="$install_path$/admin/system/settings" autocomplete="off">

	<div class="ui two column stackable grid">

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_SITE%</h4>

			<div class="field">

				<label for="settings-site-title">%SETTINGS_FIELD_SITE_TITLE%</label>

				{ block:field_settings_site_title / }

			</div>

			<div class="field">

				<label for="settings-site-slogan">%SETTINGS_FIELD_SITE_SLOGAN%</label>

				{ block:field_settings_site_slogan / }

			</div>

			<div class="field">

				<label for="settings-site-status">%SETTINGS_FIELD_SITE_STATUS%</label>

				{ block:field_settings_site_status / }

			</div>

			<div class="field">

				<label for="settings-site-description">%SETTINGS_FIELD_SITE_DESCRIPTION%</label>

				{ block:field_settings_site_description / }

			</div>

			<div class="field">

				<label for="settings-site-keywords">%SETTINGS_FIELD_SITE_KEYWORDS%</label>

				{ block:field_settings_site_keywords / }

			</div>

		</div>

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_SYSTEM%</h4>

			<div class="field">

				<label for="settings-system-url">%SETTINGS_FIELD_SYSTEM_URL%</label>

				{ block:field_settings_system_url / }

			</div>

			<div class="field">

				<label for="settings-system-email">%SETTINGS_FIELD_SYSTEM_EMAIL%</label>

				{ block:field_settings_system_email / }

			</div>

			<div class="field">

				<label for="settings-system-timezone">%SETTINGS_FIELD_SYSTEM_TIMEZONE%</label>

				{ block:field_settings_system_timezone / }

			</div>

			<h4 class="ui dividing header">%SETTINGS_GROUP_ADMIN%</h4>

			<div class="field">

				<label for="settings-admin-language">%SETTINGS_FIELD_ADMIN_LANGUAGE%</label>

				{ block:field_settings_admin_language / }

			</div>

			<div class="field">

				<label for="settings-admin-template">%SETTINGS_FIELD_ADMIN_TEMPLATE%</label>

				{ block:field_settings_admin_template / }

			</div>

		</div>

	</div>

	<div class="ui divider"></div>

	<input class="ui teal button" type="submit" value="%SAVE%" />

</form>
