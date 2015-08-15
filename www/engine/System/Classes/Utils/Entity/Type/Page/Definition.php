<?php

namespace System\Utils\Entity\Type\Page {

	use System\Utils\Entity;

	class Definition extends Entity {

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
