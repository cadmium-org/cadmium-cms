<div class="ui stackable menu">

	<a class="item" href="$install_path$/admin/content/widgets/create"><i class="add icon"></i> %WIDGETS_ITEM_CREATE%</a>

</div>

<table class="ui table" id="widgets-list">

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

{ block:pagination / }

<div class="ui small modal" id="widgets-modal">

	<i class="close icon"></i>

	<div class="header">%MODAL_HEADER_INFO%</div>

	<div class="content">

		<p>%WIDGETS_ITEM_INFO_TEXT%</p>

		<div class="ui fluid action input">

			<input type="text" id="widget-shortcode" readonly="readonly" value="" />

			<button class="ui icon button" id="widget-shortcode-button" data-clipboard-target="#widget-shortcode"

				data-content="%COPIED%"><i class="copy icon"></i></button>

		</div>

	</div>

	<div class="actions">

		<div class="ui black deny button">%CLOSE%</div>

	</div>

</div>
