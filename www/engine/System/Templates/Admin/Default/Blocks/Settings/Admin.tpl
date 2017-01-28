<div class="ui menu">

	<a class="item" href="/admin/system/settings">%SETTINGS_TAB_COMMON%</a>

	<a class="active item" href="/admin/system/settings/admin">%SETTINGS_TAB_ADMIN%</a>

</div>

<form class="ui form segment" method="post" action="$install_path$/admin/system/settings/admin" autocomplete="off">

	<div class="ui two column stackable grid">

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_MAIN%</h4>

			<div class="field">

				<label for="settings-admin-language">%SETTINGS_FIELD_ADMIN_LANGUAGE%</label>

				{ block:field_settings_admin_language / }

			</div>

			<div class="field">

				<label for="settings-admin-template">%SETTINGS_FIELD_ADMIN_TEMPLATE%</label>

				{ block:field_settings_admin_template / }

			</div>

		</div>

		<div class="column">

			<h4 class="ui dividing header">%SETTINGS_GROUP_APPEARANCE%</h4>

			<div class="field">

				<label for="settings-admin-display-entities">%SETTINGS_FIELD_ADMIN_DISPLAY_ENTITIES%</label>

				{ block:field_settings_admin_display_entities / }

			</div>

			<div class="field">

				<label for="settings-admin-display-files">%SETTINGS_FIELD_ADMIN_DISPLAY_FILES%</label>

				{ block:field_settings_admin_display_files / }

			</div>

		</div>

	</div>

	<div class="ui divider"></div>

	<input class="ui teal button" type="submit" value="%SAVE%" />

</form>
