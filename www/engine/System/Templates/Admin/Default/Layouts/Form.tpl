<div class="ui condensed center aligned grid">

	<div class="column">

		<h1 class="image header">

			<a href="$index_page$"><img class="image" src="$install_path$/include/admin/templates/$template_name$/images/logo.png" /></a>

		</h1>

		<div class="ui left aligned segment">

			<h4 class="ui dividing header">$title$</h4>

			{ block:messages / }

			{ block:contents / }

		</div>

	</div>

</div>

{ block:report }

<script>

	console.log('%REPORT_SCRIPT_TIME%: $script_time$');

	console.log('%REPORT_DB_TIME%: $db_time$');

</script>

{ / block:report }
