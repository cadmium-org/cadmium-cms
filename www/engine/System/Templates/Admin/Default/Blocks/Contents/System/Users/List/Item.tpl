<tr data-id="$id$" data-name="$name$">
	
	<td><i class="user icon"></i> $name$</td>
	
	<td>$rank$</td>
	
	<td class="right aligned">
		
		<a class="ui mini positive icon button" href="/admin/system/users?id=$id$" title="%USERS_ITEM_EDIT%"><i class="edit icon"></i></a>
		
		{ block:remove }
		
		<a class="ui mini $class$ icon button" data-action="remove" title="%USERS_ITEM_REMOVE%"><i class="remove icon"></i></a>
		
		{ / block:remove }
		
	</td>
	
</tr>