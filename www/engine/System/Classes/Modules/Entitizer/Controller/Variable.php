<?php

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer, Utils\Validate;

	class Variable {

		private $variable = null;

		# Constructor

		public function __construct(Entitizer\Entity\Variable $variable) {

			$this->variable = $variable;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$title = ''; $name = ''; $value = '';

			# Extract post array

			extract($post);

			# Validate name

			if (false === ($name = Validate::templateComponentName($name))) return ['name', 'VARIABLE_ERROR_NAME_INVALID'];

			# Check name exists

			if (false === ($check_name = $this->variable->check($name, 'name'))) return 'VARIABLE_ERROR_MODIFY';

			if ($check_name === 1) return ['name', 'VARIABLE_ERROR_NAME_DUPLICATE'];

			# Modify variable

			$data = [];

			$data['title']              = $title;
			$data['name']               = $name;
			$data['value']              = $value;

			$modifier = ((0 === $this->variable->id) ? 'create' : 'edit');

			if (!$this->variable->$modifier($data)) return 'VARIABLE_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
