<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="robots" content="NOINDEX,FOLLOW" />

		<title>$head_title$</title>

		<link rel="icon" type="image/png" href="/include/admin/favicon.png" />

		<link rel="stylesheet" type="text/css" href="/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="/include/admin/templates/default/styles/main.css" />

		<script src="/include/common/jquery.core.js"></script>

		<script src="/include/semantic/semantic.min.js"></script>

		<script src="/include/admin/editor/ckeditor.js"></script>

		<script src="/include/admin/scripts/main.js"></script>

		<script>

			$(document).ready(function() { Main.init(); });

		</script>

		<style type="text/css">

			body > .grid { height:100%; }

			.column { max-width:400px; }

		</style>

	</head>

	<body>

		<div class="ui middle aligned center aligned grid">

			<div class="column">

				<h1 class="image header">

					<a href="/admin/login"><img class="image" src="/include/admin/templates/default/images/logo.png" /></a>

				</h1>

				{ block:messages / }

				{ block:contents / }

			</div>

		</div>

	</body>

</html>
