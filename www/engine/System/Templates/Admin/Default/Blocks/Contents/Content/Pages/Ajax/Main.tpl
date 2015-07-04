<div class="ui top attached segment">

	<div class="ui breadcrumb">

		<a class="section" onclick="Main.PagesLoader.load(0);">%TITLE_CONTENT_PAGES%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="$class$" onclick="Main.PagesLoader.load($id$);">$title$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

<div class="ui bottom attached stackable menu">

	<a class="item" onclick="Main.PagesLoader.select($id$, '$title$');"><i class="checkmark icon"></i> %PAGES_ITEM_SELECT%</a>

</div>

<table class="ui table">

	<thead>

		<tr>

			<th class="ten wide">%PAGES_COLUMN_TITLE%</th>

			<th class="six wide" colspan="2">%PAGES_COLUMN_ACCESS%</th>

		</tr>

	</thead>

	<tbody>

		{ block:list }

		<tr class="disabled">

			<td colspan="3">%PAGES_NOT_FOUND%</td>

		</tr>

		{ / block:list }

	</tbody>

</table>
