<?php

namespace System\Modules\Entitizer\Utils {

	use System\Modules\Entitizer, System\Utils\Messages, System\Utils\View, Ajax, Language, Number, Request, Template;

	abstract class Handler {

		protected $create = false, $parent = null, $entity = null, $form = null;

		# Process parent block

		private function processParent(Template\Asset\Block $parent) {

			# Set parent id

			$parent->id = $this->parent->id;

			# Set create button

			$parent->block('create')->class = ($this->create ? 'active item' : 'item');

			$parent->block('create')->id = $this->parent->id;

			# Set edit button

			if (0 === $this->parent->id) $parent->block('edit')->disable(); else {

				$parent->block('edit')->class = (!$this->create ? 'active item' : 'item');

				$parent->block('edit')->id = $this->parent->id;
			}
		}

		# Process selector block

		private function processSelector(Template\Asset\Block $selector) {

			if ($this->create) return $selector->disable();

			$parent = Entitizer::get(static::$type, $this->entity->parent_id);

			$selector->set(static::$naming, $parent->__get(static::$naming));
		}

		# Get contents

		private function getContents() {

			$contents = View::get(static::$view);

			# Set id

			$contents->id = $this->entity->id;

			# Set path / title

			if (static::$nesting) $contents->path = $this->parent->path;

			else $contents->title = ($this->create ? Language::get(static::$naming_new) : $this->entity->__get(static::$naming));

			# Set link

			$link = (INSTALL_PATH . static::$link . '/');

			if (static::$nesting) $contents->link = ($link . ($this->create ? 'create' : 'edit') . '?id=' . $this->parent->id);

			else $contents->link = ($link . ($this->create ? 'create' : ('edit?id=' . $this->entity->id)));

			# Process parent block

			if (static::$nesting) $this->processParent($contents->block('parent'));

			# Process selector block

			if (static::$nesting) $this->processSelector($contents->block('selector'));

			# Implement form

			$this->form->implement($contents);

			# Add additional data for specific entity

			$this->processEntity($contents);

			# ------------------------

			return $contents;
		}

		# Handle ajax request

		private function handleAjax() {

			$ajax = Ajax::response();

			# Create entity

			$this->entity = Entitizer::get(static::$type, Number::format(Request::get('id')));

			# Process remove action

			if (Request::post('action') === 'remove') {

				if (!$this->entity->remove()) return $ajax->error(Language::get(static::$message_error_remove));
			}

			# ------------------------

			return $ajax;
		}

		# Handle request

		public function handle(bool $create = false) {

			if (!($this->create = $create) && Request::isAjax()) return $this->handleAjax();

			# Create entity

			if (static::$nesting) $this->parent = Entitizer::get(static::$type, Number::format(Request::get('id')));

			$this->entity = Entitizer::get(static::$type, (!$this->create ? Number::format(Request::get('id')) : 0));

			# Redirect if entity not found

			if (!$this->create && (0 === $this->entity->id)) return Request::redirect(INSTALL_PATH . static::$link);

			# Create form

			$this->form = new static::$form_class($this->entity);

			if (static::$nesting && $this->create) $this->form->get('parent_id')->set($this->parent->id);

			# Handle form

			if ($this->form->handle(new static::$controller($this->entity))) {

				Request::redirect(INSTALL_PATH . static::$link . '/edit?id=' . $this->entity->id . '&submitted');
			}

			# Display success message

			if (!$this->create && (false !== Request::get('submitted'))) {

				Messages::success(Language::get(static::$message_success_save));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
