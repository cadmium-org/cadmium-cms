<div class="ui stackable menu">

	<a class="item" href="$install_path$/admin/content/variables/create"><i class="add icon"></i> %VARIABLES_ITEM_CREATE%</a>

</div>

<table class="ui table" id="variables-list">

	<thead>

		<tr>

			<th class="eight wide">%VARIABLES_COLUMN_TITLE%</th>

			<th class="eight wide" colspan="2">%VARIABLES_COLUMN_VALUE%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%VARIABLES_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>

{ block:pagination / }
