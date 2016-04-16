<input type="hidden" id="filemanager-parent" name="parent" value="$parent$" />

<div class="ui segment">

	<div class="ui breadcrumb">

		<a class="section" href="$install_path$/admin/content/filemanager">Uploads</a>

		<i class="divider"> / </i>

		{ for:breadcrumbs }

		<a class="section" href="$install_path$/admin/content/filemanager?parent=$path$">$name$</a>

		<i class="divider"> / </i>

		{ / for:breadcrumbs }

	</div>

</div>

<div class="ui uploader segment">

	<form id="filemanager-upload-form" method="post" action="$link$" enctype="multipart/form-data" accept-charset="utf-8">

		<input type="file" name="upload" />

	</form>

	<div class="ui two column stackable grid">

		<div class="left aligned column">

			<div class="ui buttons" id="filemanager-upload">

				<a class="ui grey button" id="filemanager-upload-select">%FILEMANAGER_UPLOAD_SELECT%</a>

				<a class="ui teal icon button" id="filemanager-upload-submit"><i class="upload icon"></i></a>

			</div>

		</div>

		<div class="right aligned column">

			<div class="ui basic buttons">

				<a class="ui icon button" id="filemanager-button-create" title="%FILEMANAGER_ACTION_CREATE%"><i class="add icon"></i></a>

				<a class="ui icon button" id="filemanager-button-reload" title="%FILEMANAGER_ACTION_RELOAD%"><i class="refresh icon"></i></a>

			</div>

		</div>

	</div>

</div>

<div class="ui small modal" id="filemanager-modal-create">

	<i class="close icon"></i>

	<div class="header">%FILEMANAGER_ACTION_CREATE%</div>

	<div class="content">

		<form class="ui form" method="post" action="$link$" autocomplete="off">

			<div class="field">{ block:field_create_type / }</div>

			<div class="field">{ block:field_create_name / }</div>

		</form>

	</div>

	<div class="actions">

		<a class="ui black deny button">%CANCEL%</a>

		<a class="ui positive right labeled icon approve button"><i class="checkmark icon"></i>%CREATE%</a>

	</div>

</div>

<table class="ui table" id="filemanager-list">

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
