<input type="hidden" id="menuitem-id" name="id" value="$id$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="/admin/content/menuitems">%TITLE_CONTENT_MENUITEMS%</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" href="/admin/content/menuitems?id=$id$">$text$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

{ block:parent }

<div class="ui stackable menu">

	<a class="item" href="/admin/content/menuitems?parent_id=$id$"><i class="list icon"></i> %MENUITEMS_ITEM_LIST%</a>

	{ block:create }

	<a class="$class$" href="/admin/content/menuitems/create?id=$id$"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ / block:create }

	{ block:edit }

	<a class="$class$" href="/admin/content/menuitems/edit?id=$id$"><i class="edit icon"></i> %MENUITEMS_ITEM_EDIT%</a>

	{ / block:edit }

	{ block:browse }

	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %MENUITEMS_ITEM_BROWSE%</a>

	{ / block:browse }

</div>

{ / block:parent }

<div class="ui segment">

	<form method="post" action="$link$" autocomplete="off">

		<div class="ui form">

			{ block:selector }

			<div class="field">

				<label for="menuitem-parent-text">%MENUITEM_FIELD_PARENT%</label>

				<div class="ui action input">

					<input type="text" id="menuitem-parent-text" value="$text$" placeholder="%NONE%" readonly="readonly" />

					<a class="ui teal icon button" onclick="Main.MenuitemsLoader.load();"><i class="search icon"></i></a>

				</div>

			</div>

			{ / block:selector }

			{ block:field_menuitem_parent_id / }

			<div class="field">

				<label for="menuitem-text">%MENUITEM_FIELD_TEXT%</label>

				<div class="ui action input">

					{ block:field_menuitem_text / }

					<a class="ui teal icon button" onclick="Main.PagesLoader.load();"><i class="file text outline icon"></i></a>

				</div>

			</div>

			<div class="field">

				<label for="menuitem-link">%MENUITEM_FIELD_LINK%</label>

				{ block:field_menuitem_link / }

			</div>

			<div class="field">

				<label for="menuitem-target">%MENUITEM_FIELD_TARGET%</label>

				{ block:field_menuitem_target / }

			</div>

			<div class="field">

				<label for="menuitem-position">%MENUITEM_FIELD_POSITION%</label>

				{ block:field_menuitem_position / }

			</div>

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
