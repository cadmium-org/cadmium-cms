<?php

namespace Template\Utils {

	interface Settable {

		# Get contents

		public function contents(bool $format = true);
	}
}
