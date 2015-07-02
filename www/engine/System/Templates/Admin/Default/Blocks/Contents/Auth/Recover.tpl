<div class="ui segment">
	
	<form class="ui form" method="post" action="/admin/recover?code=$code$">
		
		<div class="field">
			
			<div class="ui left icon input">
				
				{ block:field_password_new / }
				
				<i class="privacy icon"></i>
				
			</div>
			
		</div>
		
		<div class="field">
			
			<div class="ui left icon input">
				
				{ block:field_password_retype / }
				
				<i class="privacy icon"></i>
				
			</div>
			
		</div>
		
		<div class="field">
			
			<input class="ui fluid teal button" type="submit" value="%SUBMIT%" />
			
		</div>
		
	</form>
	
</div>