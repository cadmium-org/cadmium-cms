<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules\Auth;

	class Login extends System\Frames\Admin\Component\Auth {

		use Auth\Utils\Handler, Auth\Handler\Login;
	}
}
