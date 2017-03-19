<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Entity {

	use Modules\Auth, Modules\Entitizer, DB;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		/**
 		 * Initialize the page by a slug
		 *
		 * @return bool : true on success or false on failure
		 */

		public function initBySlug(string $slug) : bool {

			if (0 !== $this->id) return false;

			# Process value

			$slug = $this->definition->getParam('slug')->cast($slug);

			# Process selection

			$selection = array_keys($this->definition->getParams());

			foreach ($selection as $key => $field) $selection[$key] = ('ent.' . $field);

			# Process query

			$query = ("SELECT " . implode(', ', $selection) .", rel.ancestor as parent_id ") .

			         ("FROM " . static::$table . " ent ") .

			         ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			         ("WHERE ent.visibility = " . VISIBILITY_PUBLISHED . " AND ent.access <= " . Auth::get('rank') . " AND ") .

			         ("ent.locked = 0 AND ent.slug = '" . addslashes($slug) . "' LIMIT 1");

			# Select entity from DB

			if (!(DB::send($query) && (DB::getLast()->rows === 1))) return false;

			# ------------------------

			return $this->setData(DB::getLast()->getRow());
		}

		/**
 		 * Update slugs of the page descendants
		 *
		 * @return bool : true on success or false on failure
		 */

		public function updateSlugs() : bool {

			if (0 === $this->id) return false;

			# Send lock/update request

			$query = ("UPDATE " . static::$table . " ent JOIN (") .

			         ("SELECT rel.descendant as id, GROUP_CONCAT(ens.name ORDER BY rls.depth DESC SEPARATOR '/') slug ") .

			         ("FROM " . static::$table_relations . " rel ") .

			         ("JOIN " . static::$table_relations . " rls ON rls.descendant = rel.descendant ") .

			         ("JOIN " . static::$table . " ens ON ens.id = rls.ancestor ") .

			         ("WHERE rel.ancestor = " . $this->id . " GROUP BY rel.descendant") .

			         (") slg ON slg.id = ent.id SET ent.locked = 1, ent.slug = slg.slug");

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Send unlock request

			$query = ("UPDATE " . static::$table . " ent JOIN (") .

			         ("SELECT rel.descendant as id FROM " . static::$table_relations . " rel ") .

			         ("JOIN " . static::$table . " enc ON enc.id = rel.descendant AND enc.locked = 1 ") .

			         ("LEFT JOIN " . static::$table . " end ON end.id != enc.id AND end.slug = enc.slug ") .

			         ("WHERE end.id IS NULL GROUP BY rel.descendant") .

			         (") chk ON chk.id = ent.id SET ent.locked = 0");

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# ------------------------

			return true;
		}

		/**
		 * Create the page entry in DB
		 *
		 * @return bool : true on success or false on failure
		 */

		public function create(array $data) : bool {

			if (!parent::create($data)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}

		/**
		 * Edit the page entry in DB
		 *
		 * @return bool : true on success or false on failure
		 */

		public function edit(array $data) : bool {

			if (!parent::edit($data)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}

		/**
		 * Move the page to a new parent
		 *
		 * @return bool : true on success or false on failure
		 */

		public function move(int $parent_id) : bool {

			if (!parent::move($parent_id)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}
	}
}
