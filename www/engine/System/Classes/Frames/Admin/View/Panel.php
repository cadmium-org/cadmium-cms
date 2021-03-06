<?php

/**
 * @package Cadmium\System\Frames\Admin
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Admin\View {

	use Frames, Modules\Auth, Modules\Extend, Utils\Messages, Utils\Popup, DB, Debug, Language, Template;

	class Panel extends Frames\Admin\View {

		protected $view = 'Panel', $status = STATUS_CODE_200;

		/**
		 * Get a layout block
		 */

		 private function getLayout(Template\Block $contents) : Template\Block {

			 $layout = self::get('Layouts/Panel');

			 # Set menu and user

			 if (Auth::isLogged()) {

				 $layout->menu = self::get('Blocks/Utils/Menu');

				 $layout->getBlock('user')->gravatar = Auth::get('gravatar');

				 $layout->getBlock('user')->name = Auth::get('name');

				 $layout->getBlock('user')->id = Auth::get('id');
			 }

			 # Set title

			 $layout->title = Language::get($this->title);

			 # Set messages

			 $layout->messages = Messages::getBlock();

			 # Set popup

			 $layout->popup = Popup::getBlock();

			 # Set contents

			 $layout->contents = $contents;

			 # Set language

			 $layout->getBlock('language')->country = Extend\Languages::get('country');

			 $layout->getBlock('language')->title = Extend\Languages::get('title');

			 # Set report

			 $layout->getBlock('report')->script_time = Debug::getTime();

			 $layout->getBlock('report')->db_time = DB::getTime();

			 # ------------------------

			 return $layout;
		 }

		 /**
		  * Get a layout dynamic data
		  */

		 private function getLayoutData(Template\Block $contents) : array {

			 $layout = [];

			 # Set title

			 $layout['title'] = Language::get($this->title);

			 # Set messages

			 $layout['messages'] = Messages::getBlock()->getContents();

			 # Set popup

			 $layout['popup'] = Popup::getBlock()->getContents();

			 # Set contents

			 $layout['contents'] = $contents->getContents();

			 # ------------------------

			 return $layout;
		 }

		/**
		 * Output the page contents
		 */

		public function display(Template\Block $contents) {

 			$this->_display($this->getLayout($contents));
 		}

		/**
		 * Output the page dynamic data as json
		 */

		public function navigate(Template\Block $contents) {

			$this->_navigate($this->getLayoutData($contents));
		}
	}
}
