<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form, Utils\Lister;

	class Page extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Page $page) {

			parent::__construct(ENTITY_TYPE_PAGE);

			# Add fields

			$this->addText('parent_id', $page->parent_id, FORM_FIELD_HIDDEN);

			$this->addText('title', $page->title, FORM_FIELD_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $page->name, FORM_FIELD_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, ['required' => true, 'convert' => 'url']);

			$this->addSelect('visibility', $page->visibility, Lister\Visibility::list());

			$this->addSelect('access', $page->access, Lister\Access::list());

			$this->addText('description', $page->description, FORM_FIELD_TEXTAREA, CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);

			$this->addText('keywords', $page->keywords, FORM_FIELD_TEXTAREA, CONFIG_PAGE_KEYWORDS_MAX_LENGTH);

			$this->addCheckbox('robots_index', $page->robots_index);

			$this->addCheckbox('robots_follow', $page->robots_follow);

			$this->addText('contents', $page->contents, FORM_FIELD_TEXTAREA, 0, ['multiline' => true, 'codestyle' => true]);
		}
	}
}
