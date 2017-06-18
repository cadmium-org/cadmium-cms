<div class="ui stackable menu" id="information-menu">

	<a class="active item" href="#common" data-segment="common">%INFORMATION_TAB_COMMON%</a>

	<a class="item" href="#php" data-segment="php">%INFORMATION_TAB_PHP%</a>

	<a class="item" href="#diagnostics" data-segment="diagnostics">%INFORMATION_TAB_DIAGNOSTICS%</a>

</div>

<div id="information-segments">

	<div data-name="common">

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_SERVER%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="desktop icon"></i> %INFORMATION_ROW_OS_VERSION%</td>

					<td>$os_version$</td>

				</tr>

				<tr>

					<td><i class="server icon"></i> %INFORMATION_ROW_PHP_VERSION%</td>

					<td>$php_version$</td>

				</tr>

				<tr>

					<td><i class="database icon"></i> %INFORMATION_ROW_MYSQL_VERSION%</td>

					<td>$mysql_version$</td>

				</tr>

			</tbody>

		</table>

		<table class="ui fixed table segment">

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

				<tr>

					<td><i class="bug icon"></i> %INFORMATION_ROW_DEBUG_MODE%</td>

					<td><div class="ui small $debug_mode_class$ label">$debug_mode_value$</div></td>

				</tr>

			</tbody>

		</table>

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_THIRD_PARTY%</th>

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

				<tr>

					<td><i class="puzzle icon"></i> %INFORMATION_ROW_ACE_VERSION%</td>

					<td>$ace_version$</td>

				</tr>

			</tbody>

		</table>

	</div>

	<div data-name="php" style="display:none;">

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_ERRORS%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="angle right icon"></i> display_errors</td>

					<td><div class="ui small $display_errors_class$ label">$display_errors_value$</div></td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> display_startup_errors</td>

					<td><div class="ui small $display_startup_errors_class$ label">$display_startup_errors_value$</div></td>

				</tr>

			</tbody>

		</table>

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_FILE_UPLOADS%</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td><i class="angle right icon"></i> file_uploads</td>

					<td><div class="ui small $file_uploads_class$ label">$file_uploads_value$</div></td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> upload_max_filesize</td>

					<td>$upload_max_filesize$</td>

				</tr>

				<tr>

					<td><i class="angle right icon"></i> post_max_size</td>

					<td>$post_max_size$</td>

				</tr>

			</tbody>

		</table>

	</div>

	<div data-name="diagnostics" style="display:none;">

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_EXTENSIONS%</th>

				</tr>

			</thead>

			<tbody>

				{ for:extensions }

				<tr>

					<td><i class="cube icon"></i> $name$</td>

					<td><div class="ui small $class$ label">$value$</div></td>

				</tr>

				{ / for:extensions }

			</tbody>

		</table>

		<table class="ui fixed table segment">

			<thead>

				<tr>

					<th colspan="2">%INFORMATION_GROUP_DIRS%</th>

				</tr>

			</thead>

			<tbody>

				{ for:dirs }

				<tr>

					<td><i class="folder icon"></i> $name$</td>

					<td><div class="ui small $class$ label">$value$</div></td>

				</tr>

				{ / for:dirs }

			</tbody>

		</table>

	</div>

</div>
