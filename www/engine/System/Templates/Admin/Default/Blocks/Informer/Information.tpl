<table class="ui table">

	<thead>

		<tr>

			<th colspan="2">%INFORMATION_GROUP_SERVER%</th>

		</tr>

	</thead>

	<tbody>

		<tr>

			<td class="four wide">%INFORMATION_ROW_OS_VERSION%</td>

			<td>$os_version$</td>

		</tr>

		<tr>

			<td class="four wide">%INFORMATION_ROW_PHP_VERSION%</td>

			<td>$php_version$</td>

		</tr>

		<tr>

			<td class="four wide">%INFORMATION_ROW_MYSQL_VERSION%</td>

			<td>$mysql_version$</td>

		</tr>

	</tbody>

</table>

<table class="ui table">

	<thead>

		<tr>

			<th colspan="2">%INFORMATION_GROUP_SYSTEM%</th>

		</tr>

	</thead>

	<tbody>

		<tr>

			<td class="four wide">%INFORMATION_ROW_SYSTEM_VERSION%</td>

			<td>$system_version$</td>

		</tr>

		{ block:debug_mode }

		<tr>

			<td class="four wide">%INFORMATION_ROW_DEBUG_MODE%</td>

			<td><div class="ui small $class$ label">$text$</div></td>

		</tr>

		{ / block:debug_mode }

	</tbody>

</table>

<table class="ui table">

	<thead>

		<tr>

			<th colspan="2">%INFORMATION_GROUP_EXTERNAL%</th>

		</tr>

	</thead>

	<tbody>

		<tr>

			<td class="four wide">%INFORMATION_ROW_JQUERY_VERSION%</td>

			<td>$jquery_version$</td>

		</tr>

		<tr>

			<td class="four wide">%INFORMATION_ROW_SEMANTIC_UI_VERSION%</td>

			<td>$semantic_ui_version$</td>

		</tr>

		<tr>

			<td class="four wide">%INFORMATION_ROW_CKEDITOR_VERSION%</td>

			<td>$ckeditor_version$</td>

		</tr>

	</tbody>

</table>
