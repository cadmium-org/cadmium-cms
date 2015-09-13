<?php

return array (

	# Titles

	'TITLE_INSTALL_CHECK'                       => 'Шаг 1. Проверка требований',
	'TITLE_INSTALL_DATABASE'                    => 'Шаг 2. Настройки MySQL',

	# Requirements

	'INSTALL_PHP_VERSION'                       => 'Версия PHP',

	'INSTALL_REQUIREMENT_MYSQLI_SUCCESS'        => 'Расширение MySQLi установлено.',
	'INSTALL_REQUIREMENT_MYSQLI_FAIL'           => 'Расширение MySQLi не установлено.',

	'INSTALL_REQUIREMENT_MBSTRING_SUCCESS'      => 'Расширение Multibyte String установлено.',
	'INSTALL_REQUIREMENT_MBSTRING_FAIL'         => 'Расширение Multibyte String не установлено.',

	'INSTALL_REQUIREMENT_GD_SUCCESS'            => 'Расширение GD установлено.',
	'INSTALL_REQUIREMENT_GD_FAIL'               => 'Расширение GD не установлено.',

	'INSTALL_REQUIREMENT_SIMPLEXML_SUCCESS'     => 'Расширение SimpleXML установлено.',
	'INSTALL_REQUIREMENT_SIMPLEXML_FAIL'        => 'Расширение SimpleXML не установлено.',

	'INSTALL_REQUIREMENT_REWRITE_SUCCESS'       => 'Модуль Rewrite включен.',
	'INSTALL_REQUIREMENT_REWRITE_FAIL'          => 'Модуль Rewrite не включен.',

	'INSTALL_REQUIREMENT_DATA_SUCCESS'          => 'Engine/System/Data доступна для записи.',
	'INSTALL_REQUIREMENT_DATA_FAIL'             => 'Engine/System/Data не доступна для записи.',

	'INSTALL_REQUIREMENT_UPLOADS_SUCCESS'       => 'Директория Uploads доступна для записи.',
	'INSTALL_REQUIREMENT_UPLOADS_FAIL'          => 'Директория Uploads не доступна для записи.',

	# Errors

	'INSTALL_ERROR_DATABASE_CONNECT'            => 'Невозможно подключиться к базе данных',
	'INSTALL_ERROR_DATABASE_SELECT'             => 'Невозможно выбрать базу данных',
	'INSTALL_ERROR_DATABASE_CHARSET'            => 'Невозможно установить кодировку базы данных',

	'INSTALL_ERROR_DATABASE_TABLES_CREATE'      => 'Ошибка создания таблиц базы данных',
	'INSTALL_ERROR_DATABASE_TABLES_FILL'        => 'Ошибка сохранения начальных данных',

	'INSTALL_ERROR_SYSTEM'                      => 'Ошибка сохранения основного файла конфигурации',

	# Fields

	'INSTALL_FIELD_LANGUAGE'                    => 'Язык',
	'INSTALL_FIELD_TEMPLATE'                    => 'Шаблон',

	'INSTALL_FIELD_DATABASE_SERVER'             => 'Сервер',
	'INSTALL_FIELD_DATABASE_USER'               => 'Имя пользователя',
	'INSTALL_FIELD_DATABASE_PASSWORD'           => 'Пароль',
	'INSTALL_FIELD_DATABASE_NAME'               => 'Название базы данных',

	# Pages

	'INSTALL_PAGE_INDEX_TITLE'                  => 'Home',

	'INSTALL_PAGE_INDEX_CONTENTS'               => '<p>Добро пожаловать! Это демонстрационный сайт, работающий на <strong>Cadmium CMS</strong>.</p>' .
	                                               '<p>Вы можете войти в панель управления, перейдя по <a href="/admin">этой ссылке</a>.</p>' .
	                                               '<p><a href="http://cadmium-cms.com" target="_blank">Официальный сайт Cadmium CMS</a></p>' .
	                                               '<p><a href="http://cadmium-cms.com/documentation" target="_blank">Официальная документация</a></p>',

	'INSTALL_PAGE_DEMO_TITLE'                   => 'Страница',
	'INSTALL_PAGE_DEMO_CONTENTS'                => '<p>Это демонстрационная страница.</p>'
);
