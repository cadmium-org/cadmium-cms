<div class="ui small pagination menu">

	{ block:prev }

	<a class="icon item" href="$link$"><i class="left arrow icon"></i></a>

	{ / block:prev }

	{ ! block:prev_disabled }

	<a class="disabled icon item"><i class="left arrow icon"></i></a>

	{ / block:prev_disabled }

	{ block:first }

	<a class="item" href="$link$">$index$</a>

	{ block:ellipsis }<div class="disabled item">...</div>{ / block:ellipsis }

	{ / block:first }

	{ for:items }

	<a class="$class$" href="$link$">$index$</a>

	{ / for:items }

	{ block:last }

	{ block:ellipsis }<div class="disabled item">...</div>{ / block:ellipsis }

	<a class="item" href="$link$">$index$</a>

	{ / block:last }

	{ block:next }

	<a class="icon item" href="$link$"><i class="right arrow icon"></i></a>

	{ / block:next }

	{ ! block:next_disabled }

	<a class="disabled icon item"><i class="right arrow icon"></i></a>

	{ / block:next_disabled }

</div>
