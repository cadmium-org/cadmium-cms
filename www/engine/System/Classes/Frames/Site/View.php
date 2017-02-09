<?php

/**
 * @package Cadmium\System\Frames\Site
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Site {

	use Modules\Auth, Modules\Extend, Modules\Settings, Utils\Menu, Utils\Messages;
	use Utils\SEO, Utils\Template\Variables, Utils\Template\Widgets, Language, Template;

	class View extends \Utils\View {

		private $title = '', $layout = '';

		/**
		 * Get a layout block
		 */

		private function getLayout(Template\Block $contents) : Template\Block {

			$layout = View::get('Layouts/' . $this->layout);

			# Set menu

			$layout->menu = (new Menu)->block();

			# Set auth

			if (Auth::isLogged()) {

				$layout->getBlock('user')->enable(); $layout->getBlock('auth')->disable();

				$layout->getBlock('user')->gravatar = Auth::get('gravatar');

				$layout->getBlock('user')->name = Auth::get('name');

				if (Auth::get('rank') === RANK_ADMINISTRATOR) $layout->getBlock('admin')->enable();
			}

			# Set title

			$layout->title = (SEO::title() ?: Language::get($this->title) ?: Settings::get('site_title'));

			# Set contents

			$layout->contents = $contents;

			# ------------------------

			return $layout;
		}

		/**
		 * Output the page contents
		 */

		public function display(Template\Block $contents) {

			$page = View::get('Main/Page');

			# Set language

			$page->language = Extend\Languages::data('iso');

			# Set SEO data

			$page->description = (SEO::description() ?: Settings::get('site_description'));

			$page->keywords = (SEO::keywords() ?: Settings::get('site_keywords'));

			$page->robots = SEO::robots();

			# Set title

			$title = (SEO::title() ?: Language::get($this->title) ?: '');

			$page->title = ((('' !== $title) ? ($title . ' | ') : '') . Settings::get('site_title'));

			# Set canonical

			if (false !== SEO::canonical()) $page->getBlock('canonical')->enable()->link = SEO::canonical();

			# Set layout

			$page->layout = $this->getLayout($contents->setBlock('messages', Messages::block()));

			# Set global components

			foreach (Variables::generate() as $name => $value) Template::setGlobal($name, $value);

			foreach (Widgets::generate() as $name => $block) Template::setWidget($name, $block);

			# ------------------------

			Template::output($page);
		}

		/**
		 * Constructor
		 */

		 public function __construct(string $title, string $layout) {

 			$this->title = $title; $this->layout = $layout;
 		}
	}
}
