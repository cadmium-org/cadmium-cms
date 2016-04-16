<input type="hidden" id="widget-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/widgets">%TITLE_CONTENT_WIDGETS%</a>

		<div class="divider"> / </div>

		<a class="section" href="$link$">$title$</a>

	</div>

</div>

<div class="ui segment">

	<form method="post" action="$link$" autocomplete="off">

		<div class="ui form">

			<div class="field">

				<label for="widget-title">%WIDGET_FIELD_TITLE%</label>

				{ block:field_widget_title / }

			</div>

			<div class="field">

				<label for="widget-name">%WIDGET_FIELD_NAME%</label>

				{ block:field_widget_name / }

			</div>

			<div class="field">

				<div class="ui slider checkbox">

					{ block:field_widget_active / }

					<label for="widget-active">%WIDGET_FIELD_ACTIVE%</label>

				</div>

			</div>

		</div>

		<div class="ui hidden divider"></div>

		<div id="ace-container" style="display:none;">

			<h5 class="ui header">%WIDGET_FIELD_CONTENTS%</h5>

			{ block:field_widget_contents / }

			<div class="holder" id="ace-holder" data-mode="html" data-min-lines="5" data-max-lines="20"></div>

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
