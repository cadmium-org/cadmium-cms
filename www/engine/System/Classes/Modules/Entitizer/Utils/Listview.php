<?php

namespace System\Modules\Entitizer\Utils {

    use System\Modules\Entitizer, System\Utils\Pagination, System\Utils\View, Ajax, Form, Language, Number, Request, Template, Url;

    trait Listview {

        private static $index = 0, $parent = null, $items = array();

        # Process parent block

        private static function processParent(Template\Utils\Block $parent) {

            # Set parent id

            $parent->id = self::$parent->id;

            # Set parent naming

            $naming = ((0 !== self::$parent->id) ? self::$parent->__get(self::$naming) : ('- ' . Language::get('NONE')));

            $parent->set(self::$naming, $naming);

            # Set create button

            $parent->block('create')->id = self::$parent->id;

            # Set edit button

            if (0 === self::$parent->id) $parent->block('edit')->disable();

            else $parent->block('edit')->id = self::$parent->id;
		}

        # Get items block

        private static function getItemsBlock($ajax = false) {

			$items = Template::group();

			foreach (self::$items['items'] as $item) {

				$items->add($view = View::get($ajax ? self::$view_ajax_item : self::$view_item));

                # Set data

				$view->id = $item['id']; $view->set(self::$naming, $item[self::$naming]);

                # Set remove button

                $super = (self::$super && ($item['id'] === 1));

                $has_children = (self::$nesting && ($item['children'] > 0));

				$view->block('remove')->class = ((!$super && !$has_children) ? 'negative' : 'disabled');

                # Add item additional data

                self::processItem($view, $item);
			}

            # ------------------------

			return $items;
		}

        # Get pagination

        private static function getPaginationBlock() {

			$url = new Url(self::$link . (self::$nesting ? ('?parent_id=' . self::$parent->id) : ''));

			return Pagination::block(self::$index, self::$display, self::$items['total'], $url);
		}

        # Get contents

        private static function getContents($ajax = false) {

			$contents = View::get($ajax ? self::$view_ajax_main : self::$view_main);

            # Set path

			if (self::$nesting) $contents->path = self::$parent->path;

            # Process parent block

            if (self::$nesting) self::processParent($contents->block('parent'));

			# Set items

			$items = self::getItemsBlock($ajax);

			if ($items->count() > 0) $contents->items = $items;

			# Set pagination

			if (!$ajax) $contents->pagination = self::getPaginationBlock();

            # Add additional data for specific entity

            self::processEntity($contents);

			# ------------------------

			return $contents;
		}

        # Handle ajax request

        private static function handleAjax() {

            $ajax = Ajax::dataset();

            # Process form

			$form = new Form('ajax'); $form->virtual('id');

			if (false === ($post = $form->post())) return $ajax->error();

            # Create parent entity

            if (self::$nesting) self::$parent = Entitizer::create(self::$type, Request::get('parent_id'));

            # Get children items

            self::$items = self::getItems($post['id']);

            # ------------------------

            return $ajax->set('contents', self::getContents(true)->contents(true));
        }

        # Handle common request

        public static function handle() {

            if (Request::isAjax()) return self::handleAjax();

			self::$index = Number::format(Request::get('index'), 1, 999999);

			# Create parent entity

			if (self::$nesting) self::$parent = Entitizer::create(self::$type, Request::get('parent_id'));

			# Get children items

			self::$items = self::getItems();

			# ------------------------

			return self::getContents();
		}
    }
}
