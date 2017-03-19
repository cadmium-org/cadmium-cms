<tr class="$class$" data-id="$id$" data-text="$text$">

	<td><i class="$icon$ icon"></i> <a onclick="Main.MenuitemsLoader.load($id$);">$text$</a></td>

	<td># $position$</td>

	<td class="right aligned">

		{ block:browse }

		<a class="ui mini $class$ icon browse button" href="$link$" target="_blank" title="%MENUITEMS_ITEM_BROWSE%" ><i class="external icon"></i></a>

		{ / block:browse }

		{ block:select }

		<a class="ui mini $class$ icon select button" title="%MENUITEMS_ITEM_SELECT%"><i class="checkmark icon"></i></a>

		{ / block:select }

	</td>

</tr>
