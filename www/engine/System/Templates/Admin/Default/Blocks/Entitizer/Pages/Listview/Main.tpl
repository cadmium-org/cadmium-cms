<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="/admin/content/pages">%TITLE_CONTENT_PAGES%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" href="/admin/content/pages?parent_id=$id$">$title$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui stackable menu">

	<a class="active item" href="/admin/content/pages?parent_id=$id$"><i class="list icon"></i> %PAGES_ITEM_LIST%</a>

	{ block:create }

	<a class="item" href="/admin/content/pages/create?id=$id$"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>

	{ / block:create }

	{ block:edit }

	<a class="item" href="/admin/content/pages/edit?id=$id$"><i class="edit icon"></i> %PAGES_ITEM_EDIT%</a>

	{ / block:edit }

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %PAGES_ITEM_BROWSE%</a>

	{ / block:browse }

</div>

{ / block:parent }

<table class="ui table" id="pages-list">

	<thead>

		<tr>

			<th class="ten wide">%PAGES_COLUMN_TITLE%</th>

			<th class="six wide" colspan="2">%PAGES_COLUMN_ACCESS%</th>

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
