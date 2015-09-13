<input type="hidden" id="user-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="/admin/system/users">%TITLE_SYSTEM_USERS%</a>

		<div class="divider"> / </div>

		<a class="section" href="$link$">$title$</a>

	</div>

</div>

<div class="ui segment">

	<form class="ui form" method="post" action="$link$" autocomplete="off">

		<div class="ui stackable grid">

			<div class="two column row">

				<div class="column">

					<div class="field">

						<label for="user-name">%USER_FIELD_NAME%</label>

						{ block:field_user_name / }

					</div>

					<div class="field">

						<label for="user-email">%USER_FIELD_EMAIL%</label>

						{ block:field_user_email / }

					</div>

					<div class="field">

						<label for="user-rank">%USER_FIELD_RANK%</label>

						{ block:field_user_rank / }

					</div>

					<div class="field">

						<label for="user-first-name">%USER_FIELD_FIRST_NAME%</label>

						{ block:field_user_first_name / }

					</div>

					<div class="field">

						<label for="user-last-name">%USER_FIELD_LAST_NAME%</label>

						{ block:field_user_last_name / }

					</div>

					<div class="field">

						<label for="user-sex">%USER_FIELD_SEX%</label>

						{ block:field_user_sex / }

					</div>

					<div class="field">

						<label for="user-city">%USER_FIELD_CITY%</label>

						{ block:field_user_city / }

					</div>

					<div class="field">

						<label for="user-country">%USER_FIELD_COUNTRY%</label>

						{ block:field_user_country / }

					</div>

					<div class="field">

						<label for="user-timezone">%USER_FIELD_TIMEZONE%</label>

						{ block:field_user_timezone / }

					</div>

				</div>

				<div class="column">

					<div class="field">

						<label for="user-password">%USER_FIELD_PASSWORD%</label>

						{ block:field_user_password / }

					</div>

					<div class="field">

						<label for="user-password-retype">%USER_FIELD_PASSWORD_RETYPE%</label>

						{ block:field_user_password_retype / }

					</div>

				</div>

			</div>

			<div class="ui divider"></div>

			<div class="row">

				<div class="column">

					<input class="ui teal button" type="submit" value="%SAVE%" />

				</div>

			</div>

		</div>

	</form>

</div>

{ block:info }

<table class="ui table">

	<tbody>

		<tr>

			<td>%USERS_ITEM_INFO_ROW_TIME_REGISTERED%:</td>

			<td>$time_registered$</td>

		</tr>

		<tr>

			<td>%USERS_ITEM_INFO_ROW_TIME_LOGGED%:</td>

			<td>$time_logged$</td>

		</tr>

	</tbody>

</table>

{ / block:info }
