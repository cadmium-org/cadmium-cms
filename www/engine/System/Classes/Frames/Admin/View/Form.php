<?php

/**
 * @package Cadmium\System\Frames\Admin
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Admin\View {

	use Frames, Utils\Messages, Language, Template;

	class Form extends Frames\Admin\View {

		protected $view = 'Form', $status = STATUS_CODE_401;

		/**
		 * Get a layout block
		 */

		private function getLayout(Template\Block $contents) : Template\Block {

			$layout = self::get('Layouts/Form');

			# Set title

			$layout->title = Language::get($this->title);

			# Set messages

			$layout->messages = Messages::getBlock();

			# Set contents

			$layout->contents = $contents;

			# ------------------------

			return $layout;
		}

		/**
		 * Output the page contents
		 */

		public function display(Template\Block $contents) {

			return $this->_display($this->getLayout($contents));
		}
	}
}
