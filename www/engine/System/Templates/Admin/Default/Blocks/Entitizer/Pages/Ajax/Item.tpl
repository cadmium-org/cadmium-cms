<tr class="$class$" data-id="$id$" data-title="$title$" data-slug="$slug$">

	<td><i class="$icon$ icon"></i> <a href="#" onclick="Main.PagesLoader.load($id$);">$title$</a></td>

	<td>$access$</td>

	<td class="right aligned">

		{ block:browse }

		<a class="ui mini $class$ icon button" href="$link$" target="_blank" title="%PAGES_ITEM_BROWSE%" ><i class="external icon"></i></a>

		{ / block:browse }

		{ block:select }

		<a class="ui mini $class$ icon select button" title="%PAGES_ITEM_SELECT%"><i class="checkmark icon"></i></a>

		{ / block:select }

	</td>

</tr>
