<?php

namespace Modules\Install\Handler {

	use Frames, Modules\Extend, Modules\Install, Utils\View, Language;

	class Check extends Frames\Admin\Area\Install {

		protected $title = 'TITLE_INSTALL_CHECK';

		private $languages = null;

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

			$contents = View::get('Blocks/Install/Check');

			# Set languages

			$contents->getBlock('language')->country = Extend\Languages::data('country');

			$contents->getBlock('language')->title = Extend\Languages::data('title');

			$contents->getBlock('language')->items = $this->languages->items();

			# Set requirements

			$contents->getBlock('requirements')->php_version = phpversion();

			$contents->getBlock('requirements')->items = $this->getRequirements();

			# Set button

			$contents->getBlock('button')->checked = intval(Install::status());

			$contents->getBlock('button')->text = Language::get(Install::status() ? 'CONTINUE' : 'RECHECK');

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Load languages

			$this->languages = Extend\Languages::loader(SECTION_ADMIN);

			# ------------------------

			return $this->getContents();
		}
	}
}
