<?php

namespace System\Utils\Auth\View {

	use System\Views\View;

	/**
	 * @property-write string $site_title
	 * @property-write string $system_utl
	 * @property-write string $name
	 * @property-write string $link
	 * @property-write string $system_email
     * @property-write string $copyright
	 */

	class Register extends View {

        public function __construct() {

            parent::__construct(DIR_SYSTEM_DATA . 'Mail/Register.tpl');
        }
    }
}
