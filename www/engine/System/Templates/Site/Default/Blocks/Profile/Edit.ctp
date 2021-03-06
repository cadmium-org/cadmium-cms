<div class="ui secondary pointing menu">

	<a class="item" href="$install_path$/profile">%PROFILE_TAB_OVERVIEW%</a>

	<a class="active item" href="$install_path$/profile/edit">%PROFILE_TAB_EDIT%</a>

</div>

{ block:messages / }

<div class="ui stacked segment">

	<div class="ui two column stackable grid">

		<div class="column">

			<h4 class="ui dividing header">%PROFILE_EDIT_GROUP_PERSONAL%</h4>

			<form class="ui form" method="post" action="$install_path$/profile/edit" autocomplete="off">

				<input type="password" id="fake-password" name="fake_password" style="display:none;" />

				<div class="field">

					<label for="edit-email">%USER_FIELD_EMAIL%</label>

					{ block:field_edit_email / }

				</div>

				<div class="field">

					<label for="edit-first-name">%USER_FIELD_FIRST_NAME%</label>

					{ block:field_edit_first_name / }

				</div>

				<div class="field">

					<label for="edit-last-name">%USER_FIELD_LAST_NAME%</label>

					{ block:field_edit_last_name / }

				</div>

				<div class="field">

					<label for="edit-sex">%USER_FIELD_SEX%</label>

					{ block:field_edit_sex / }

				</div>

				<div class="field">

					<label for="edit-city">%USER_FIELD_CITY%</label>

					{ block:field_edit_city / }

				</div>

				<div class="field">

					<label for="edit-country">%USER_FIELD_COUNTRY%</label>

					{ block:field_edit_country / }

				</div>

				<div class="field">

					<label for="edit-timezone">%USER_FIELD_TIMEZONE%</label>

					{ block:field_edit_timezone / }

				</div>

				<div class="field">

					<input class="ui button" type="submit" value="%SAVE%" />

				</div>

			</form>

		</div>

		<div class="column">

			<h4 class="ui dividing header">%PROFILE_EDIT_GROUP_PASSWORD%</h4>

			<form class="ui form" method="post" action="$install_path$/profile/edit" autocomplete="off">

				<div class="field">

					<label for="edit-password">%USER_FIELD_PASSWORD_CURRENT%</label>

					{ block:field_edit_password / }

				</div>

				<div class="field">

					<label for="edit-password-new">%USER_FIELD_PASSWORD_NEW%</label>

					{ block:field_edit_password_new / }

				</div>

				<div class="field">

					<label for="edit-password-retype">%USER_FIELD_PASSWORD_RETYPE%</label>

					{ block:field_edit_password_retype / }

				</div>

				<div class="field">

					<input class="ui button" type="submit" value="%SAVE%" />

				</div>

			</form>

		</div>

	</div>

</div>
