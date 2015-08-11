<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="description" content="$description$" />
		<meta name="keywords" content="$keywords$" />
		<meta name="robots" content="$robots$" />

		<title>$head_title$</title>

		{ block:canonical }<link rel="canonical" href="$link$" />{ / block:canonical }

		<link rel="icon" type="image/png" href="/include/favicon.png" />

		<link rel="stylesheet" type="text/css" href="/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="/include/site/templates/default/styles/main.css" />

		<script src="/include/common/jquery.core.js"></script>

		<script src="/include/semantic/semantic.min.js"></script>

		<script src="/include/site/scripts/main.js"></script>

		<script>

			$(document).ready(function() { Main.init(); });

		</script>

	</head>

	<body>

		{ block:layout / }

	</body>

</html>
