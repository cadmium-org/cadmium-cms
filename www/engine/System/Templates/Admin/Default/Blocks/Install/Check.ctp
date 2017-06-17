{ block:language }

<div class="ui form">

	<div class="field">

		<label>%INSTALL_FIELD_LANGUAGE%</label>

		<div class="ui fluid selection dropdown">

			<i class="dropdown icon"></i>

			<div class="text"><i class="$country$ flag"></i>$title$</div>

			<div class="menu">

				{ for:items }

				<a class="item" href="$install_path$/install.php?language=$name$"><i class="$country$ flag"></i>$title$</a>

				{ / for:items }

			</div>

		</div>

	</div>

</div>

{ / block:language }

{ block:requirements }

<table class="ui unstackable table">

	<tbody>

		<tr>

			<td class="positive"><i class="check circle icon"></i>%INSTALL_PHP_VERSION% $php_version$.</td>

		</tr>

		{ for:items }

		<tr>

			<td class="$class$"><i class="$icon$ icon"></i>$text$</td>

		</tr>

		{ / for:items }

	</tbody>

</table>

{ / block:requirements }

{ block:button }

<div class="ui hidden divider"></div>

<div class="field">

	<a class="ui teal button" href="$install_path$/install.php?checked=$checked$">$text$</a>

</div>

{ / block:button }
