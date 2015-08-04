<?php

namespace System\Utils\Entity\Type\Page {

	use System\Utils\Entity;

	/**
	 * @property-read int $visibility
	 * @property-read int $access
	 * @property-read string $name
	 * @property-read string $title
	 * @property-read string $contents
	 * @property-read string $description
	 * @property-read string $keywords
	 * @property-read int $robots_index
	 * @property-read int $robots_follow
	 * @property-read int $time_created
	 * @property-read int $time_modified
	 */

	class Definition extends Entity\Entity {

		const TYPE = 'Page', TABLE = TABLE_PAGES, NESTING = true, HAS_SUPER = true;

        # Define presets

        protected function define() {

			# Add params

			$this->params->range            ('visibility', VISIBILITY_DRAFT, true);
            $this->params->range            ('access', ACCESS_PUBLIC, true);
            $this->params->varchar          ('name', null, true);
            $this->params->varchar          ('title', null, true);
            $this->params->text             ('contents');
            $this->params->text             ('description');
            $this->params->text             ('keywords');
            $this->params->boolean          ('robots_index', true);
            $this->params->boolean          ('robots_follow', true);
			$this->params->time             ('time_created');
			$this->params->time             ('time_modified');
        }
    }
}
