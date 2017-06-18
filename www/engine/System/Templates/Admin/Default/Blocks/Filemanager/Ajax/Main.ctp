<div class="ui basic segment">

	<div class="ui breadcrumb">

		<a class="section" onclick="Main.FilesLoader.load();">$title$</a>

		<i class="divider"> / </i>

		{ for:breadcrumbs }

		<a class="section" onclick="Main.FilesLoader.load('$path$');">$name$</a>

		<i class="divider"> / </i>

		{ / for:breadcrumbs }

	</div>

</div>

<table class="ui table">

	<thead>

		<tr>

			<th class="ten wide">%FILEMANAGER_COLUMN_NAME%</th>

			<th class="six wide" colspan="2">%FILEMANAGER_COLUMN_SIZE%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%FILEMANAGER_ITEMS_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>
