<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form, Utils\Range;

	class Page extends Form {

		protected $name = 'page';

		# Constructor

		public function __construct(Entitizer\Entity\Page $page) {

			$this->addText('title', $page->title, FORM_FIELD_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $page->name, FORM_FIELD_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, ['required' => true, 'convert' => 'url']);

			$this->addSelect('visibility', $page->visibility, Range\Visibility::getRange());

			$this->addSelect('access', $page->access, Range\Access::getRange());

			$this->addText('description', $page->description, FORM_FIELD_TEXTAREA, CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);

			$this->addText('keywords', $page->keywords, FORM_FIELD_TEXTAREA, CONFIG_PAGE_KEYWORDS_MAX_LENGTH);

			$this->addCheckbox('robots_index', ((0 !== $page->id) ? $page->robots_index : true));

			$this->addCheckbox('robots_follow', ((0 !== $page->id) ? $page->robots_follow : true));

			$this->addText('contents', $page->contents, FORM_FIELD_TEXTAREA, 0, ['multiline' => true, 'codestyle' => true]);
		}
	}
}
