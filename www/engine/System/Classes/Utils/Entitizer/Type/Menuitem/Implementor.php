<?php

namespace System\Utils\Entitizer\Type\Menuitem {

	class Implementor extends Definition {

		# Get path

		private function getPath() {

			$path = array();

			foreach ($this->path as $entity) {

				$id = $entity->id; $parent_id = $entity->data['parent_id'];

				$link = $entity->data['link']; $text = $entity->data['text'];

				$path[] = array('id' => $id, 'parent_id' => $parent_id, 'link' => $link, 'text' => $text);
			}

			return $path;
		}

		# Implement entity

		protected function implement() {

			$this->data['path'] = $this->getPath();
		}
	}
}
