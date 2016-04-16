<input type="hidden" id="page-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/pages">%TITLE_CONTENT_PAGES%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" href="$install_path$/admin/content/pages?parent_id=$id$">$title$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui stackable menu">

	<a class="item" href="$install_path$/admin/content/pages?parent_id=$id$"><i class="list icon"></i> %PAGES_ITEM_LIST%</a>

	{ block:create }

	<a class="$class$" href="$install_path$/admin/content/pages/create?id=$id$"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>

	{ / block:create }

	{ ! block:create_disabled }

	<a class="disabled item"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>

	{ / block:create_disabled }

	{ block:edit }

	<a class="$class$" href="$install_path$/admin/content/pages/edit?id=$id$"><i class="edit icon"></i> %PAGES_ITEM_EDIT%</a>

	{ / block:edit }

	{ ! block:edit_disabled }

	<a class="disabled item"><i class="edit icon"></i> %PAGES_ITEM_EDIT%</a>

	{ / block:edit_disabled }

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %PAGES_ITEM_BROWSE%</a>

	{ / block:browse }

	{ ! block:browse_disabled }

	<a class="disabled item"><i class="external icon"></i> %PAGES_ITEM_BROWSE%</a>

	{ / block:browse_disabled }

</div>

{ / block:parent }

<div class="ui segment">

	{ ! block:locked }

	<div class="ui warning message">%PAGE_WARNING_NAME_DUPLICATE%</div>

	{ / block:locked }

	<form method="post" action="$link$" autocomplete="off">

		<div class="ui form">

			{ block:selector }

			<div class="field">

				<label for="page-parent-title">%PAGE_FIELD_PARENT%</label>

				<div class="ui action input">

					<input type="hidden" id="page-parent-id" value="$parent_id$" />

					<input type="hidden" id="page-super-parent-id" value="$super_parent_id$" />

					<input type="text" value="$title$" placeholder="%NONE%" readonly="readonly" />

					<a class="ui teal icon button" id="pages-selector-load" onclick="Main.PagesLoader.load();"><i class="search icon"></i></a>

					<a class="ui teal icon button" id="pages-selector-reset" onclick="Main.PagesSelector.submit(0);"><i class="close icon"></i></a>

				</div>

			</div>

			{ / block:selector }

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

		<div id="ckeditor-container" style="display:none;">

			{ block:field_page_contents / }

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
