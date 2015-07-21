<?php

namespace System\Utils\Entity\Type\Page {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

		protected $table = TABLE_PAGES, $nesting = true, $super = true;

        # Define params

        protected function define() {

            $this->params->relation         ('parent_id');
            $this->params->range            ('access', ACCESS_PUBLIC, true);
            $this->params->varchar          ('name', null, true);
            $this->params->varchar          ('title', null, true);
            $this->params->text             ('contents');
            $this->params->text             ('description');
            $this->params->text             ('keywords');
            $this->params->boolean          ('robots_index', true);
            $this->params->boolean          ('robots_follow', true);
            $this->params->relation         ('user_id');
            $this->params->time             ('time_created');
            $this->params->time             ('time_modified');
        }
    }
}

?>
