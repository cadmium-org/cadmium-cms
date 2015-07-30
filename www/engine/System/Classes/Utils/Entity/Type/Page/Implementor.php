<?php

namespace System\Utils\Entity\Type\Page {

	use Arr;

	class Implementor extends Definition {

		# Get path

		private function getPath() {

			$path = array();

			if (false !== $this->path) foreach ($this->path as $entity) {

				$id = $entity->id; $parent_id = $entity->data['parent_id'];

				$name = $entity->data['name']; $title = $entity->data['title'];

				$path[] = array('id' => $id, 'parent_id' => $parent_id, 'name' => $name, 'title' => $title);
			}

			# ------------------------

			return $path;
		}

		# Get link

		private function getLink() {

			return ('/' . implode('/', Arr::subvalExtract($this->data['path'], 'name')));
		}

		# Get canonical

		private function getCanonical() {

			return (($this->id !== 1) ? $this->data['link'] : '');
		}

		# Implement entity

		public function implement() {

			$this->data['path'] = $this->getPath();

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();

			# ------------------------

			return true;
		}
    }
}
