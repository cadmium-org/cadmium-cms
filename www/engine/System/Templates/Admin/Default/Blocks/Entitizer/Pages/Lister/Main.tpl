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

	<a class="active item" href="$install_path$/admin/content/pages?parent_id=$id$"><i class="list icon"></i> %PAGES_ITEM_LIST%</a>

	{ block:create }

	<a class="item" href="$install_path$/admin/content/pages/create?id=$id$"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>

	{ / block:create }

	{ ! block:create_disabled }

	<a class="disabled item"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>

	{ / block:create_disabled }

	{ block:edit }

	<a class="item" href="$install_path$/admin/content/pages/edit?id=$id$"><i class="edit icon"></i> %PAGES_ITEM_EDIT%</a>

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

<table class="ui table" id="pages-list">

	<thead>

		<tr>

			<th class="eight wide">%PAGES_COLUMN_TITLE%</th>

			<th class="eight wide" colspan="2">%PAGES_COLUMN_ACCESS%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%PAGES_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>

{ block:pagination / }
