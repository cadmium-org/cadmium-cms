<tr data-id="$id$" data-title="$title$">

	<td><i class="$icon$ icon"></i> <a href="/admin/content/pages?parent_id=$id$">$title$</a></td>

	<td>$access$</td>

	<td class="right aligned">

		<a class="ui mini positive icon button" href="/admin/content/pages/edit?id=$id$" title="%PAGES_ITEM_EDIT%"><i class="edit icon"></i></a>

		{ block:browse }

		<a class="ui mini $class$ icon button" href="$link$" title="%PAGES_ITEM_BROWSE%" target="_blank"><i class="external icon"></i></a>

		{ / block:browse }

		{ block:remove }

		<a class="ui mini $class$ icon button" data-action="remove" title="%PAGES_ITEM_REMOVE%"><i class="remove icon"></i></a>

		{ / block:remove }

	</td>

</tr>
