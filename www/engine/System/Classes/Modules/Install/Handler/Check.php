<?php

namespace System\Modules\Install\Handler {

	use System\Modules\Install, System\Utils\View, Language;

	abstract class Check {

		private static $form = null;

		# Get requirements

		private static function getRequirements() {

			$requirements = array();

			foreach (Install::requirements() as $name => $value) {

				$class = ($value ? 'positive' : 'negative'); $icon = ($value ? 'check circle' : 'warning circle');

				$text = Language::get('INSTALL_REQUIREMENT_' . strtoupper($name) . '_' . ($value ? 'SUCCESS' : 'FAIL'));

				$requirements[] = array('class' => $class, 'icon' => $icon, 'text' => $text);
			}

			# ------------------------

			return $requirements;
		}

		# Get contents

		private static function getContents() {

			$contents = View::get('Blocks\Install\Check');

			# Implement form

			self::$form->implement($contents);

			# Set requirements

			$contents->php_version = phpversion();

			$contents->requirements = self::getRequirements();

			# Set button

			$contents->block('button')->checked = intabs(Install::status());

			$contents->block('button')->text = Language::get(Install::status() ? 'CONTINUE' : 'RECHECK');

			# ------------------------

			return $contents;
		}

		# Handle request

		public static function handle() {

			self::$form = new Install\Form\Check();

			# ------------------------

			return self::getContents();
		}
	}
}
