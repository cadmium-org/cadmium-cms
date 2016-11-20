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

<div class="ui small modal" id="variables-modal">

	<i class="close icon"></i>

	<div class="header">%MODAL_HEADER_INFO%</div>

	<div class="content">

		<p>%VARIABLES_ITEM_INFO_TEXT%</p>

		<div class="ui fluid action input">

			<input type="text" id="variable-shortcode" readonly="readonly" value="" />

			<button class="ui icon button" id="variable-shortcode-button" data-clipboard-target="#variable-shortcode"

				data-content="%COPIED%"><i class="copy icon"></i></button>

		</div>

	</div>

	<div class="actions">

		<div class="ui black deny button">%CLOSE%</div>

	</div>

</div>
