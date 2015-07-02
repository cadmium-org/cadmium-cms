<div class="ui segment">
	
	<form class="ui auth form" method="post" action="/profile/login">
		
		<div class="field">
			
			<label for="login-name">%USER_FIELD_NAME%</label>
			
			{ block:field_name / }
			
		</div>
		
		<div class="field">
			
			<label for="login-password">%USER_FIELD_PASSWORD%</label>
			
			{ block:field_password / }
			
		</div>
		
		<div class="inline fields">
			
			<div class="field">
				
				<input class="ui button" type="submit" value="%LOGIN%" />
				
			</div>
			
			<div class="field">
				
				<a class="ui basic button" href="/profile/reset">%RESET_TEXT%</a>
				
			</div>
			
		</div>
		
	</form>
	
</div>