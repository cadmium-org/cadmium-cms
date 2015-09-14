<div class="ui top attached segment">

	<div class="ui breadcrumb">

		<a class="section" onclick="Main.MenuitemsLoader.load(0);">%TITLE_CONTENT_MENUITEMS%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" onclick="Main.MenuitemsLoader.load($id$);">$text$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui bottom attached stackable menu">

	<a class="item" onclick="Main.MenuitemsLoader.select($id$, '$text$');"><i class="checkmark icon"></i> %MENUITEMS_ITEM_SELECT%</a>

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %MENUITEMS_ITEM_BROWSE%</a>

	{ / block:browse }

</div>

{ / block:parent }

<table class="ui table">

	<thead>

		<tr>

			<th class="ten wide">%MENUITEMS_COLUMN_TEXT%</th>

			<th class="six wide" colspan="2">%MENUITEMS_COLUMN_POSITION%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%MENUITEMS_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>