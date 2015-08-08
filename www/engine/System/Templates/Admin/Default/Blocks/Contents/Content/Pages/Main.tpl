<input type="hidden" id="page-id" name="id" value="$id$" />

<a class="ui fluid labeled icon button"

   href="/admin/content/pages?parent_id=$parent_id$" style="padding-left:1.5em !important;">

	<i class="left chevron icon"></i>%PAGES_BACK%

</a>

<div class="ui segment">

	<div class="ui breadcrumb">

		{ for:path }

		<a class="$class$" href="/admin/content/pages?id=$id$">$title$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

<div class="ui segment">

	<form method="post" action="/admin/content/pages?id=$id$">

		<div class="ui form">

			{ block:field_page_parent_id / }

			{ block:parent }

			<div class="field">

				<label for="page-parent-title">%PAGE_FIELD_PARENT%</label>

				<div class="ui action input">

					<input type="text" id="page-parent-title" value="$title$" readonly="readonly" />

					<a class="ui teal icon button" onclick="Main.PagesLoader.load();"><i class="search icon"></i></a>

				</div>

			</div>

			{ / block:parent }

			<div class="field">

				<label for="page-title">%PAGE_FIELD_TITLE%</label>

				{ block:field_page_title / }

			</div>

			<div class="field">

				<label for="page-name">%PAGE_FIELD_NAME%</label>

				{ block:field_page_name / }

			</div>

            <div class="field">

				<label for="page-visibility">%PAGE_FIELD_VISIBILITY%</label>

				{ block:field_page_visibility / }

			</div>

			<div class="field">

				<label for="page-access">%PAGE_FIELD_ACCESS%</label>

				{ block:field_page_access / }

			</div>

			<div class="ui hidden divider"></div>

			<div class="ui accordion">

				<h4 class="ui dividing header title">

					<i class="icon dropdown"></i>%PAGE_GROUP_ADDITIONAL%

				</h4>

				<div class="content">

					<div class="field">

						<label for="page-description">%PAGE_FIELD_DESCRIPTION%</label>

						{ block:field_page_description / }

					</div>

					<div class="field">

						<label for="page-keywords">%PAGE_FIELD_KEYWORDS%</label>

						{ block:field_page_keywords / }

					</div>

					<div class="field">

						<div class="ui slider checkbox">

							{ block:field_page_robots_index / }

							<label for="page-robots-index">%PAGE_FIELD_ROBOTS_INDEX%</label>

						</div>

					</div>

					<div class="field">

						<div class="ui slider checkbox">

							{ block:field_page_robots_follow / }

							<label for="page-robots-follow">%PAGE_FIELD_ROBOTS_FOLLOW%</label>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="ui hidden divider"></div>

		<div id="editor-container" style="display:none;">

			{ block:field_page_contents / }

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
