<?php

namespace Modules\Install\Controller {

	use Modules\Install, Exception, DB, JSON;

	class Database {

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$server = ''; $user = ''; $password = ''; $name = '';

			# Extract post array

			extract($post);

			# Connect to DB

			try { DB::connect($server, $user, $password, $name); }

			catch (Exception\DBConnect $error) { return 'INSTALL_ERROR_DATABASE_CONNECT'; }

			catch (Exception\DBSelect $error) { return 'INSTALL_ERROR_DATABASE_SELECT'; }

			catch (Exception\DBCharset $error) { return 'INSTALL_ERROR_DATABASE_CHARSET'; }

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

			$system_file = (DIR_SYSTEM_DATA . 'System.json');

			if (false === JSON::save($system_file, $system)) return 'INSTALL_ERROR_SYSTEM';

			# ------------------------

			return true;
		}
	}
}
