<input type="hidden" id="filemanager-dir" name="dir" value="$dir$" />

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

<div class="ui stackable menu">

	<div class="item">

		<div class="ui transparent icon input" id="filemanager-dir-create">

			<input type="text" placeholder="%FILEMANAGER_DIR_CREATE%" />

			<i class="add link icon submitter"></i>

		</div>

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
