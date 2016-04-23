<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, Utils\Popup, Utils\View, Ajax, Language, Number, Request, Template;

	abstract class Handler {

		protected $create = false, $entity = null, $parent = null, $path = [], $form = null;

		# Process parent block

		private function processParent(Template\Asset\Block $parent) {

			# Set parent id

			$parent->id = $this->parent->id;

			# Set create button

			if (count($this->path) < CONFIG_ENTITIZER_MAX_DEPTH) {

				$parent->block('create')->class = ($this->create ? 'active item' : 'item');

				$parent->block('create')->id = $this->parent->id;

			} else { $parent->block('create')->disable(); $parent->block('create_disabled')->enable(); }

			# Set edit button

			if (0 !== $this->parent->id) {

				$parent->block('edit')->class = (!$this->create ? 'active item' : 'item');

				$parent->block('edit')->id = $this->parent->id;

			} else { $parent->block('edit')->disable(); $parent->block('edit_disabled')->enable(); }

			# Add parent additional data

			$this->processEntityParent($parent);
		}

		# Process selector block

		private function processSelector(Template\Asset\Block $selector) {

			if ($this->create) return $selector->disable();

			$selector->parent_id = $this->entity->parent_id;

			$parent = Entitizer::get(static::$table, $this->entity->parent_id);

			$selector->super_parent_id = $parent->parent_id;

			$selector->set(static::$naming, $parent->get(static::$naming));
		}

		# Get contents

		private function getContents() {

			$contents = View::get(static::$view);

			# Set id

			$contents->id = $this->entity->id;

			# Set path / title

			if (static::$nesting) $contents->path = $this->path;

			else $contents->title = ($this->create ? Language::get(static::$naming_new) : $this->entity->get(static::$naming));

			# Process parent block

			if (static::$nesting) $this->processParent($contents->block('parent'));

			# Set link

			$link = (INSTALL_PATH . static::$link . '/');

			if (static::$nesting) $contents->link = ($link . ($this->create ? 'create' : 'edit') . '?id=' . $this->parent->id);

			else $contents->link = ($link . ($this->create ? 'create' : ('edit?id=' . $this->entity->id)));

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

			$id = Number::format(Request::get('id'));

			$this->entity = Entitizer::get(static::$table, (!$this->create ? $id : 0));

			# Process actions

			if (Request::post('action') === 'move') {

				$parent_id = Number::format(Request::post('parent_id'));

				if (!$this->entity->move($parent_id)) return $ajax->error(Language::get(static::$message_error_move));

			} else if (Request::post('action') === 'remove') {

				if (!$this->entity->remove()) return $ajax->error(Language::get(static::$message_error_remove));
			}

			# ------------------------

			return $ajax;
		}

		# Handle request

		public function handle(bool $create = false) {

			if (!($this->create = $create) && Request::isAjax()) return $this->handleAjax();

			# Create entity

			$id = Number::format(Request::get('id'));

			$this->entity = Entitizer::get(static::$table, (!$this->create ? $id : 0));

			if (!$this->create && (0 === $this->entity->id)) return Request::redirect(INSTALL_PATH . static::$link);

			# Create parent entity

			$this->parent = Entitizer::get(static::$table, (static::$nesting ? $id : 0));

			# Get path

			if (false !== ($path = $this->parent->path())) $this->path = $path;

			# Create form

			$this->form = new static::$form_class($this->entity);

			# Handle form

			if ($this->form->handle(new static::$controller($this->entity), true)) {

				if ($this->create && (0 !== $this->parent->id)) $this->entity->move($this->parent->id);

				Request::redirect(INSTALL_PATH . static::$link . '/edit?id=' . $this->entity->id . '&submitted');
			}

			# Display success message

			if (!$this->create && (false !== Request::get('submitted'))) {

				Popup::set('positive', Language::get(static::$message_success_save));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
