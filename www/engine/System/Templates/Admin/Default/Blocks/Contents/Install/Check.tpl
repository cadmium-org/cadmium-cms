<div class="ui left aligned segment">

    <form class="ui form" method="get" action="/install.php">

		<div class="field">

            <label for="language">%INSTALL_FIELD_LANGUAGE%</label>

			{ block:field_language / }

		</div>

        <div class="field">

            <label for="template">%INSTALL_FIELD_TEMPLATE%</label>

			{ block:field_template / }

		</div>

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

			<button class="ui fluid teal button" type="submit" name="checked" value="$value$">$text$</button>

		</div>

        { / block:button }

	</form>

</div>
