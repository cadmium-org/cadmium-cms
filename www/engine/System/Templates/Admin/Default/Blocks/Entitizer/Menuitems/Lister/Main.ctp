<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/menuitems">%TITLE_CONTENT_MENUITEMS%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" href="$install_path$/admin/content/menuitems?parent_id=$id$">$text$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui stackable menu">

	<a class="active item" href="$install_path$/admin/content/menuitems?parent_id=$id$"><i class="list icon"></i> %MENUITEMS_ITEM_LIST%</a>

	{ block:create }

	<a class="item" href="$install_path$/admin/content/menuitems/create?id=$id$"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ / block:create }

	{ ! block:create_disabled }

	<a class="disabled item"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ / block:create_disabled }

	{ block:edit }

	<a class="item" href="$install_path$/admin/content/menuitems/edit?id=$id$"><i class="edit icon"></i> %MENUITEMS_ITEM_EDIT%</a>

	{ / block:edit }

	{ ! block:edit_disabled }

	<a class="disabled item"><i class="edit icon"></i> %MENUITEMS_ITEM_EDIT%</a>

	{ / block:edit_disabled }

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %MENUITEMS_ITEM_BROWSE%</a>

	{ / block:browse }

	{ ! block:browse_disabled }

	<a class="disabled item"><i class="external icon"></i> %MENUITEMS_ITEM_BROWSE%</a>

	{ / block:browse_disabled }

</div>

{ / block:parent }

<table class="ui table segment" id="menuitems-list">

	<thead>

		<tr>

			<th class="eight wide">%MENUITEMS_COLUMN_TEXT%</th>

			<th class="eight wide" colspan="2">%MENUITEMS_COLUMN_POSITION%</th>

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

{ block:pagination / }
