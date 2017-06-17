<input type="hidden" id="variable-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/variables">%TITLE_CONTENT_VARIABLES%</a>

		<div class="divider"> / </div>

		<a class="section" href="$link$">$title$</a>

	</div>

</div>

<div class="ui segment">

	<form class="ui form" method="post" action="$link$" autocomplete="off">

		<div class="field">

			<label for="variable-title">%VARIABLE_FIELD_TITLE%</label>

			{ block:field_variable_title / }

		</div>

		<div class="field">

			<label for="variable-name">%VARIABLE_FIELD_NAME%</label>

			{ block:field_variable_name / }

		</div>

		<div class="field">

			<label for="variable-value">%VARIABLE_FIELD_VALUE%</label>

			{ block:field_variable_value / }

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
