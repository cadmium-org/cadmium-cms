<div class="ui menu" id="information-menu">

	<a class="active item" data-segment="common">%INFORMATION_TAB_COMMON%</a>

	<a class="item" data-segment="php">%INFORMATION_TAB_PHP%</a>

</div>

<div id="information-segments">

	<div data-name="common">

		<table class="ui fixed table">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_SERVER%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="server icon"></i> %INFORMATION_ROW_OS_VERSION%</td>

					<td>$os_version$</td>

				</tr>

				<tr>

					<td><i class="settings icon"></i> %INFORMATION_ROW_PHP_VERSION%</td>

					<td>$php_version$</td>

				</tr>

				<tr>

					<td><i class="database icon"></i> %INFORMATION_ROW_MYSQL_VERSION%</td>

					<td>$mysql_version$</td>

				</tr>

			</tbody>

		</table>

		<table class="ui fixed table">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_SYSTEM%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="setting icon"></i> %INFORMATION_ROW_SYSTEM_VERSION%</td>

					<td>$system_version$</td>

				</tr>

				{ block:debug_mode }

				<tr>

					<td><i class="bug icon"></i> %INFORMATION_ROW_DEBUG_MODE%</td>

					<td><div class="ui small $class$ label">$text$</div></td>

				</tr>

				{ / block:debug_mode }

			</tbody>

		</table>

		<table class="ui fixed table">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_EXTERNAL%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="puzzle icon"></i> %INFORMATION_ROW_JQUERY_VERSION%</td>

					<td>$jquery_version$</td>

				</tr>

				<tr>

					<td><i class="puzzle icon"></i> %INFORMATION_ROW_SEMANTIC_UI_VERSION%</td>

					<td>$semantic_ui_version$</td>

				</tr>

				<tr>

					<td><i class="puzzle icon"></i> %INFORMATION_ROW_CKEDITOR_VERSION%</td>

					<td>$ckeditor_version$</td>

				</tr>

			</tbody>

		</table>

	</div>

	<div data-name="php" style="display:none;">

		<table class="ui fixed table">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_PHP_ERRORS%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="angle right icon"></i> display_errors</td>

					<td>$php_display_errors$</td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> display_startup_errors</td>

					<td>$php_display_startup_errors$</td>

				</tr>

			</tbody>

		</table>

		<table class="ui fixed table">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_PHP_FILE_UPLOADS%</th>

				</tr>

			</thead>

				<tr>

					<td><i class="angle right icon"></i> file_uploads</td>

					<td>$php_file_uploads$</td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> upload_max_filesize</td>

					<td>$php_upload_max_filesize$</td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> post_max_size</td>

					<td>$php_post_max_size$</td>

				</tr>

			</tbody>

		</table>

	</div>

</div>
