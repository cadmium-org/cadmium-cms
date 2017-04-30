<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	use Frames, Modules\Filemanager, Modules\Settings, Utils\Pagination, Utils\Popup, Utils\Uploader, Utils\View;
	use Ajax, Language, Number, Request, Template, Url;

	abstract class Lister extends Frames\Admin\Area\Panel {

		protected $_title = 'TITLE_CONTENT_FILEMANAGER';

		private $parent = null, $form = null, $loader = null;

		/**
		 * Process the bar block
		 */

		private function processBar(Template\Block $bar) {

			if (!static::$permissions['manage']) { $bar->disable(); return; }

			# Set link

			$query = (('' !== $this->parent->getPath()) ? ('?parent=' . $this->parent->getPath()) : '');

			$bar->link = (INSTALL_PATH . '/admin/content/filemanager' . $query);

			# Implement form

			$this->form->implement($bar);
		}

		/**
		 * Get the pagination block
		 *
		 * @return Template\Block|false : a block or false if there is only a single page
		 */

		private function getPaginationBlock() {

			$query = (('' !== $this->parent->getPath()) ? ('?parent=' . $this->parent->getPath()) : '');

			$url = new Url(INSTALL_PATH . '/admin/content/filemanager' . $query);

			# ------------------------

			return Pagination::block($this->loader->getIndex(), $this->loader->getDisplay(), $this->loader->getTotal(), $url);
		}

		/**
		 * Get the contents block
		 */

		private function getContents(bool $ajax = false) : Template\Block {

			$contents = View::get(!$ajax ? 'Blocks/Filemanager/Lister/Main' : 'Blocks/Filemanager/Ajax/Main');

			# Set parent

			if (!$ajax) $contents->parent = $this->parent->getPath();

			# Set origin and title

			$contents->origin = static::$origin; $contents->title = Language::get(static::$title);

			# Set breadcrumbs

			$contents->breadcrumbs = $this->parent->getBreadcrumbs();

			# Process bar

			if (!$ajax) $this->processBar($contents->getBlock('bar'));

			# Set items

			$items = $contents->getBlock('items');

			foreach ($this->loader->getItems() as $entity) {

				if ($entity->isDir()) $items->addItem(Lister\Dir::getBlock($entity, $ajax));

				else $items->addItem(Lister\File::getBlock($entity, $ajax));
			}

			# Set pagination

			if (!$ajax) $contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the ajax request
		 */

		private function handleAjax() : Ajax\Response {

			$ajax = Ajax::createResponse();

			# Create parent

			$this->parent = new static::$container_class(Request::get('parent'));

			# Load items

			$this->loader = (new Loader($this->parent))->load();

			# ------------------------

			return $ajax->set('contents', $this->getContents(true)->getContents());
		}

		/**
		 * Handle the request
		 *
		 * @return Template\Block|Ajax\Response : a block object if the ajax param was set to false, otherwise an ajax response
		 */

		protected function handle(bool $ajax = false) {

			if ($ajax) return $this->handleAjax();

			# Create parent

			$this->parent = new static::$container_class(Request::get('parent'));

			# Create form

			$this->form = new Filemanager\Form\Create;

			# Handle form

			if (static::$permissions['manage']) {

				if (Uploader::submit('upload', $this->parent->getPathFull())) $submitted = 'upload';

				else if ($this->form->handle(new Filemanager\Controller\Create($this->parent), true)) $submitted = 'create';
			}

			if (isset($submitted)) {

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager/' . static::$origin . '?' . (('' !==

					($parent = $this->parent->getPath())) ? ('parent=' . $parent . '&') : '') . 'submitted=' . $submitted);
			}

			# Display success message

			if (Request::get('submitted') === 'upload') Popup::set('positive', Language::get('FILEMANAGER_SUCCESS_UPLOAD'));

			else if (Request::get('submitted') === 'create') Popup::set('positive', Language::get('FILEMANAGER_SUCCESS_DIR_CREATE'));

			# Load items

			$index = Number::forceInt(Request::get('index'), 1, 999999);

			$this->loader = (new Loader($this->parent))->load($index, Settings::get('admin_display_files'));

			# ------------------------

			return $this->getContents();
		}
	}
}
