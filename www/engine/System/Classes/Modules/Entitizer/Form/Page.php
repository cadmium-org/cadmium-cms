<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Entitizer, System\Utils\Form, System\Utils\Lister;

	class Page extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Page $page) {

			parent::__construct(ENTITY_TYPE_PAGE);

			# Add fields

			$this->input('parent_id', $page->parent_id, FORM_INPUT_HIDDEN);

			$this->input('title', $page->title, FORM_INPUT_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->input('name', $page->name, FORM_INPUT_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, ['required' => true, 'translit' => true]);

			$this->select('visibility', $page->visibility, Lister\Visibility::list());

			$this->select('access', $page->access, Lister\Access::list());

			$this->textarea('description', $page->description, CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);

			$this->textarea('keywords', $page->keywords, CONFIG_PAGE_KEYWORDS_MAX_LENGTH);

			$this->checkbox('robots_index', $page->robots_index);

			$this->checkbox('robots_follow', $page->robots_follow);

			$this->textarea('contents', $page->contents);
		}
	}
}
