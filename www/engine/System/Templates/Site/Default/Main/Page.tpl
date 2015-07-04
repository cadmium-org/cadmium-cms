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

		<div class="ui left vertical sidebar menu"></div>

		<div class="pusher">

			<nav class="ui page grid fixed main menu">

				<a class="brand item" id="menu-brand" href="/">

					<img src="/include/site/templates/default/images/brand.png" />

				</a>

				<a class="item" id="menu-launcher" style="display:none;"><i class="bars icon"></i></a>

				{ block:menu / }

				{ ! block:user }

				<div class="right menu">

					<div class="ui dropdown item">

						<img class="ui right spaced avatar image" src="http://www.gravatar.com/avatar/$gravatar$?s=28&d=mm" />

						<b>$name$</b><i class="dropdown icon"></i>

						<div class="menu">

							<a class="item" href="/profile"><i class="user icon"></i>%TITLE_PROFILE%</a>

							<a class="item" href="/profile/logout"><i class="sign out icon"></i>%LOGOUT%</a>

						</div>

					</div>

					{ ! block:admin }

					<a class="item" href="/admin" target="_blank" id="section-button" title="%SECTION_ADMIN%"><i class="setting icon"></i></a>

					{ / block:admin }

				</div>

				{ / block:user }

				{ ! block:auth }

				<div class="right menu">

					<a class="item" href="/profile/login">%LOGIN%</a>

					<a class="item" href="/profile/register">%REGISTER%</a>

				</div>

				{ / block:auth }

			</nav>

			<header class="ui one column page grid masthead">

				<div class="center aligned column">

					<h1>$title$</h1>

				</div>

			</header>

			<section class="ui one column page grid">

				<div class="column">

					{ block:messages / }

					{ block:contents / }

					<footer class="ui basic segment">

						<a href="$system_url$">$site_title$</a> &copy; $copyright$

					</footer>

				</div>

			</section>

		</div>

	</body>

</html>
