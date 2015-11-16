<div class="ui top vertical sidebar menu"></div>

<div class="pusher">

	<nav class="ui page grid fixed main menu">

		<a class="brand item" id="menu-brand" href="$install_path$/">

			<img src="$install_path$/include/site/templates/$template_name$/images/brand.png" />

		</a>

		<a class="item" id="menu-launcher" style="display:none;"><i class="bars icon"></i></a>

		<div class="menu" id="menu-items" style="display:none; padding:0;">

			{ block:menu / }

		</div>

		{ ! block:user }

		<div class="right menu">

			<div class="ui dropdown item">

				<img class="ui right spaced avatar image" src="http://www.gravatar.com/avatar/$gravatar$?s=28&d=mm" />

				<b>$name$</b><i class="dropdown icon"></i>

				<div class="menu">

					<a class="item" href="$install_path$/profile"><i class="user icon"></i>%TITLE_PROFILE%</a>

					<a class="item" href="$install_path$/profile/logout"><i class="sign out icon"></i>%LOGOUT%</a>

				</div>

			</div>

			{ ! block:admin }

			<a class="item" href="$install_path$/admin" target="_blank" id="section-button" title="%SECTION_ADMIN%"><i class="setting icon"></i></a>

			{ / block:admin }

		</div>

		{ / block:user }

		{ ! block:auth }

		<div class="right menu">

			<a class="item" href="$install_path$/profile/login">%LOGIN%</a>

			<a class="item" href="$install_path$/profile/register">%REGISTER%</a>

		</div>

		{ / block:auth }

	</nav>

	<header class="heading">

		<h1>$title$</h1>

	</header>

	<section class="ui one column page grid">

		<div class="column">

			{ block:messages / }

			{ block:contents / }

		</div>

	</section>

	<footer class="ui two column stackable footer page grid">

		<div class="left aligned column">

			$copyright$ &copy; <a href="$system_url$">$site_title$</a>

		</div>

		<div class="right aligned column">

			%POWERED_BY% <a href="$cadmium_home$">$cadmium_name$</a> v.$cadmium_version$

		</div>

	</footer>

</div>
