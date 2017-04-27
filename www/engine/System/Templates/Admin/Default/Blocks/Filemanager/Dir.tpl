<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/filemanager/$origin$">$title$</a>

		<i class="divider"> / </i>

		{ for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager/$origin$?parent=$path$">$name$</a>

		<i class="divider"> / </i>

		{ / for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager/$origin$/dir?parent=$parent$&name=$name$">$name$</a>

	</div>

</div>

<div class="ui form segment">

	<h4 class="ui dividing header">%FILEMANAGER_DIR_NAME%</h4>

	<form method="post" action="$install_path$/admin/content/filemanager/$origin$/dir?parent=$parent$&name=$name$" autocomplete="off">

		<div class="ui fluid action input field">

			{ block:field_rename_name / }

			<button class="ui teal button" type="submit">%RENAME%</button>

		</div>

	</form>

</div>

{ block:info }

<table class="ui table segment">

	<thead>

		<tr>

			<th colspan="2">%FILEMANAGER_DIR_INFO%</th>

		</tr>

	</thead>

	<tbody>

		<tr>

			<td>%FILEMANAGER_DIR_ROW_TIME_CREATED%</td>

			<td>$time_created$</td>

		</tr>

		<tr>

			<td>%FILEMANAGER_DIR_ROW_TIME_MODIFIED%</td>

			<td>$time_modified$</td>

		</tr>

		<tr>

			<td>%FILEMANAGER_DIR_ROW_PERMISSIONS%</td>

			<td>$permissions$</td>

		</tr>

	</tbody>

</table>

{ / block:info }
