<div class="ui stackable menu">

	<a class="item" href="/admin/system/users/create"><i class="add icon"></i> %USERS_ITEM_CREATE%</a>

</div>

<table class="ui table" id="users-list">

	<thead>

		<tr>

			<th class="eight wide">%USERS_COLUMN_NAME%</th>

			<th class="eight wide" colspan="2">%USERS_COLUMN_RANK%</th>

		</tr>

	</thead>

	<tbody>

		{ block:items }

		<tr class="disabled">

			<td colspan="3">%USERS_NOT_FOUND%</td>

		</tr>

		{ / block:items }

	</tbody>

</table>

{ block:pagination / }
