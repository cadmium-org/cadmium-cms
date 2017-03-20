<div class="ui basic segment">

	<a class="section" onclick="Main.VariablesLoader.load(0);">%TITLE_CONTENT_VARIABLES%</a>

</div>

<table class="ui table">

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
