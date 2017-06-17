<div class="ui basic segment">

	<a class="section" onclick="Main.WidgetsLoader.load(0);">%TITLE_CONTENT_WIDGETS%</a>

</div>

<table class="ui table">

	<thead>

		<tr>

			<th class="twelve wide">%WIDGETS_COLUMN_TITLE%</th>

			<th class="four wide">&nbsp;</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="2">%WIDGETS_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>
