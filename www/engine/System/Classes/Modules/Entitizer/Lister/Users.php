<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Lister {

	use Modules\Auth, Modules\Entitizer, Utils\Range, Template;

	class Users extends Entitizer\Utils\Lister {

		use Entitizer\Common\User;

		protected $_title = 'TITLE_SYSTEM_USERS';

		# Lister configuration

		protected static $naming = 'name';

		protected static $view_main = 'Blocks/Entitizer/Users/Lister/Main';

		protected static $view_item = 'Blocks/Entitizer/Users/Lister/Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		protected static $link = '/admin/system/users';

		# Add additional data for specific entity

		protected function processEntity() {}

		/**
		 * Add item's additional data
		 */

		protected function processItem(Template\Block $view, Entitizer\Dataset\User $user) {

			$view->class = (($user->rank === RANK_GUEST) ? 'inactive' : '');

			$view->rank = (Range\Rank::get($user->rank) ?? '');

			# Set remove button

			if ($user->id === Auth::get('id')) $view->getBlock('remove')->class = 'disabled';
		}
	}
}
