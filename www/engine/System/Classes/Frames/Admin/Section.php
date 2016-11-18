<?php

namespace Frames\Admin {

	use Frames, Frames\Status, Modules\Auth, Modules\Extend, Utils\Messages, Utils\Popup, Utils\View;
	use DB, Debug, Language, Template;

	abstract class Section extends Frames\Section {

		# Define active section

		const SECTION = SECTION_ADMIN;

		# Define phrases list

		const PHRASES = ['Admin', 'Ajax', 'Common', 'Install', 'Mail', 'Menuitem', 'Page', 'Range', 'User', 'Variable', 'Widget'];

		# Page settings

		protected $title = '', $layout = 'Page';

		# Get layout

		private function getLayout(Template\Block $contents) {

			$layout = View::get('Layouts/' . $this->layout);

			# Set menu and user

			if (Auth::check()) {

				$layout->menu = View::get('Blocks/Utils/Menu');

				$layout->getBlock('user')->gravatar = Auth::user()->gravatar;

				$layout->getBlock('user')->name = Auth::user()->name;

				$layout->getBlock('user')->id = Auth::user()->id;
			}

			# Set title

			$layout->title = Language::get($this->title);

			# Set messages

			$layout->messages = Messages::block();

			# Set contents

			$layout->contents = $contents;

			# Set personalizer

			$layout->getBlock('language')->country = Extend\Languages::data('country');

			$layout->getBlock('language')->title = Extend\Languages::data('title');

			# Set copyright

			$layout->cadmium_home       = CADMIUM_HOME;
			$layout->cadmium_copy       = CADMIUM_COPY;
			$layout->cadmium_name       = CADMIUM_NAME;
			$layout->cadmium_version    = CADMIUM_VERSION;

			# Set popup

			$layout->popup = Popup::block();

			# Set report

			$layout->getBlock('report')->script_time = Debug::getTime();

			$layout->getBlock('report')->db_time = DB::getTime();

			# ------------------------

			return $layout;
		}

		# Display page

		protected function displayPage(Template\Block $contents, int $status = STATUS_CODE_200) {

			$page = View::get('Main/' . $this->layout);

			# Set language

			$page->language = Extend\Languages::data('iso');

			# Set title

			$page->title = ((('' !== $this->title) ? (Language::get($this->title) . ' | ') : '') . CADMIUM_NAME);

			# Set layout

			$page->layout = $this->getLayout($contents);

			# ------------------------

			Template::output($page, $status);
		}

		# Admin main method

		protected function section() {

			# Check for restricted access

			if ('' !== CONFIG_ADMIN_IP) {

				$ips = preg_split('/ +/', CONFIG_ADMIN_IP, -1, PREG_SPLIT_NO_EMPTY);

				if (!in_array(REQUEST_CLIENT_IP, $ips, true)) return Status::error404();
			}

			# ------------------------

			$this->area();
		}
	}
}
