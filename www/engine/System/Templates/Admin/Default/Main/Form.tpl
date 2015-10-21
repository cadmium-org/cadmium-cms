<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="robots" content="NOINDEX,FOLLOW" />

		<title>$title$</title>

		<link rel="icon" type="image/png" href="$install_path$/include/admin/favicon.png" />

		<link rel="stylesheet" type="text/css" href="$install_path$/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="$install_path$/include/admin/templates/default/styles/main.css" />

		<script src="$install_path$/include/common/jquery.core.js"></script>

		<script src="$install_path$/include/semantic/semantic.min.js"></script>

		<script src="$install_path$/include/admin/scripts/main.js"></script>

		<script>

			$(document).ready(function() { Main.init(); });

		</script>

		<style type="text/css">

			body > .grid { padding:3em 0 !important; }

			.column { max-width:400px; }

		</style>

	</head>

	<body>

		{ block:layout / }

	</body>

</html>
