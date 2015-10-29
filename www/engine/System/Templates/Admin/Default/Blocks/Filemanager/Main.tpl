<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/filemanager">Uploads</a>

		<i class="divider"> / </i>

		{ for:path }

		<a class="section" href="$install_path$/admin/content/filemanager?dir=$dir$">$name$</a>

		<i class="divider"> / </i>

		{ / for:path }

	</div>

</div>

<table class="ui table" id="files-list">

	<thead>

		<tr>

			<th class="ten wide">%FILEMANAGER_COLUMN_NAME%</th>

			<th class="six wide" colspan="2">%FILEMANAGER_COLUMN_SIZE%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%FILEMANAGER_FILES_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>

{ block:pagination / }
