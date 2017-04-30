<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	use Frames, Modules\Filemanager, Utils\Popup, Utils\View, Ajax, Language, Request, Template;

	abstract class Handler extends Frames\Admin\Area\Panel {

		protected $parent = null, $entity = null, $link = '', $forms = [], $controllers = [];

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get(static::$view);

			# Set origin and title

			$contents->origin = static::$origin; $contents->title = Language::get(static::$title);

			# Set breadcrumbs

			$contents->breadcrumbs = $this->parent->getBreadcrumbs();

			# Set parent

			$contents->parent = $this->parent->getPath();

			# Set name

			$contents->name = $this->entity->getName();

			# Set editor mode

			$contents->mode = Mime::getMode($this->entity->getExtension());

			# Implement forms

			foreach ($this->forms as $form) $form->implement($contents);

			# Process info block

			$this->processInfo($contents->getBlock('info'));

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

			# Create entity

			$this->entity = Filemanager::get($this->parent, Request::get('name'));

			# Init entity

			if (!$this->entity->isInited()) {

				return $ajax->setError(Language::get(static::$message_error_remove));
			}

			# Process remove action

			if ((Request::post('action') === 'remove')) {

				if (!static::$permissions['manage'] || !$this->entity->remove()) {

					return $ajax->setError(Language::get(static::$message_error_remove));
				}
			}

			# ------------------------

			return $ajax;
		}

		/**
		 * Handle the request
		 *
		 * @return Template\Block|Ajax\Response : a block object if the ajax param was set to false, otherwise an ajax response
		 */

		protected function handle(bool $ajax = false) {

			# Handle ajax request

			if ($ajax) return $this->handleAjax();

			# Create parent

			$this->parent = new static::$container_class(Request::get('parent'));

			# Create entity

			$this->entity = Filemanager::get($this->parent, Request::get('name'));

			# Redirect if entity not found

			if (!$this->entity->isInited()) {

				$query = (('' !== $this->parent->getPath()) ? ('?parent=' . $this->parent->getPath()) : '');

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager/' . static::$origin . '/' . $query);
			}

			# Create rename form

			$this->forms['rename'] = new Filemanager\Form\Rename($this->entity, static::$permissions['manage']);

			$this->controllers['rename'] = new Filemanager\Controller\Rename($this->entity);

			# Create edit form

			if ($this->entity->isFile() && static::$permissions['edit']) {

				$this->forms['edit'] = new Filemanager\Form\Edit($this->entity);

				$this->controllers['edit'] = new Filemanager\Controller\Edit($this->entity);
			}

			# Handle form

			foreach ($this->forms as $name => $form) if ($form->handle($this->controllers[$name], true)) {

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager/' . static::$origin . '/' . static::$type .

					'?parent=' . $this->parent->getPath() . '&name=' . $this->entity->getName() . '&submitted=' . $name);
			}

			# Display success message

			if (Request::get('submitted') === 'rename') Popup::set('positive', Language::get(static::$message_success_rename));

			else if (Request::get('submitted') === 'edit') Popup::set('positive', Language::get(static::$message_success_edit));

			# ------------------------

			return $this->getContents();
		}
	}
}
