<div class="ui top vertical sidebar menu"></div>

<div class="pusher">

	<nav class="ui page grid fixed main menu">

		<a class="brand item" href="$index_page$">

			<img src="$install_path$/assets/$template_name$/images/brand.png" />

		</a>

		<a class="launcher icon item"><i class="sidebar icon"></i></a>

		{ block:menu / }

		<div class="right menu">

			{ ! block:user }

			<div class="ui user dropdown item">

				<img class="ui right spaced avatar image" src="http://www.gravatar.com/avatar/$gravatar$?s=28&d=mm" />

				<b class="name">$name$</b><i class="dropdown icon"></i>

				<div class="menu">

					<a class="item" href="$install_path$/profile"><i class="user icon"></i>%TITLE_PROFILE%</a>

					<a class="item logout" href="$install_path$/profile?logout"><i class="sign out icon"></i>%LOGOUT%</a>

				</div>

			</div>

			{ / block:user }

			{ block:auth }

			<a class="expanded item" href="$install_path$/profile/login">%LOGIN%</a>

			<a class="expanded item" href="$install_path$/profile/register">%REGISTER%</a>

			<div class="ui collapsed dropdown icon item">

				<i class="user icon"></i>

				<div class="menu">

					<a class="item" href="$install_path$/profile/login">%LOGIN%</a>

					<a class="item" href="$install_path$/profile/register">%REGISTER%</a>

				</div>

			</div>

			{ / block:auth }

			{ ! block:admin }

			<a class="section icon item" href="$install_path$/admin" target="_blank"

				title="%SECTION_ADMIN%"><i class="setting icon"></i></a>

			{ / block:admin }

		</div>

	</nav>

	<header class="heading">

		<h1>$title$</h1>

	</header>

	<section class="ui one column page grid" id="container">

		<div class="column">

			{ block:contents / }

		</div>

	</section>

	<footer class="ui two column stackable footer page grid">

		<div class="left aligned column">

			$current_year$ &copy; <a href="$index_page$">$site_title$</a>

		</div>

		<div class="right aligned column">

			%POWERED_BY% <a href="$cadmium_home$">$cadmium_name$</a> v.$cadmium_version$

		</div>

	</footer>

</div>
