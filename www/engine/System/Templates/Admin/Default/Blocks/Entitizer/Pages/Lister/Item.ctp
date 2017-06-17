<tr class="$class$" data-id="$id$" data-title="$title$" data-slug="$slug$">

	<td><i class="$icon$ icon"></i> <a href="$install_path$/admin/content/pages?parent_id=$id$">$title$</a></td>

	<td>$access$</td>

	<td class="right aligned">

		{ block:create }

		<a class="ui mini $class$ icon button" href="$install_path$/admin/content/pages/create?id=$id$" title="%PAGES_ITEM_CREATE_SUB%"><i class="plus icon"></i></a>

		{ / block:create }

		<a class="ui mini positive icon button" href="$install_path$/admin/content/pages/edit?id=$id$" title="%PAGES_ITEM_EDIT%"><i class="edit icon"></i></a>

		{ block:browse }

		<a class="ui mini $class$ icon button" href="$link$" target="_blank" title="%PAGES_ITEM_BROWSE%"><i class="external icon"></i></a>

		{ / block:browse }

		{ block:remove }

		<a class="ui mini $class$ icon remove button" title="%PAGES_ITEM_REMOVE%"><i class="remove icon"></i></a>

		{ / block:remove }

	</td>

</tr>
