<div class="ui segment">

	{ block:breadcrumbs }

	<div class="ui breadcrumb">

		{ for:path }

		<a class="section" href="$link$">$title$</a>

		<div class="divider"> / </div>

		{ / for:path }

	</div>

	{ / block:breadcrumbs }

	{ block:contents / }

</div>
