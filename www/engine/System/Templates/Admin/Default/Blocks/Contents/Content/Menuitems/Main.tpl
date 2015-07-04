<input type="hidden" id="menuitem-id" name="id" value="$id$" />

<a class="ui fluid labeled icon button"

   href="/admin/content/menuitems?parent_id=$parent_id$" style="padding-left:1.5em !important;">

	<i class="left chevron icon"></i>%MENUITEMS_BACK%

</a>

<div class="ui segment">

	<div class="ui breadcrumb">

		{ for:path }

		<a class="$class$" href="/admin/content/menuitems?id=$id$">$text$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

<div class="ui segment">

	<form method="post" action="/admin/content/menuitems?id=$id$">

		<div class="ui form">

			{ block:field_parent_id / }

			{ block:parent }

			<div class="field">

				<label for="menuitem-parent-text">%MENUITEM_FIELD_PARENT%</label>

				<div class="ui action input">

					<input type="text" id="menuitem-parent-text" value="$text$" readonly="readonly" />

					<a class="ui teal icon button" onclick="Main.MenuitemsLoader.load();"><i class="search icon"></i></a>

				</div>

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

			<div class="field">

				<label for="menuitem-target">%MENUITEM_FIELD_TARGET%</label>

				{ block:field_target / }

			</div>

			<div class="field">

				<label for="menuitem-position">%MENUITEM_FIELD_POSITION%</label>

				{ block:field_position / }

			</div>

		</div>

		<div class="ui divider"></div>

		<input class="ui teal button" type="submit" value="%SAVE%" />

	</form>

</div>
