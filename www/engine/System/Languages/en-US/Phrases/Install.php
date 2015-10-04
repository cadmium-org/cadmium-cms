<?php

return [

	# Titles

	'TITLE_INSTALL_CHECK'                       => 'Step 1. Checking requirements',
	'TITLE_INSTALL_DATABASE'                    => 'Step 2. MySQL settings',

	# Requirements

	'INSTALL_PHP_VERSION'                       => 'PHP version',

	'INSTALL_REQUIREMENT_MYSQLI_SUCCESS'        => 'Extension MySQLi is installed.',
	'INSTALL_REQUIREMENT_MYSQLI_FAIL'           => 'Extension MySQLi is not installed.',

	'INSTALL_REQUIREMENT_MBSTRING_SUCCESS'      => 'Extension Multibyte String is installed.',
	'INSTALL_REQUIREMENT_MBSTRING_FAIL'         => 'Extension Multibyte String is not installed.',

	'INSTALL_REQUIREMENT_GD_SUCCESS'            => 'Extension GD is installed.',
	'INSTALL_REQUIREMENT_GD_FAIL'               => 'Extension GD is not installed.',

	'INSTALL_REQUIREMENT_SIMPLEXML_SUCCESS'     => 'Extension SimpleXML is installed.',
	'INSTALL_REQUIREMENT_SIMPLEXML_FAIL'        => 'Extension SimpleXML is not installed.',

	'INSTALL_REQUIREMENT_REWRITE_SUCCESS'       => 'Module Rewrite is enabled.',
	'INSTALL_REQUIREMENT_REWRITE_FAIL'          => 'Module Rewrite is not enabled.',

	'INSTALL_REQUIREMENT_DATA_SUCCESS'          => 'Engine/System/Data is writable.',
	'INSTALL_REQUIREMENT_DATA_FAIL'             => 'Engine/System/Data is not writable.',

	'INSTALL_REQUIREMENT_UPLOADS_SUCCESS'       => 'Uploads directory is writable.',
	'INSTALL_REQUIREMENT_UPLOADS_FAIL'          => 'Uploads directory is not writable.',

	# Errors

	'INSTALL_ERROR_DATABASE_CONNECT'            => 'Unable to connect to database',
	'INSTALL_ERROR_DATABASE_SELECT'             => 'Unable to select database',
	'INSTALL_ERROR_DATABASE_CHARSET'            => 'Unable to set database charset',

	'INSTALL_ERROR_DATABASE_TABLES_CREATE'      => 'Error creating database tables',
	'INSTALL_ERROR_DATABASE_TABLES_FILL'        => 'Error saving initial data',

	'INSTALL_ERROR_SYSTEM'                      => 'Error saving main configuration file',

	# Fields

	'INSTALL_FIELD_LANGUAGE'                    => 'Language',
	'INSTALL_FIELD_TEMPLATE'                    => 'Template',

	'INSTALL_FIELD_DATABASE_SERVER'             => 'Server',
	'INSTALL_FIELD_DATABASE_USER'               => 'User name',
	'INSTALL_FIELD_DATABASE_PASSWORD'           => 'Password',
	'INSTALL_FIELD_DATABASE_NAME'               => 'Database name',

	# Pages

	'INSTALL_PAGE_INDEX_TITLE'                  => 'Home',

	'INSTALL_PAGE_INDEX_CONTENTS'               => '<p>Welcome! This is demo site, powered by <strong>Cadmium CMS</strong>.</p>' .
	                                               '<p>You can log in to admin panel by following <a href="/admin">this link</a>.</p>' .
	                                               '<p><a href="http://cadmium-cms.com" target="_blank">Cadmium CMS official site</a></p>' .
	                                               '<p><a href="http://cadmium-cms.com/documentation" target="_blank">Official documentation</a></p>',

	'INSTALL_PAGE_DEMO_TITLE'                   => 'Page',
	'INSTALL_PAGE_DEMO_CONTENTS'                => '<p>This is demo page.</p>'
];
