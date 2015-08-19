<?php

namespace System\Forms\Admin\Content\Pages {

	use System\Utils\Entitizer, System\Utils\Lister, Form;

	class Edit extends Form {

        # Constructor

        public function __construct(Entitizer\Type\Page\Manager $page) {

            parent::__construct('page');

            # Add fields

			$this->input('parent_id', $page->parent_id, FORM_INPUT_HIDDEN);

			$this->input('title', $page->title, FORM_INPUT_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('name', $page->name, FORM_INPUT_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, '', FORM_FIELD_TRANSLIT | FORM_FIELD_REQUIRED);

			$this->select('visibility', $page->visibility, Lister\Visibility::range());

			$this->select('access', $page->access, Lister\Access::range());

			$this->input('description', $page->description, FORM_INPUT_TEXTAREA, CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);

			$this->input('keywords', $page->keywords, FORM_INPUT_TEXTAREA, CONFIG_PAGE_KEYWORDS_MAX_LENGTH);

			$this->checkbox('robots_index', $page->robots_index);

			$this->checkbox('robots_follow', $page->robots_follow);

			$this->input('contents', $page->contents, FORM_INPUT_TEXTAREA);
        }
    }
}
