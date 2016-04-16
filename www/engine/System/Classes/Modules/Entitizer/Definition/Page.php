<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Page extends Entitizer\Utils\Definition {

		use Entitizer\Common\Page;

		# Define presets

		protected function define() {

			# Add params

			$this->params->integer      ('visibility',          true, 1, true, VISIBILITY_DRAFT);
			$this->params->integer      ('access',              true, 1, true, ACCESS_PUBLIC);
			$this->params->boolean      ('locked',              true);
			$this->params->textual      ('slug',                true, 255, false, '');
			$this->params->textual      ('name',                true, 255, false, '');
			$this->params->textual      ('title',               true, 255, false, '');
			$this->params->textual      ('contents',            false, 0, false, '');
			$this->params->textual      ('description',         false, 0, false, '');
			$this->params->textual      ('keywords',            false, 0, false, '');
			$this->params->boolean      ('robots_index',        false);
			$this->params->boolean      ('robots_follow',       false);
			$this->params->integer      ('time_created',        false, 10, true, 0);
			$this->params->integer      ('time_modified',       false, 10, true, 0);

			# Add indexes

			$this->indexes->add         ('visibility');
			$this->indexes->add         ('access');
			$this->indexes->add         ('slug');
			$this->indexes->add         ('name');
			$this->indexes->add         ('title');
			$this->indexes->add         ('time_created');
			$this->indexes->add         ('time_modified');
		}
	}
}
