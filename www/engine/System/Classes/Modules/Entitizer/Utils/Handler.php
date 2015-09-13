<?php

namespace System\Modules\Entitizer\Utils {

    use System\Modules\Entitizer, System\Utils\Messages, System\Utils\View, Ajax, Form, Language, Request, Template;

    trait Handler {

        private static $create = false, $parent = null, $entity = null, $form = null;

        # Process parent block

        private static function processParent(Template\Utils\Block $parent) {

            # Set parent id

            $parent->id = self::$parent->id;

            # Set create button

            $parent->block('create')->class = (self::$create ? 'active item' : 'item');

            $parent->block('create')->id = self::$parent->id;

            # Set edit button

			if (0 === self::$parent->id) $parent->block('edit')->disable(); else {

                $parent->block('edit')->class = (!self::$create ? 'active item' : 'item');

                $parent->block('edit')->id = self::$parent->id;
            }
        }

        # Process selector block

        private static function processSelector(Template\Utils\Block $selector) {

            if (self::$create) return $selector->disable();

            $parent = Entitizer::create(self::$type, self::$entity->parent_id);

            $title = ((0 !== $parent->id) ? $parent->__get(self::$naming) : ('- ' . Language::get('NONE')));

            $selector->set(self::$naming, $title);
        }

        # Get contents

		private static function getContents() {

			$contents = View::get(self::$view);

            # Set id

            $contents->id = self::$entity->id;

            # Set path / title

            if (self::$nesting) $contents->path = self::$parent->path;

			else $contents->title = (self::$create ? Language::get(self::$naming_new) : self::$entity->__get(self::$naming));

            # Set link

            if (self::$nesting) $contents->link = ((self::$create ? 'create' : 'edit') . '?id=' . self::$parent->id);

			else $contents->link = (self::$link . '/' .  (self::$create ? 'create' : ('edit?id=' . self::$entity->id)));

            # Process parent block

            if (self::$nesting) self::processParent($contents->block('parent'));

            # Process selector block

            if (self::$nesting) self::processSelector($contents->block('selector'));

			# Implement form

			self::$form->implement($contents);

			# Add additional data for specific entity

            self::processEntity($contents);

			# ------------------------

			return $contents;
		}

        # Handle ajax request

		private static function handleAjax() {

            $ajax = Ajax::dataset();

            # Process form

            $form = new Form('ajax'); $form->virtual('action');

            if (false === ($post = $form->post())) return $ajax->error();

            # Create entity

            self::$entity = Entitizer::create(self::$type, Request::get('id'));

            # Process remove action

            if ($post['action'] == 'remove') if (!self::$entity->remove()) return Ajax::error();

            # ------------------------

            return $ajax;
		}

		# Handle request

		public static function handle($create = false) {

            self::$create = boolval($create);

			if (!self::$create && Request::isAjax()) return self::handleAjax();

            # Create entity

            if (self::$nesting) self::$parent = Entitizer::create(self::$type, Request::get('id'));

            self::$entity = Entitizer::controller(self::$type, (!self::$create ? Request::get('id') : 0));

            # Redirect if entity not found

            if (!self::$create && (0 === self::$entity->id)) return Request::redirect(self::$link);

			# Create form

			self::$form = new self::$form_class(self::$entity);

            if (self::$nesting && self::$create) self::$form->get('parent_id')->set(self::$parent->id);

            # Submit form

            if (self::$form->submit(array(self::$entity, (self::$create ? 'create' : 'edit')))) {

				Request::redirect(self::$link . '/edit?id=' . self::$entity->id . '&submitted');

			} else if (!self::$create && (null !== Request::get('submitted'))) {

				Messages::success(Language::get(self::$message_success_save));
			}

			# ------------------------

			return self::getContents();
		}
    }
}
