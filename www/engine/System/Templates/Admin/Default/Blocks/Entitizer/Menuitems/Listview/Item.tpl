<tr data-id="$id$" data-text="$text$">

	<td><i class="$icon$ icon"></i> <a href="$install_path$/admin/content/menuitems?parent_id=$id$">$text$</a></td>

	<td># $position$</td>

	<td class="right aligned">

		<a class="ui mini positive icon button" href="$install_path$/admin/content/menuitems/edit?id=$id$" title="%MENUITEMS_ITEM_EDIT%"><i class="edit icon"></i></a>

		{ block:browse }

		<a class="ui mini $class$ icon button" href="$link$" title="%MENUITEMS_ITEM_BROWSE%" target="_blank"><i class="external icon"></i></a>

		{ / block:browse }

		{ block:remove }

		<a class="ui mini $class$ icon button" data-action="remove" title="%MENUITEMS_ITEM_REMOVE%"><i class="remove icon"></i></a>

		{ / block:remove }

	</td>

</tr>
