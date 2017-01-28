<!DOCTYPE html>

<html lang="$language$">

	<head>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="description" content="$description$" />
		<meta name="keywords" content="$keywords$" />
		<meta name="robots" content="$robots$" />

		<title>$title$</title>

		{ ! block:canonical }<link rel="canonical" href="$link$" />{ / block:canonical }

		<link rel="icon" type="image/png" href="$install_path$/include/favicon.png" />

		<link rel="stylesheet" type="text/css" href="$install_path$/include/semantic/semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="$install_path$/include/site/templates/$template_name$/styles/main.css" />

		<script src="$install_path$/include/common/jquery.core.js"></script>

		<script src="$install_path$/include/semantic/semantic.min.js"></script>

		<script src="$install_path$/include/site/templates/$template_name$/scripts/view.js"></script>

		<script>

			var install_path = '$install_path$';

			$(function() { View.init(); });

		</script>

	</head>

	<body>

		{ block:layout / }

	</body>

</html>
