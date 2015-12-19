<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/filemanager">Uploads</a>

		<i class="divider"> / </i>

		{ for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager?parent=$path$">$name$</a>

		<i class="divider"> / </i>

		{ / for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager/file?parent=$parent$&name=$name$">$name$</a>

	</div>

</div>

<div class="ui form segment">

	<h4 class="ui dividing header">%FILEMANAGER_FILE_NAME%</h4>

	<form method="post" action="$install_path$/admin/content/filemanager/file?parent=$parent$&name=$name$" autocomplete="off">

		<div class="ui fluid action input field">

			{ block:field_rename_name / }

			<button class="ui teal button" type="submit">%RENAME%</button>

		</div>

	</form>

	{ block:info }

	<h4 class="ui dividing header">%FILEMANAGER_FILE_INFO%</h4>

	<table class="ui table">

		<tbody>

			<tr>

				<td>%FILEMANAGER_FILE_ROW_TIME_CREATED%</td>

				<td>$time_created$</td>

			</tr>

			<tr>

				<td>%FILEMANAGER_FILE_ROW_TIME_MODIFIED%</td>

				<td>$time_modified$</td>

			</tr>

			<tr>

				<td>%FILEMANAGER_FILE_ROW_PERMISSIONS%</td>

				<td>$permissions$</td>

			</tr>

			<tr>

				<td>%FILEMANAGER_FILE_ROW_SIZE%</td>

				<td>$size$</td>

			</tr>

			<tr>

				<td>%FILEMANAGER_FILE_ROW_MIME%</td>

				<td>$mime$</td>

			</tr>

		</tbody>

	</table>

	{ / block:info }

</div>
