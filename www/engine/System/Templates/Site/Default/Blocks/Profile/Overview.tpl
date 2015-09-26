<div class="ui menu">

	<a class="active item" href="/profile">%PROFILE_TAB_OVERVIEW%</a>

	<a class="item" href="/profile/edit">%PROFILE_TAB_EDIT%</a>

</div>

<div class="ui stacked segment">

	<div class="ui header">$name$</div>

	<div class="ui divider"></div>

	<table class="ui very basic table">

		<tbody>

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_EMAIL%</td>

				<td>$email$</td>

			</tr>

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_RANK%</td>

				<td>$rank$</td>

			</tr>

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_TIME%</td>

				<td>$time$</td>

			</tr>

			{ block:sex }

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_SEX%</td>

				<td>$text$</td>

			</tr>

			{ / block:sex }

			{ block:full_name }

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_FULL_NAME%</td>

				<td>$text$</td>

			</tr>

			{ / block:full_name }

			{ block:city }

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_CITY%</td>

				<td>$text$</td>

			</tr>

			{ / block:city }

			{ block:country }

			<tr>

				<td class="four wide">%PROFILE_OVERVIEW_COUNTRY%</td>

				<td><i class="$code$ flag"></i>$name$</td>

			</tr>

			{ / block:country }

		</tbody>

	</table>

	<p><a href="/profile/edit"><i class="edit icon"></i>%PROFILE_TAB_EDIT%</a></p>

</div>
