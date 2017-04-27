<tr data-name="$name$">

	<td class="twelve wide">

		<p><i class="plug icon"></i> <a href="$install_path$/admin/content/filemanager/addons?parent=$name$">$title$</a></p>

		<p style="font-size:0.9rem; color:#666;">$description$</p>

		<p style="font-size:0.8rem; color:#999;">Version: $version$ | Author: <a href="$website$" target="_blank">$author$</a></p>

	</td>

	<td class="right aligned">

		{ block:browse }

		<a class="ui mini $class$ icon browse button" href="$install_path$$link$" target="_blank" title="%BROWSE%"><i class="external icon"></i></a>

		{ / block:browse }

		{ block:install }

		<a class="ui mini grey icon install button" title="%INSTALL%"><i class="plus icon"></i></a>

		{ / block:install }

		{ block:uninstall }

		<a class="ui mini negative icon uninstall button" title="%UNINSTALL%"><i class="minus icon"></i></a>

		{ / block:uninstall }

	</td>

</tr>
