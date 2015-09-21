<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer, Arr;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Get link

		private function getLink() {

			return ('/' . implode('/', Arr::subvalExtract($this->data['path'], 'name')));
		}

		# Get canonical

		private function getCanonical() {

			return (($this->id !== 1) ? $this->data['link'] : '');
		}

		# Implement entity

		protected function implement() {

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}

		# Check if name available

		public function checkName($name, $parent_id = 0) {

			$name = strval($name); $parent_id = intabs($parent_id);

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->id . " AND parent_id = " . $parent_id);

			DB::select(TABLE_PAGES, 'id', $condition, null, 1);

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}
    }
}
