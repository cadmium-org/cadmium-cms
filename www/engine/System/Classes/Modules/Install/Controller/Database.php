<?php

namespace System\Modules\Install\Controller {

	use Error, System\Modules\Install, DB, Explorer;

	abstract class Database {

		# Errors

		const ERROR_DATABASE_CONNECT                = 'INSTALL_ERROR_DATABASE_CONNECT';
		const ERROR_DATABASE_SELECT                 = 'INSTALL_ERROR_DATABASE_SELECT';
		const ERROR_DATABASE_CHARSET                = 'INSTALL_ERROR_DATABASE_CHARSET';

		const ERROR_DATABASE_TABLES_CREATE          = 'INSTALL_ERROR_DATABASE_TABLES_CREATE';
		const ERROR_DATABASE_TABLES_FILL            = 'INSTALL_ERROR_DATABASE_TABLES_FILL';

		const ERROR_SYSTEM                          = 'INSTALL_ERROR_SYSTEM';

        # Process post data

        public static function process($post) {

            $database_server = null; $database_user = null; $database_password = null; $database_name = null;

            # Extract post array

            extract($post);

            # Connect to DB

            try { DB::connect($database_server, $database_user, $database_password, $database_name); }

            catch (Error\DBConnect $error) { return self::ERROR_DATABASE_CONNECT; }

            catch (Error\DBSelect $error) { return self::ERROR_DATABASE_SELECT; }

            catch (Error\DBCharset $error) { return self::ERROR_DATABASE_CHARSET; }

            # Create tables

            if (!Install\Utils\Tables::create()) return self::ERROR_DATABASE_TABLES_CREATE;

            # Fill tables

            if (!Install\Utils\Tables::fill()) return self::ERROR_DATABASE_TABLES_FILL;

            # Save system file

            $system = array();

            $system['database']['server']       = $database_server;
            $system['database']['user']         = $database_user;
            $system['database']['password']     = $database_password;
            $system['database']['name']         = $database_name;

            $system['time'] = REQUEST_TIME;

			$system_file = (DIR_SYSTEM_DATA . 'System.json'); $system = json_encode($system, JSON_PRETTY_PRINT);

            if (false === Explorer::save($system_file, $system, true)) return self::ERROR_SYSTEM;

            # ------------------------

            return true;
        }
	}
}
