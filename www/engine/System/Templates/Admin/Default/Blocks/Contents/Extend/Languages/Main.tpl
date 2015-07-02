<div class="ui menu">
	
	{ for:sections }
	
	<a href="/admin/extend/languages?list=$name$" class="$class$">$title$</a>
	
	{ / for:sections }
	
</div>

<input type="hidden" id="languages-section" name="section" value="$section$" />

<table class="ui unstackable table" id="languages-list">
	
	<thead>
		
		<tr>
			
			<th colspan="2">%LANGUAGES_INSTALLED%</th>
			
		</tr>
		
	</thead>
	
	<tbody>
		
		{ block:list }
		
		<tr class="disabled">
			
			<td>%LANGUAGES_NOT_FOUND%</td>
			
		</tr>
		
		{ / block:list }
		
	</tbody>
	
</table>