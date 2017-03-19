<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer, Utils\Validate, Template;

	class Variable {

		private $variable = null;

		/**
		 * Constructor
		 */

		public function __construct(Entitizer\Entity\Variable $variable) {

			$this->variable = $variable;
		}

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$title = ''; $name = ''; $value = '';

			# Extract post array

			extract($post);

			# Validate name

			if (false === ($name = Validate::templateComponentName($name))) return ['name', 'VARIABLE_ERROR_NAME_INVALID'];

			# Check name reserved

			if (false !== Template::getGlobal($name)) return ['name', 'VARIABLE_ERROR_NAME_RESERVED'];

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
