<?php

/**
 * @package Cadmium\System\Languages\en-US
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

return [

	# Titles

	'TITLE_INSTALL_CHECK'                       => 'Step 1. Checking requirements',
	'TITLE_INSTALL_DATABASE'                    => 'Step 2. MySQL settings',

	'TITLE_AUTH_LOGIN'                          => 'Logging in',
	'TITLE_AUTH_RESET'                          => 'Password reset',
	'TITLE_AUTH_RECOVER'                        => 'Password recovery',
	'TITLE_AUTH_REGISTER'                       => 'Registration',

	'TITLE_CONTENT_PAGES'                       => 'Pages',
	'TITLE_CONTENT_PAGES_CREATE'                => 'Create page',
	'TITLE_CONTENT_PAGES_EDIT'                  => 'Edit page',

	'TITLE_CONTENT_MENUITEMS'                   => 'Menu',
	'TITLE_CONTENT_MENUITEMS_CREATE'            => 'Create item',
	'TITLE_CONTENT_MENUITEMS_EDIT'              => 'Edit item',

	'TITLE_CONTENT_VARIABLES'                   => 'Variables',
	'TITLE_CONTENT_VARIABLES_CREATE'            => 'Create variable',
	'TITLE_CONTENT_VARIABLES_EDIT'              => 'Edit variable',

	'TITLE_CONTENT_WIDGETS'                     => 'Widgets',
	'TITLE_CONTENT_WIDGETS_CREATE'              => 'Create widget',
	'TITLE_CONTENT_WIDGETS_EDIT'                => 'Edit widget',

	'TITLE_CONTENT_FILEMANAGER'                 => 'Files',
	'TITLE_CONTENT_FILEMANAGER_DIR'             => 'Edit directory',
	'TITLE_CONTENT_FILEMANAGER_FILE'            => 'Edit file',

	'TITLE_EXTEND_ADDONS'                       => 'Add-ons',
	'TITLE_EXTEND_LANGUAGES'                    => 'Languages',
	'TITLE_EXTEND_TEMPLATES'                    => 'Templates',

	'TITLE_SYSTEM_USERS'                        => 'Users',
	'TITLE_SYSTEM_USERS_CREATE'                 => 'Create user',
	'TITLE_SYSTEM_USERS_EDIT'                   => 'Edit user',

	'TITLE_SYSTEM_SETTINGS'                     => 'Settings',
	'TITLE_SYSTEM_INFORMATION'                  => 'Information',

	'TITLE_DASHBOARD'                           => 'Dashboard',
	'TITLE_PROFILE'                             => 'Profile',

	# Groups

	'GROUP_CONTENT'                             => 'Content',
	'GROUP_EXTEND'                              => 'Extensions',
	'GROUP_SYSTEM'                              => 'System',

	# Dashboard

	'DASHBOARD_GROUP_SITE'                      => 'Site info',
	'DASHBOARD_GROUP_SERVER'                    => 'Server',

	'DASHBOARD_ROW_SITE_TITLE'                  => 'Title',
	'DASHBOARD_ROW_SITE_STATUS'                 => 'Status',

	'DASHBOARD_ROW_SYSTEM_EMAIL'                => 'E-mail',
	'DASHBOARD_ROW_SYSTEM_TIMEZONE'             => 'Timezone',

	'DASHBOARD_ROW_OS_VERSION'                  => 'OS version',
	'DASHBOARD_ROW_PHP_VERSION'                 => 'PHP version',
	'DASHBOARD_ROW_MYSQL_VERSION'               => 'MySQL version',

	'DASHBOARD_LINK_SETTINGS'                   => 'Edit settings',
	'DASHBOARD_LINK_INFORMATION'                => 'More information',

	'DASHBOARD_MESSAGE_INSTALL_REQUIREMENTS'    => 'Some features may be unavailable due to a server misconfiguration. Please proceed to the ' .
	                                               '<a href="$install_path$/admin/system/information#diagnostics">diagnostics page</a> to learn more.',
	'DASHBOARD_MESSAGE_INSTALL_FILE'            => 'The installation file <b>install.php</b> still exists in the root of your site. ' .
	                                               'It\'s recommended to remove it.',
	'DASHBOARD_MESSAGE_SETTINGS_FILE'           => 'It seems you have not yet edited the site settings. ' .
	                                               'Go to the <a href="$install_path$/admin/system/settings">settings page</a> to provide actual data.',

	# Pages

	'PAGES_NOT_FOUND'                           => 'Pages not found',

	'PAGES_COLUMN_TITLE'                        => 'Title',
	'PAGES_COLUMN_ACCESS'                       => 'Access',

	'PAGES_ITEM_LIST'                           => 'List pages',
	'PAGES_ITEM_CREATE'                         => 'Create page',
	'PAGES_ITEM_CREATE_SUB'                     => 'Create subpage',
	'PAGES_ITEM_EDIT'                           => 'Edit',
	'PAGES_ITEM_BROWSE'                         => 'Browse',
	'PAGES_ITEM_REMOVE'                         => 'Remove',
	'PAGES_ITEM_SELECT'                         => 'Select',

	'PAGES_ITEM_CONFIRM_REMOVE'                 => 'Are you sure you want to remove selected page?',

	# Menuitems

	'MENUITEMS_NOT_FOUND'                       => 'Items not found',

	'MENUITEMS_COLUMN_TEXT'                     => 'Text',
	'MENUITEMS_COLUMN_POSITION'                 => 'Position',

	'MENUITEMS_ITEM_LIST'                       => 'List items',
	'MENUITEMS_ITEM_CREATE'                     => 'Create item',
	'MENUITEMS_ITEM_CREATE_SUB'                 => 'Create subitem',
	'MENUITEMS_ITEM_EDIT'                       => 'Edit',
	'MENUITEMS_ITEM_BROWSE'                     => 'Browse',
	'MENUITEMS_ITEM_REMOVE'                     => 'Remove',
	'MENUITEMS_ITEM_SELECT'                     => 'Select',

	'MENUITEMS_ITEM_CONFIRM_REMOVE'             => 'Are you sure you want to remove selected item?',

	# Variables

	'VARIABLES_NOT_FOUND'                       => 'Variables not found',

	'VARIABLES_COLUMN_TITLE'                    => 'Title',
	'VARIABLES_COLUMN_VALUE'                    => 'Value',

	'VARIABLES_ITEM_CREATE'                     => 'Create variable',
	'VARIABLES_ITEM_NEW'                        => 'New variable',
	'VARIABLES_ITEM_EDIT'                       => 'Edit',
	'VARIABLES_ITEM_REMOVE'                     => 'Remove',

	'VARIABLES_ITEM_CONFIRM_REMOVE'             => 'Are you sure you want to remove selected variable?',

	# Widgets

	'WIDGETS_NOT_FOUND'                         => 'Widgets not found',

	'WIDGETS_COLUMN_TITLE'                      => 'Title',

	'WIDGETS_ITEM_CREATE'                       => 'Create widget',
	'WIDGETS_ITEM_NEW'                          => 'New widget',
	'WIDGETS_ITEM_EDIT'                         => 'Edit',
	'WIDGETS_ITEM_REMOVE'                       => 'Remove',

	'WIDGETS_ITEM_CONFIRM_REMOVE'               => 'Are you sure you want to remove selected widget?',

	# Filemanager

	'FILEMANAGER_ORIGIN_ADDONS'                 => 'Addons',
	'FILEMANAGER_ORIGIN_LANGUAGES'              => 'Languages',
	'FILEMANAGER_ORIGIN_TEMPLATES'              => 'Templates',
	'FILEMANAGER_ORIGIN_UPLOADS'                => 'Uploads',

	'FILEMANAGER_UPLOAD_SELECT'                 => 'Select file...',

	'FILEMANAGER_LABEL_CREATE'                  => 'New directory...',

	'FILEMANAGER_ACTION_CREATE'                 => 'Create',
	'FILEMANAGER_ACTION_RELOAD'                 => 'Refresh',

	'FILEMANAGER_DIR_NAME'                      => 'Directory name',
	'FILEMANAGER_DIR_INFO'                      => 'Directory info',

	'FILEMANAGER_DIR_ROW_TIME_CREATED'          => 'Creation time',
	'FILEMANAGER_DIR_ROW_TIME_MODIFIED'         => 'Modification time',
	'FILEMANAGER_DIR_ROW_PERMISSIONS'           => 'Permissions',

	'FILEMANAGER_FILE_NAME'                     => 'File name',
	'FILEMANAGER_FILE_INFO'                     => 'File info',

	'FILEMANAGER_FILE_ROW_SIZE'                 => 'Size',
	'FILEMANAGER_FILE_ROW_MIME'                 => 'MIME type',
	'FILEMANAGER_FILE_ROW_TIME_CREATED'         => 'Creation time',
	'FILEMANAGER_FILE_ROW_TIME_MODIFIED'        => 'Modification time',
	'FILEMANAGER_FILE_ROW_PERMISSIONS'          => 'Permissions',

	'FILEMANAGER_ITEMS_NOT_FOUND'               => 'Directory is empty',

	'FILEMANAGER_COLUMN_NAME'                   => 'File name',
	'FILEMANAGER_COLUMN_SIZE'                   => 'Size',

	'FILEMANAGER_ITEM_EDIT'                     => 'Edit',
	'FILEMANAGER_ITEM_REMOVE'                   => 'Remove',

	'FILEMANAGER_ITEM_INSERT_AS_MEDIA'          => 'Insert as media',
	'FILEMANAGER_ITEM_INSERT_AS_LINK'           => 'Insert as link',

	'FILEMANAGER_FIELD_NAME'                    => 'Enter name...',

	'FILEMANAGER_SUCCESS_UPLOAD'                => 'File has been successfully uploaded!',

	'FILEMANAGER_SUCCESS_DIR_CREATE'            => 'Directory has been successfully created!',
	'FILEMANAGER_SUCCESS_DIR_RENAME'            => 'Directory has been successfully renamed!',

	'FILEMANAGER_SUCCESS_FILE_RENAME'           => 'File has been successfully renamed!',
	'FILEMANAGER_SUCCESS_FILE_EDIT'             => 'File has been successfully saved!',

	'FILEMANAGER_ERROR_NAME_INVALID'            => 'Name cannot contain any of the following characters: \\ / ? % * : | &quot; &lt; &gt;',
	'FILEMANAGER_ERROR_HIDDEN'                  => 'Name cannot start from a dot',
	'FILEMANAGER_ERROR_EXISTS'                  => 'Directory or file with specified name already exists',

	'FILEMANAGER_ERROR_DIR_CREATE'              => 'Error creating directory',
	'FILEMANAGER_ERROR_DIR_RENAME'              => 'Error renaming directory',
	'FILEMANAGER_ERROR_DIR_REMOVE'              => 'Error removing directory',

	'FILEMANAGER_ERROR_FILE_RENAME'             => 'Error renaming file',
	'FILEMANAGER_ERROR_FILE_EDIT'               => 'Error saving file',
	'FILEMANAGER_ERROR_FILE_REMOVE'             => 'Error removing file',

	'FILEMANAGER_CONFIRM_DIR_REMOVE'            => 'Are you sure you want to remove selected directory and all its contents?',
	'FILEMANAGER_CONFIRM_FILE_REMOVE'           => 'Are you sure you want to remove selected file?',

	# Uploader

	'UPLOADER_ERROR_INI_SIZE'                   => 'Uploaded file exceeds the upload_max_filesize directive in php.ini',
	'UPLOADER_ERROR_FORM_SIZE'                  => 'Uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the form',
	'UPLOADER_ERROR_PARTIAL'                    => 'Uploaded file was only partially uploaded',
	'UPLOADER_ERROR_NO_FILE'                    => 'No file was uploaded',
	'UPLOADER_ERROR_NO_TMP_DIR'                 => 'Missing a temporary folder',
	'UPLOADER_ERROR_CANT_WRITE'                 => 'Failed to write file to disk',
	'UPLOADER_ERROR_EXTENSION'                  => 'PHP extension stopped the file upload',

	'UPLOADER_ERROR_SECURITY'                   => 'Possible file upload attack',
	'UPLOADER_ERROR_SIZE'                       => 'Uploaded file size cannot exceed 100 MB',
	'UPLOADER_ERROR_TYPE'                       => 'PHP-files are not allowed for upload',
	'UPLOADER_ERROR_DIR'                        => 'Error creating target directory',
	'UPLOADER_ERROR_EXISTS'                     => 'A file or directory with such name already exists',
	'UPLOADER_ERROR_SAVE'                       => 'Error saving file',
	'UPLOADER_ERROR_UNKNOWN'                    => 'Error uploading file',

	# Add-ons

	'ADDONS_NOT_FOUND'                          => 'Add-ons not found',

	'ADDONS_ERROR_INSTALL'                      => 'Error installing add-on',
	'ADDONS_ERROR_UNINSTALL'                    => 'Error uninstalling add-on',

	'ADDONS_ITEM_CONFIRM_UNINSTALL'             => 'Are you sure you want to uninstall selected add-on?',

	# Languages

	'LANGUAGES_NOT_FOUND'                       => 'Languages not found',

	'LANGUAGES_ERROR_ACTIVATE'                  => 'Error setting default language',
	'LANGUAGES_ERROR_INSTALL'                   => 'Error installing language',
	'LANGUAGES_ERROR_REMOVE'                    => 'Error removing language',
	'LANGUAGES_ERROR_SAVE'                      => 'Error saving settings',

	# Templates

	'TEMPLATES_NOT_FOUND'                       => 'Templates not found',

	'TEMPLATES_ERROR_ACTIVATE'                  => 'Error setting default template',
	'TEMPLATES_ERROR_INSTALL'                   => 'Error installing template',
	'TEMPLATES_ERROR_REMOVE'                    => 'Error removing template',
	'TEMPLATES_ERROR_SAVE'                      => 'Error saving settings',

	# Users

	'USERS_NOT_FOUND'                           => 'Users not found',

	'USERS_COLUMN_NAME'                         => 'User name',
	'USERS_COLUMN_RANK'                         => 'Rank',

	'USERS_ITEM_CREATE'                         => 'Create user',
	'USERS_ITEM_NEW'                            => 'New user',
	'USERS_ITEM_EDIT'                           => 'Edit',
	'USERS_ITEM_REMOVE'                         => 'Remove',

	'USERS_ITEM_INFO_ROW_TIME_REGISTERED'       => 'Date registered',
	'USERS_ITEM_INFO_ROW_TIME_LOGGED'           => 'Date last visited',

	'USERS_ITEM_CONFIRM_REMOVE'                 => 'Are you sure you want to remove selected user?',

	# Settings

	'SETTINGS_TAB_COMMON'                       => 'Common',
	'SETTINGS_TAB_ADMIN'                        => 'Admin panel',

	'SETTINGS_GROUP_SITE'                       => 'Site settings',
	'SETTINGS_GROUP_SYSTEM'                     => 'System settings',

	'SETTINGS_GROUP_MAIN'                       => 'Main settings',
	'SETTINGS_GROUP_APPEARANCE'                 => 'Appearance settings',

	'SETTINGS_FIELD_SITE_TITLE'                 => 'Title',
	'SETTINGS_FIELD_SITE_SLOGAN'                => 'Slogan',
	'SETTINGS_FIELD_SITE_STATUS'                => 'Status',
	'SETTINGS_FIELD_SITE_DESCRIPTION'           => 'Description',
	'SETTINGS_FIELD_SITE_KEYWORDS'              => 'Keywords',

	'SETTINGS_FIELD_SYSTEM_URL'                 => 'Root URL',
	'SETTINGS_FIELD_SYSTEM_EMAIL'               => 'E-mail',
	'SETTINGS_FIELD_SYSTEM_TIMEZONE'            => 'Timezone',

	'SETTINGS_FIELD_ADMIN_LANGUAGE'             => 'Default language',
	'SETTINGS_FIELD_ADMIN_TEMPLATE'             => 'Default template',

	'SETTINGS_FIELD_ADMIN_DISPLAY_ENTITIES'     => 'Items per page',
	'SETTINGS_FIELD_ADMIN_DISPLAY_FILES'        => 'Files per page',

	'SETTINGS_ERROR_SYSTEM_URL'                 => 'Invalid URL format',
	'SETTINGS_ERROR_SYSTEM_EMAIL'               => 'Invalid e-mail format',

	'SETTINGS_ERROR_SAVE'                       => 'Error saving settings',

	'SETTINGS_SUCCESS'                          => 'Settings has been successfully saved!',

	# Information

	'INFORMATION_TAB_COMMON'                    => 'Common',
	'INFORMATION_TAB_PHP'                       => 'PHP configuration',
	'INFORMATION_TAB_DIAGNOSTICS'               => 'Diagnostics',

	'INFORMATION_GROUP_SERVER'                  => 'Server',
	'INFORMATION_GROUP_SYSTEM'                  => 'System',
	'INFORMATION_GROUP_THIRD_PARTY'             => 'Third-party software',

	'INFORMATION_GROUP_ERRORS'                  => 'Errors',
	'INFORMATION_GROUP_FILE_UPLOADS'            => 'File uploads',

	'INFORMATION_GROUP_EXTENSIONS'              => 'PHP extensions',
	'INFORMATION_GROUP_DIRS'                    => 'Directories',

	'INFORMATION_ROW_OS_VERSION'                => 'OS version',
	'INFORMATION_ROW_PHP_VERSION'               => 'PHP version',
	'INFORMATION_ROW_MYSQL_VERSION'             => 'MySQL version',

	'INFORMATION_ROW_SYSTEM_VERSION'            => 'CMS version',
	'INFORMATION_ROW_DEBUG_MODE'                => 'Debug mode',

	'INFORMATION_ROW_JQUERY_VERSION'            => 'jQuery version',
	'INFORMATION_ROW_SEMANTIC_UI_VERSION'       => 'Semantic UI version',
	'INFORMATION_ROW_CKEDITOR_VERSION'          => 'CKEditor version',

	'INFORMATION_ROW_EXTENSION_MYSQLI'          => 'MySQLi',
	'INFORMATION_ROW_EXTENSION_MBSTRING'        => 'Multibyte String',
	'INFORMATION_ROW_EXTENSION_GD'              => 'GD',
	'INFORMATION_ROW_EXTENSION_SIMPLEXML'       => 'SimpleXML',
	'INFORMATION_ROW_EXTENSION_DOM'             => 'DOM',

	'INFORMATION_ROW_DIR_UPLOADS'               => '/uploads',
	'INFORMATION_ROW_DIR_DATA'                  => '/engine/System/Data',

	'INFORMATION_VALUE_DEBUG_MODE_ON'           => 'On',
	'INFORMATION_VALUE_DEBUG_MODE_OFF'          => 'Off',

	'INFORMATION_VALUE_EXTENSION_LOADED'        => 'Loaded',
	'INFORMATION_VALUE_EXTENSION_NOT_LOADED'    => 'Not loaded',

	'INFORMATION_VALUE_DIR_WRITABLE'            => 'Writable',
	'INFORMATION_VALUE_DIR_NOT_WRITABLE'        => 'Not writable'
];
