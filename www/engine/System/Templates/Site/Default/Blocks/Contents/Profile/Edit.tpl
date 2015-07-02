<div class="ui menu">
	
	<a class="item" href="/profile">%PROFILE_TAB_OVERVIEW%</a>
	
	<a class="active item" href="/profile/edit">%PROFILE_TAB_EDIT%</a>
	
</div>

<div class="ui stacked segment">
	
	<div class="ui two column stackable grid">
		
		<div class="column">
			
			<h4 class="ui dividing header">%PROFILE_EDIT_GROUP_PERSONAL%</h4>
			
			<form class="ui form" method="post" action="/profile/edit">
				
				<div class="field">
					
					<label for="edit-email">%USER_FIELD_EMAIL%</label>
					
					{ block:field_email / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-first-name">%USER_FIELD_FIRST_NAME%</label>
					
					{ block:field_first_name / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-last-name">%USER_FIELD_LAST_NAME%</label>
					
					{ block:field_last_name / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-sex">%USER_FIELD_SEX%</label>
					
					{ block:field_sex / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-city">%USER_FIELD_CITY%</label>
					
					{ block:field_city / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-country">%USER_FIELD_COUNTRY%</label>
					
					{ block:field_country / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-timezone">%USER_FIELD_TIMEZONE%</label>
					
					{ block:field_timezone / }
					
				</div>
				
				<div class="field">
					
					<input class="ui button" type="submit" value="%SAVE%" />
					
				</div>
				
			</form>
			
		</div>
		
		<div class="column">
			
			<h4 class="ui dividing header">%PROFILE_EDIT_GROUP_PASSWORD%</h4>
			
			<form class="ui form" method="post" action="/profile/edit">
				
				<div class="field">
					
					<label for="edit-password">%USER_FIELD_PASSWORD_CURRENT%</label>
					
					{ block:field_password / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-password-new">%USER_FIELD_PASSWORD_NEW%</label>
					
					{ block:field_password_new / }
					
				</div>
				
				<div class="field">
					
					<label for="edit-password-retype">%USER_FIELD_PASSWORD_RETYPE%</label>
					
					{ block:field_password_retype / }
					
				</div>
				
				<div class="field">
					
					<input class="ui button" type="submit" value="%SAVE%" />
					
				</div>
				
			</form>
			
		</div>
		
	</div>
	
</div>