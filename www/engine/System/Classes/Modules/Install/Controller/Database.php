<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Install\Controller {

	use Modules\Install, Utils\Schema, Exception, DB;

	class Database {

		/**
		 * Invoker
		 *
		 * @return true|string : true on success or an error code on failure
		 */

		public function __invoke(array $post) {

			# Declare variables

			$server = ''; $user = ''; $password = ''; $name = '';

			# Extract post array

			extract($post);

			# Connect to DB

			try { DB::connect($server, $user, $password, $name); }

			catch (Exception\DBConnect $error) { return 'INSTALL_ERROR_DATABASE_CONNECT'; }

			catch (Exception\DBCharset $error) { return 'INSTALL_ERROR_DATABASE_CHARSET'; }

			catch (Exception\DBSelect $error) { return 'INSTALL_ERROR_DATABASE_SELECT'; }

			# Create tables

			if (!Install\Utils\Tables::create()) return 'INSTALL_ERROR_DATABASE_TABLES_CREATE';

			# Fill tables

			if (!Install\Utils\Tables::fill()) return 'INSTALL_ERROR_DATABASE_TABLES_FILL';

			# Save system file

			$system = [];

			$system['database']['server']       = $server;
			$system['database']['user']         = $user;
			$system['database']['password']     = $password;
			$system['database']['name']         = $name;

			$system['time'] = REQUEST_TIME;

			if (!Schema::get('System')->save($system)) return 'INSTALL_ERROR_SYSTEM';

			# ------------------------

			return true;
		}
	}
}
