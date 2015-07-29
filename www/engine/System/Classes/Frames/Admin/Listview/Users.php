<?php

namespace System\Frames\Admin\Listview {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	abstract class Users extends System\Frames\Admin\Handler {

		private $index = false, $users = false;

		# Get users

		private function getUsers() {

			$users = array('items' => array(), 'total' => 0);

			# Select users

			$limit = ((($this->index - 1) * CONFIG_ADMIN_USERS_DISPLAY) . ", " . CONFIG_ADMIN_USERS_DISPLAY);

			$query = ("SELECT SQL_CALC_FOUND_ROWS usr.id, usr.rank, usr.name FROM " . TABLE_USERS . " usr ") .

					 ("ORDER BY usr.rank DESC, usr.name ASC, usr.id ASC LIMIT " . $limit);

			if (!(DB::send($query) && DB::last()->status)) return $users;

			# Process selection

			while (null !== ($user = DB::last()->row())) $users['items'][] = array (

				'id'        => Number::unsigned($user['id']),

				'rank'      => Number::unsigned($user['rank']),

				'name'      => String::validate($user['name'])
			);

			# Count users total

			if (DB::send('SELECT FOUND_ROWS() as total') && (DB::last()->rows === 1)) {

				$users['total'] = Number::unsigned(DB::last()->row()['total']);
			}

			# ------------------------

			return $users;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/System/Users/List/Main');

			# Set list

			$list = Template::group();

			foreach ($this->users['items'] as $user) {

				$list->add($item = Template::block('Contents/System/Users/List/Item'));

				$item->id = $user['id']; $item->name = $user['name']; $item->rank = Lister::rank($user['rank']);

				$item->block('remove')->class = (($user['id'] !== Auth::user()->id) ? 'negative' : 'disabled');
			}

			if ($list->count() > 0) $contents->list = $list;

			# Set pagination

			$display = CONFIG_ADMIN_USERS_DISPLAY; $url = new Url('/admin/system/users');

			$contents->pagination = Pagination::block($this->index, $display, $this->users['total'], $url);

			# ------------------------

			return $contents;
		}

		# Handle list

		protected function handleList($error = false) {

			if (Validate::boolean($error)) Messages::error(Language::get('USERS_ITEM_NOT_FOUND'));

			$this->index = Number::index(Request::get('index'));

			# Get users

			$this->users = $this->getUsers();

			# Fill template

			$this->setTitle(Language::get('TITLE_SYSTEM_USERS'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}

?>
