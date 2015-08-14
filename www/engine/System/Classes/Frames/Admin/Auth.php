<?php

namespace System\Frames\Admin {

	use DB;

	abstract class Auth extends Handler {

        # Check if initial registration required

        protected function initial() {

			DB::select(TABLE_USERS, 'id', array('id' => 1), null, 1);

			if (!(DB::last() && DB::last()->status)) return false;

			return (DB::last()->rows === 0);
        }
	}
}
