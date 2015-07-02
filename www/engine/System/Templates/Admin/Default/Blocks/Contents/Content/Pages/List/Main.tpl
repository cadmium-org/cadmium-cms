<div class="ui segment">
	
	<div class="ui breadcrumb">
		
		<a class="section" href="/admin/content/pages">%TITLE_CONTENT_PAGES%</a>
		
		<i class="divider"> / </i>
		
		{ for:path }
		
		<a class="$class$" href="/admin/content/pages?parent_id=$id$">$title$</a>
		
		<i class="divider"> / </i>
		
		{ / for:path }
		
	</div>
	
</div>

<div class="ui stackable menu">
	
	<a class="item" id="page-create-toggler"><i class="add icon"></i> %PAGES_ITEM_CREATE%</a>
	
	{ block:actions }
	
	<a class="item" href="$link$" target="_blank"><i class="external icon"></i> %PAGES_ITEM_BROWSE%</a>
	
	<a class="item" href="/admin/content/pages?id=$id$"><i class="edit icon"></i> %PAGES_ITEM_EDIT%</a>
	
	{ / block:actions }
	
</div>

<form class="ui form segment" id="page-create-form" method="post" action="/admin/content/pages?parent_id=$id$#create" style="display:none;">
	
	{ block:parent }
	
	<div class="field">
		
		<label for="page-parent-title">%PAGE_FIELD_PARENT%</label>
		
		<input type="text" id="page-parent-title" value="$title$" readonly="readonly" />
		
	</div>
	
	{ / block:parent }
	
	<div class="field">
		
		<label for="page-title">%PAGE_FIELD_TITLE%</label>
		
		{ block:field_title / }
		
	</div>
	
	<div class="field">
		
		<label for="page-name">%PAGE_FIELD_NAME%</label>
		
		{ block:field_name / }
		
	</div>
	
	<div class="ui divider"></div>
	
	<input class="ui teal button" type="submit" value="%SAVE%" />
	
</form>

<table class="ui table" id="pages-list">
	
	<thead>
		
		<tr>
			
			<th class="ten wide">%PAGES_COLUMN_TITLE%</th>
			
			<th class="six wide" colspan="2">%PAGES_COLUMN_ACCESS%</th>
			
		</tr>
		
	</thead>
	
	<tbody>
				
		{ block:list }
		
		<tr class="disabled">
			
			<td colspan="3">%PAGES_NOT_FOUND%</td>
			
		</tr>
		
		{ / block:list }
		
	</tbody>
	
</table>

{ block:pagination / }