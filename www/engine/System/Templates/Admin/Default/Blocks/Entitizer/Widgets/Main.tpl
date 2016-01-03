<input type="hidden" id="widget-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/widgets">%TITLE_CONTENT_WIDGETS%</a>

		<div class="divider"> / </div>

		<a class="section" href="$link$">$title$</a>

	</div>

</div>

<div class="ui segment">

	<form class="ui form" method="post" action="$link$" autocomplete="off">

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

				{ block:field_widget_display / }

				<label for="widget-display">%WIDGET_FIELD_DISPLAY%</label>

			</div>

		</div>

		<div class="field">

			<label for="widget-contents">%WIDGET_FIELD_CONTENTS%</label>

			{ block:field_widget_contents / }

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
