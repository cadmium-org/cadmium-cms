<input type="hidden" id="menuitem-id" name="id" value="$id$" />

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

	<a class="item" href="$install_path$/admin/content/menuitems?parent_id=$id$"><i class="list icon"></i> %MENUITEMS_ITEM_LIST%</a>

	{ block:create }

	<a class="$class$" href="$install_path$/admin/content/menuitems/create?id=$id$"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ / block:create }

	{ ! block:create_disabled }

	<a class="disabled item"><i class="add icon"></i> %MENUITEMS_ITEM_CREATE%</a>

	{ / block:create_disabled }

	{ block:edit }

	<a class="$class$" href="$install_path$/admin/content/menuitems/edit?id=$id$"><i class="edit icon"></i> %MENUITEMS_ITEM_EDIT%</a>

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

<div class="ui segment">

	<form method="post" action="$link$" autocomplete="off">

		<div class="ui form">

			{ block:selector }

			<div class="field">

				<label for="menuitem-parent-text">%MENUITEM_FIELD_PARENT%</label>

				<div class="ui action input">

					<input type="hidden" id="menuitem-parent-id" value="$parent_id$" />

					<input type="hidden" id="menuitem-super-parent-id" value="$super_parent_id$" />

					<input type="text" value="$text$" placeholder="%NONE%" readonly="readonly" />

					<a class="ui teal icon button" id="menuitems-selector-load" onclick="Main.MenuitemsLoader.open();"><i class="search icon"></i></a>

					<a class="ui teal icon button" id="menuitems-selector-reset" onclick="Main.MenuitemsSelector.submit(0);"><i class="close icon"></i></a>

				</div>

			</div>

			{ / block:selector }

			<div class="field">

				<label for="menuitem-text">%MENUITEM_FIELD_TEXT%</label>

				<div class="ui action input">

					{ block:field_menuitem_text / }

					<a class="ui teal icon button" onclick="Main.PagesLoader.open();"><i class="file text outline icon"></i></a>

				</div>

			</div>

			<div class="field">

				<label for="menuitem-slug">%MENUITEM_FIELD_SLUG%</label>

				{ block:field_menuitem_slug / }

			</div>

			<div class="field">

				<label for="menuitem-target">%MENUITEM_FIELD_TARGET%</label>

				{ block:field_menuitem_target / }

			</div>

			<div class="field">

				<div class="ui slider checkbox">

					{ block:field_menuitem_active / }

					<label for="menuitem-active">%MENUITEM_FIELD_ACTIVE%</label>

				</div>

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
