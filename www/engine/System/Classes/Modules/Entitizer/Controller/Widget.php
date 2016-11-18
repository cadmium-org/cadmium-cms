<?php

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer, Utils\Validate;

	class Widget {

		private $widget = null;

		# Constructor

		public function __construct(Entitizer\Entity\Widget $widget) {

			$this->widget = $widget;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$title = ''; $name = ''; $active = ''; $contents = '';

			# Extract post array

			extract($post);

			# Validate name

			if (false === ($name = Validate::templateComponentName($name))) return ['name', 'WIDGET_ERROR_NAME_INVALID'];

			# Check name exists

			if (false === ($check_name = $this->widget->check($name, 'name'))) return 'WIDGET_ERROR_MODIFY';

			if ($check_name === 1) return ['name', 'WIDGET_ERROR_NAME_DUPLICATE'];

			# Modify widget

			$data = [];

			$data['title']              = $title;
			$data['name']               = $name;
			$data['active']             = $active;
			$data['contents']           = $contents;

			$modifier = ((0 === $this->widget->id) ? 'create' : 'edit');

			if (!$this->widget->$modifier($data)) return 'WIDGET_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
