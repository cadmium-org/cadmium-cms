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

			 if (Auth::check()) {

				 $layout->menu = self::get('Blocks/Utils/Menu');

				 $layout->getBlock('user')->gravatar = Auth::user()->gravatar;

				 $layout->getBlock('user')->name = Auth::user()->name;

				 $layout->getBlock('user')->id = Auth::user()->id;
			 }

			 # Set title

			 $layout->title = Language::get($this->title);

			 # Set messages

			 $layout->messages = Messages::block();

			 # Set popup

			 $layout->popup = Popup::block();

			 # Set contents

			 $layout->contents = $contents;

			 # Set language

			 $layout->getBlock('language')->country = Extend\Languages::data('country');

			 $layout->getBlock('language')->title = Extend\Languages::data('title');

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

			 $layout['messages'] = Messages::block()->getContents();

			 # Set popup

			 $layout['popup'] = Popup::block()->getContents();

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
