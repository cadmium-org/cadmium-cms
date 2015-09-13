<div class="ui menu">

	{ for:sections }

	<a href="/admin/extend/templates?list=$name$" class="$class$">$title$</a>

	{ / for:sections }

</div>

<input type="hidden" id="templates-section" name="section" value="$section$" />

<table class="ui unstackable table" id="templates-list">

	<thead>

		<tr>

			<th colspan="2">%TEMPLATES_INSTALLED%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td>%TEMPLATES_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>
