<div class="ui stackable menu">

	<a class="item" href="$install_path$/admin/content/widgets/create"><i class="add icon"></i> %WIDGETS_ITEM_CREATE%</a>

</div>

<table class="ui table" id="widgets-list">

	<thead>

		<tr>

			<th class="eight wide">%WIDGETS_COLUMN_TITLE%</th>

			<th class="eight wide" colspan="2">%WIDGETS_COLUMN_DISPLAY%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%WIDGETS_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>

{ block:pagination / }
