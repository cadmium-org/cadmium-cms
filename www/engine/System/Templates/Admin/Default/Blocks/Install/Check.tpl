<div class="ui left aligned segment">

    <form class="ui form" method="get" action="/install.php">

        <h4 class="ui dividing header">%TITLE_INSTALL_CHECK%</h4>

		<div class="field">

            <label for="language">%INSTALL_FIELD_LANGUAGE%</label>

			{ block:field_language / }

		</div>

        <div class="field">

            <label for="template">%INSTALL_FIELD_TEMPLATE%</label>

			{ block:field_template / }

		</div>

    </form>

    <table class="ui table">

        <tbody>

            <tr>

                <td class="positive">

                    <i class="check circle icon"></i>%INSTALL_PHP_VERSION% $php_version$.

                </td>

            </tr>

            { for:requirements }

            <tr>

                <td class="$class$"><i class="$icon$ icon"></i>$text$</td>

            </tr>

            { / for:requirements }

        </tbody>

    </table>

    { block:button }

    <div class="field">

		<a class="ui fluid teal button" href="/install.php?checked=$checked$">$text$</a>

	</div>

    { / block:button }

</div>
