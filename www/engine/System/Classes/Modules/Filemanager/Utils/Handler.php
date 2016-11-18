<?php

namespace Modules\Filemanager\Utils {

	use Frames, Modules\Filemanager, Utils\Popup, Utils\View, Ajax, Language, Request;

	abstract class Handler extends Frames\Admin\Area\Authorized {

		protected $parent = null, $entity = null, $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get(static::$view);

			# Set breadcrumbs

			$contents->breadcrumbs = $this->parent->breadcrumbs();

			# Set parent

			$contents->parent = $this->parent->path();

			# Set name

			$contents->name = $this->entity->name();

			# Implement form

			$this->form->implement($contents);

			# Set info

			$this->processInfo($contents->getBlock('info'));

			# ------------------------

			return $contents;
		}

		# Handle ajax request

		private function handleAjax() {

			$ajax = Ajax::createResponse();

			# Check for demo mode

			if (MODE_DEMO) return $ajax->setError(Language::get('DEMO_MODE_RESTRICTION'));

			# Init entity

			if (!$this->entity->init(Request::get('name'))) {

				return $ajax->setError(Language::get(static::$message_error_remove));
			}

			# Process remove action

			if (Request::post('action') === 'remove') {

				if (!$this->entity->remove()) return $ajax->setError(Language::get(static::$message_error_remove));
			}

			# ------------------------

			return $ajax;
		}

		# Handle request

		public function handle() {

			# Create parent

			$this->parent = Filemanager::open(Request::get('parent'));

			# Create entity

			$this->entity = Filemanager::get(static::$type, $this->parent);

			# Handle ajax request

			if (Request::isAjax()) return $this->handleAjax();

			# Init entity

			if (!$this->entity->init(Request::get('name'))) {

				$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager' . $query);
			}

			# Create form

			$this->form = new Filemanager\Form\Rename($this->entity);

			# Handle form

			if ($this->form->handle(new Filemanager\Controller\Rename($this->entity), true)) {

				$query = ('?parent=' . $this->parent->path() . '&name=' . $this->entity->name() . '&submitted');

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager/' . static::$type . $query);
			}

			# Display success message

			if (false !== Request::get('submitted')) Popup::set('positive', Language::get(static::$message_success_rename));

			# ------------------------

			return $this->getContents();
		}
	}
}
