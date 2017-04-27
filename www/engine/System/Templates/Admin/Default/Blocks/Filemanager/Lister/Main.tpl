<input type="hidden" id="filemanager-parent" name="parent" value="$parent$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/filemanager/$origin$">$title$</a>

		<i class="divider"> / </i>

		{ for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager/$origin$?parent=$path$">$name$</a>

		<i class="divider"> / </i>

		{ / for:breadcrumbs }

	</div>

</div>

{ block:bar }

<div class="ui managebar segment">

	<div class="ui two column stackable grid">

		<form class="left aligned upload column" method="post" action="$link$" enctype="multipart/form-data" accept-charset="utf-8">

			<input type="file" name="upload" value="" />

			<div class="ui buttons">

				<a class="ui grey select button">%FILEMANAGER_UPLOAD_SELECT%</a>

				<a class="ui teal disabled icon submit button"><i class="upload icon"></i></a>

			</div>

		</form>

		<form class="right aligned create column" method="post" action="$link$" autocomplete="off">

			<div class="ui action input field">

				{ block:field_create_name / }

				<a class="ui icon create button" title="%FILEMANAGER_ACTION_CREATE%"><i class="add icon"></i></a>

				<a class="ui icon reload button" title="%FILEMANAGER_ACTION_RELOAD%"><i class="refresh icon"></i></a>

			</div>

		</form>

	</div>

</div>

{ / block:bar }

<table class="ui table segment" id="filemanager-list">

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

{ block:pagination / }
