<div class="ui top attached segment">

	<div class="ui breadcrumb">

		<a class="section" onclick="Main.PagesLoader.load(0);">%TITLE_CONTENT_PAGES%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" onclick="Main.PagesLoader.load($id$);">$title$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui bottom attached stackable menu">

	<a class="item" onclick="Main.PagesLoader.select($id$, '$title$');"><i class="checkmark icon"></i> %PAGES_ITEM_SELECT%</a>

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %PAGES_ITEM_BROWSE%</a>

	{ / block:browse }

</div>

{ / block:parent }

<table class="ui table">

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
