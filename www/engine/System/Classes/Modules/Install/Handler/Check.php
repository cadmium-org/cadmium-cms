<?php

namespace System\Modules\Install\Handler {

	use System\Modules\Install, System\Utils\View, Language;

	class Check {

		private $form = null;

		# Get requirements

		private function getRequirements() {

			$requirements = [];

			foreach (Install::requirements() as $name => $value) {

				$class = ($value ? 'positive' : 'negative'); $icon = ($value ? 'check circle' : 'warning circle');

				$text = Language::get('INSTALL_REQUIREMENT_' . strtoupper($name) . '_' . ($value ? 'SUCCESS' : 'FAIL'));

				$requirements[] = ['class' => $class, 'icon' => $icon, 'text' => $text];
			}

			# ------------------------

			return $requirements;
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Install\Check');

			# Implement form

			$this->form->implement($contents);

			# Set requirements

			$contents->php_version = phpversion();

			$contents->requirements = $this->getRequirements();

			# Set button

			$contents->block('button')->checked = intval(Install::status());

			$contents->block('button')->text = Language::get(Install::status() ? 'CONTINUE' : 'RECHECK');

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			$this->form = new Install\Form\Check();

			# ------------------------

			return $this->getContents();
		}
	}
}
