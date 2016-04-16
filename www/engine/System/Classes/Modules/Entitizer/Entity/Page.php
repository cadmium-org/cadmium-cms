<?php

namespace Modules\Entitizer\Entity {

	use Modules\Auth, Modules\Entitizer, Modules\Settings, DB;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Check if active

		private function getActive() {

			return (($this->visibility === VISIBILITY_PUBLISHED) && !$this->locked);
		}

		# Get link

		private function getLink() {

			if ('' === $this->data['slug']) return '';

			return (INSTALL_PATH . '/' . $this->data['slug']);
		}

		# Get canonical

		private function getCanonical() {

			if ('' === $this->data['slug']) return '';

			return (Settings::get('system_url') . (($this->id !== 1) ? ('/' . $this->data['slug']) : ''));
		}

		# Implement entity

		protected function implement() {

			$this->data['active'] = $this->getActive();

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}

		# Init by slug

		public function initBySlug(string $slug) {

			if (!$this->modifiable || (0 !== $this->id)) return false;

			# Process value

			$slug = $this->definition->param('slug')->cast($slug);

			# Process selection

			$selection = array_keys($this->definition->params());

			foreach ($selection as $key => $field) $selection[$key] = ('ent.' . $field);

			# Process query

			$query = ("SELECT " . implode(', ', $selection) .", rel.ancestor as parent_id ") .

			         ("FROM " . static::$table . " ent ") .

			         ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			         ("WHERE ent.visibility = " . VISIBILITY_PUBLISHED . " AND ent.access <= " . Auth::user()->rank . " AND ") .

			         ("ent.locked = 0 AND ent.slug = '" . addslashes($slug) . "' LIMIT 1");

			# Select entity from DB

			if (($this->error = !(DB::send($query) && DB::last()->status)) || (DB::last()->rows !== 1)) return false;

			# ------------------------

			return $this->setData(DB::last()->row());
		}

		# Update slugs

		public function updateSlugs() {

			if (!$this->modifiable || (0 === $this->id)) return false;

			# Send lock/update request

			$query = ("UPDATE " . static::$table . " ent JOIN (") .

			         ("SELECT rel.descendant as id, GROUP_CONCAT(ens.name ORDER BY rls.depth DESC SEPARATOR '/') slug ") .

			         ("FROM " . static::$table_relations . " rel ") .

			         ("JOIN " . static::$table_relations . " rls ON rls.descendant = rel.descendant ") .

			         ("JOIN " . static::$table . " ens ON ens.id = rls.ancestor ") .

			         ("WHERE rel.ancestor = " . $this->id . " GROUP BY rel.descendant") .

			         (") slg ON slg.id = ent.id SET ent.locked = 1, ent.slug = slg.slug");

			if (!(DB::send($query) && DB::last()->status)) return false;

			# Send unlock request

			$query = ("UPDATE " . static::$table . " ent JOIN (") .

			         ("SELECT rel.descendant as id FROM " . static::$table_relations . " rel ") .

			         ("JOIN " . static::$table . " enc ON enc.id = rel.descendant AND enc.locked = 1 ") .

			         ("LEFT JOIN " . static::$table . " end ON end.id != enc.id AND end.slug = enc.slug ") .

			         ("WHERE end.id IS NULL GROUP BY rel.descendant") .

			         (") chk ON chk.id = ent.id SET ent.locked = 0");

			if (!(DB::send($query) && DB::last()->status)) return false;

			# ------------------------

			return true;
		}

		# Create page entry in DB

		public function create(array $data) {

			if (!parent::create($data)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}

		# Edit page entry in DB

		public function edit(array $data) {

			if (!parent::edit($data)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}

		# Move page to new parent

		public function move(int $parent_id) {

			if (!parent::move($parent_id)) return false;

			$this->updateSlugs();

			# ------------------------

			return true;
		}
	}
}
