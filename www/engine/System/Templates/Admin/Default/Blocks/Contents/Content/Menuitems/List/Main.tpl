<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="/admin/content/menuitems">%TITLE_CONTENT_MENUITEMS%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="$class$" href="/admin/content/menuitems?parent_id=$id$">$text$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

<div class="ui stackable menu">

	<a class="item" id="menuitem-create-toggler"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ block:actions }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %MENUITEMS_ITEM_BROWSE%</a>

	<a class="item" href="/admin/content/menuitems?id=$id$"><i class="edit icon"></i> %MENUITEMS_ITEM_EDIT%</a>

	{ / block:actions }

</div>

<form class="ui form segment" id="menuitem-create-form" method="post" action="/admin/content/menuitems?parent_id=$id$#create" style="display:none;">

	{ block:parent }

	<div class="field">

		<label for="menuitem-parent-text">%MENUITEM_FIELD_PARENT%</label>

		<input type="text" id="menuitem-parent-text" value="$text$" readonly="readonly" />

	</div>

	{ / block:parent }

	<div class="field">

		<label for="menuitem-text">%MENUITEM_FIELD_TEXT%</label>

		{ block:field_text / }

	</div>

	<div class="field">

		<label for="menuitem-link">%MENUITEM_FIELD_LINK%</label>

		{ block:field_link / }

	</div>

	<div class="ui divider"></div>

	<input class="ui teal button" type="submit" value="%SAVE%" />

</form>

<table class="ui table" id="menuitems-list">

	<thead>

		<tr>

			<th class="ten wide">%MENUITEMS_COLUMN_TEXT%</th>

			<th class="six wide" colspan="2">%MENUITEMS_COLUMN_POSITION%</th>

		</tr>

	</thead>

	<tbody>

		{ block:list }

		<tr class="disabled">

			<td colspan="3">%MENUITEMS_NOT_FOUND%</td>

		</tr>

		{ / block:list }

	</tbody>

</table>

{ block:pagination / }
