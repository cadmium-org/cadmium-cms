<?php

/**
 * @package Cadmium\System\Languages\ru-RU
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

return [

	# Titles

	'TITLE_AUTH_LOGIN'                          => 'Вход',
	'TITLE_AUTH_RESET'                          => 'Восстановление пароля',
	'TITLE_AUTH_RECOVER'                        => 'Изменение пароля',
	'TITLE_AUTH_REGISTER'                       => 'Регистрация',

	'TITLE_CONTENT_PAGES'                       => 'Страницы',
	'TITLE_CONTENT_PAGES_CREATE'                => 'Создание страницы',
	'TITLE_CONTENT_PAGES_EDIT'                  => 'Редактирование страницы',

	'TITLE_CONTENT_MENUITEMS'                   => 'Меню',
	'TITLE_CONTENT_MENUITEMS_CREATE'            => 'Создание элемента',
	'TITLE_CONTENT_MENUITEMS_EDIT'              => 'Редактирование элемента',

	'TITLE_CONTENT_VARIABLES'                   => 'Переменные',
	'TITLE_CONTENT_VARIABLES_CREATE'            => 'Создание переменной',
	'TITLE_CONTENT_VARIABLES_EDIT'              => 'Редактирование переменной',

	'TITLE_CONTENT_WIDGETS'                     => 'Виджеты',
	'TITLE_CONTENT_WIDGETS_CREATE'              => 'Создание виджета',
	'TITLE_CONTENT_WIDGETS_EDIT'                => 'Редактирование виджета',

	'TITLE_CONTENT_FILEMANAGER'                 => 'Файлы',
	'TITLE_CONTENT_FILEMANAGER_DIR'             => 'Редактирование директории',
	'TITLE_CONTENT_FILEMANAGER_FILE'            => 'Редактирование файла',

	'TITLE_EXTEND_ADDONS'                       => 'Аддоны',
	'TITLE_EXTEND_LANGUAGES'                    => 'Языки',
	'TITLE_EXTEND_TEMPLATES'                    => 'Шаблоны',

	'TITLE_SYSTEM_USERS'                        => 'Пользователи',
	'TITLE_SYSTEM_USERS_CREATE'                 => 'Создание пользователя',
	'TITLE_SYSTEM_USERS_EDIT'                   => 'Редактирование пользователя',

	'TITLE_SYSTEM_SETTINGS'                     => 'Настройки',
	'TITLE_SYSTEM_INFORMATION'                  => 'Информация',

	'TITLE_DASHBOARD'                           => 'Обзор',
	'TITLE_PROFILE'                             => 'Профиль',

	# Groups

	'GROUP_CONTENT'                             => 'Контент',
	'GROUP_EXTEND'                              => 'Расширения',
	'GROUP_SYSTEM'                              => 'Система',

	# Dashboard

	'DASHBOARD_GROUP_SITE'                      => 'Информация о сайте',
	'DASHBOARD_GROUP_SERVER'                    => 'Сервер',

	'DASHBOARD_ROW_SITE_TITLE'                  => 'Название',
	'DASHBOARD_ROW_SITE_STATUS'                 => 'Статус',

	'DASHBOARD_ROW_SYSTEM_EMAIL'                => 'E-mail',
	'DASHBOARD_ROW_SYSTEM_TIMEZONE'             => 'Часовая зона',

	'DASHBOARD_ROW_OS_VERSION'                  => 'Версия ОС',
	'DASHBOARD_ROW_PHP_VERSION'                 => 'Версия PHP',
	'DASHBOARD_ROW_MYSQL_VERSION'               => 'Версия MySQL',

	'DASHBOARD_LINK_SETTINGS'                   => 'Редактировать настройки',
	'DASHBOARD_LINK_INFORMATION'                => 'Больше информации',

	'DASHBOARD_MESSAGE_INSTALL_REQUIREMENTS'    => 'Некоторые возможности могут быть недоступны из-за неверной конфигурации сервера. Подробнее на ' .
	                                               '<a href="$install_path$/admin/system/information#diagnostics">странице диагностики</a>.',
	'DASHBOARD_MESSAGE_INSTALL_FILE'            => 'Установочный файл <a href="$install_path$/install.php" target="_blank">install.php</a> ' .
	                                               'по-прежнему находится в корневой директории сайта. Рекомендуется удалить его.',
	'DASHBOARD_MESSAGE_SETTINGS_FILE'           => 'Похоже, Вы пока не редактировали настройки сайта. '.
	                                               'Перейдите на <a href="$install_path$/admin/system/settings">страницу настроек</a> для ввода актуальных данных.',

	# Pages

	'PAGES_NOT_FOUND'                           => 'Страницы не найдены',

	'PAGES_COLUMN_TITLE'                        => 'Заголовок',
	'PAGES_COLUMN_ACCESS'                       => 'Доступ',

	'PAGES_ITEM_LIST'                           => 'Список страниц',
	'PAGES_ITEM_CREATE'                         => 'Создать страницу',
	'PAGES_ITEM_CREATE_SUB'                     => 'Создать подстраницу',
	'PAGES_ITEM_EDIT'                           => 'Редактировать',
	'PAGES_ITEM_BROWSE'                         => 'Просмотреть',
	'PAGES_ITEM_REMOVE'                         => 'Удалить',
	'PAGES_ITEM_SELECT'                         => 'Выбрать',

	'PAGES_ITEM_CONFIRM_REMOVE'                 => 'Вы действительно хотите удалить выбранную страницу?',

	# Menuitems

	'MENUITEMS_NOT_FOUND'                       => 'Элементы не найдены',

	'MENUITEMS_COLUMN_TEXT'                     => 'Текст',
	'MENUITEMS_COLUMN_POSITION'                 => 'Позиция',

	'MENUITEMS_ITEM_LIST'                       => 'Список элементов',
	'MENUITEMS_ITEM_CREATE'                     => 'Создать элемент',
	'MENUITEMS_ITEM_CREATE_SUB'                 => 'Создать подэлемент',
	'MENUITEMS_ITEM_EDIT'                       => 'Редактировать',
	'MENUITEMS_ITEM_BROWSE'                     => 'Перейти',
	'MENUITEMS_ITEM_REMOVE'                     => 'Удалить',
	'MENUITEMS_ITEM_SELECT'                     => 'Выбрать',

	'MENUITEMS_ITEM_CONFIRM_REMOVE'             => 'Вы действительно хотите удалить выбранный элемент?',

	# Variables

	'VARIABLES_NOT_FOUND'                       => 'Переменные не найдены',

	'VARIABLES_COLUMN_TITLE'                    => 'Название',
	'VARIABLES_COLUMN_VALUE'                    => 'Значение',

	'VARIABLES_ITEM_CREATE'                     => 'Создать переменную',
	'VARIABLES_ITEM_NEW'                        => 'Новая переменная',
	'VARIABLES_ITEM_EDIT'                       => 'Редактировать',
	'VARIABLES_ITEM_INFO'                       => 'Информация',
	'VARIABLES_ITEM_REMOVE'                     => 'Удалить',

	'VARIABLES_ITEM_CONFIRM_REMOVE'             => 'Вы действительно хотите удалить выбранную переменную?',
	'VARIABLES_ITEM_INFO_TEXT'                  => 'Используйте следующий код для вставки переменной на страницу, в шаблон или виджет:',

	# Widgets

	'WIDGETS_NOT_FOUND'                         => 'Виджеты не найдены',

	'WIDGETS_COLUMN_TITLE'                      => 'Название',

	'WIDGETS_ITEM_CREATE'                       => 'Создать виджет',
	'WIDGETS_ITEM_NEW'                          => 'Новый виджет',
	'WIDGETS_ITEM_EDIT'                         => 'Редактировать',
	'WIDGETS_ITEM_INFO'                         => 'Информация',
	'WIDGETS_ITEM_REMOVE'                       => 'Удалить',

	'WIDGETS_ITEM_CONFIRM_REMOVE'               => 'Вы действительно хотите удалить выбранный виджет?',
	'WIDGETS_ITEM_INFO_TEXT'                    => 'Используйте следующий код для вставки виджета на страницу или в шаблон:',

	# Filemanager

	'FILEMANAGER_UPLOAD_SELECT'                 => 'Выбрать файл...',

	'FILEMANAGER_DIR'                           => 'Директория',

	'FILEMANAGER_DIR_NAME'                      => 'Название директории',
	'FILEMANAGER_DIR_INFO'                      => 'Информация о директории',

	'FILEMANAGER_DIR_ROW_TIME_CREATED'          => 'Время создания',
	'FILEMANAGER_DIR_ROW_TIME_MODIFIED'         => 'Время изменения',
	'FILEMANAGER_DIR_ROW_PERMISSIONS'           => 'Права доступа',

	'FILEMANAGER_FILE'                          => 'Файл',

	'FILEMANAGER_FILE_NAME'                     => 'Название файла',
	'FILEMANAGER_FILE_INFO'                     => 'Информация о файле',

	'FILEMANAGER_FILE_ROW_TIME_CREATED'         => 'Время создания',
	'FILEMANAGER_FILE_ROW_TIME_MODIFIED'        => 'Время изменения',
	'FILEMANAGER_FILE_ROW_PERMISSIONS'          => 'Права доступа',
	'FILEMANAGER_FILE_ROW_SIZE'                 => 'Размер',
	'FILEMANAGER_FILE_ROW_MIME'                 => 'MIME-тип',

	'FILEMANAGER_ITEMS_NOT_FOUND'               => 'Директория пуста',

	'FILEMANAGER_ACTION_CREATE'                 => 'Создать...',
	'FILEMANAGER_ACTION_RELOAD'                 => 'Обновить',

	'FILEMANAGER_COLUMN_NAME'                   => 'Название файла',
	'FILEMANAGER_COLUMN_SIZE'                   => 'Размер',

	'FILEMANAGER_ITEM_EDIT'                     => 'Редактировать',
	'FILEMANAGER_ITEM_REMOVE'                   => 'Удалить',

	'FILEMANAGER_ITEM_CONFIRM_REMOVE'           => 'Вы действительно хотите удалить выбранный элемент?',

	'FILEMANAGER_FIELD_NAME'                    => 'Введите название...',

	'FILEMANAGER_SUCCESS_DIR_RENAME'            => 'Директория была успешно переименована!',
	'FILEMANAGER_SUCCESS_FILE_RENAME'           => 'Файл был успешно переименован!',

	'FILEMANAGER_ERROR_NAME_INVALID'            => 'Название не может содержать следующих символов: \\ / ? % * : | &quot; &lt; &gt;',
	'FILEMANAGER_ERROR_EXISTS'                  => 'Директория или файл с указанным названием уже существует',

	'FILEMANAGER_ERROR_DIR_CREATE'              => 'Ошибка создания директории',
	'FILEMANAGER_ERROR_FILE_CREATE'             => 'Ошибка создания файла',

	'FILEMANAGER_ERROR_DIR_RENAME'              => 'Ошибка переименования директории',
	'FILEMANAGER_ERROR_FILE_RENAME'             => 'Ошибка переименования файла',

	'FILEMANAGER_ERROR_DIR_REMOVE'              => 'Ошибка удаления директории',
	'FILEMANAGER_ERROR_FILE_REMOVE'             => 'Ошибка удаления файла',

	'FILEMANAGER_CONFIRM_DIR_REMOVE'            => 'Вы действительно хотите удалить выбранную директорию и все ее содержимое?',
	'FILEMANAGER_CONFIRM_FILE_REMOVE'           => 'Вы действительно хотите удалить выбранный файл?',

	# Uploader

	'UPLOADER_ERROR_INI_SIZE'                   => 'Размер загруженного файла превысил значение upload_max_filesize в php.ini',
	'UPLOADER_ERROR_FORM_SIZE'                  => 'Размер загруженного файла превысил значение MAX_FILE_SIZE, указанное в форме',
	'UPLOADER_ERROR_PARTIAL'                    => 'Загружаемый файл был получен только частично',
	'UPLOADER_ERROR_NO_FILE'                    => 'Файл не был загружен',
	'UPLOADER_ERROR_NO_TMP_DIR'                 => 'Отсутствует временная директория',
	'UPLOADER_ERROR_CANT_WRITE'                 => 'Не удалось записать файл на диск',
	'UPLOADER_ERROR_EXTENSION'                  => 'PHP-расширение остановило загрузку файла',

	'UPLOADER_ERROR_SECURITY'                   => 'Возможная атака с участием загрузки файла',
	'UPLOADER_ERROR_SIZE'                       => 'Размер загруженного файла не должен превышать 100 MB',
	'UPLOADER_ERROR_TYPE'                       => 'PHP-файлы не разрешены для загрузки',
	'UPLOADER_ERROR_DIR'                        => 'Ошибка создания целевой директории',
	'UPLOADER_ERROR_EXISTS'                     => 'Файл или директория с таким именем уже существует',
	'UPLOADER_ERROR_SAVE'                       => 'Ошибка сохранения файла',
	'UPLOADER_ERROR_UNKNOWN'                    => 'Ошибка загрузки файла',

	# Add-ons

	'ADDONS_NOT_FOUND'                          => 'Аддоны не найдены',

	'ADDONS_ERROR_INSTALL'                      => 'Ошибка инсталляции аддона',
	'ADDONS_ERROR_UNINSTALL'                    => 'Ошибка деинсталляции аддона',

	'ADDONS_ITEM_CONFIRM_UNINSTALL'             => 'Вы действительно хотите деинсталлировать выбранный аддон?',

	# Languages

	'LANGUAGES_NOT_FOUND'                       => 'Языки не найдены',

	'LANGUAGES_ERROR_ACTIVATE'                  => 'Ошибка установки языка по умолчанию',
	'LANGUAGES_ERROR_INSTALL'                   => 'Ошибка инсталляции языка',
	'LANGUAGES_ERROR_REMOVE'                    => 'Ошибка удаления языка',
	'LANGUAGES_ERROR_SAVE'                      => 'Ошибка сохранения настроек',

	# Templates

	'TEMPLATES_NOT_FOUND'                       => 'Шаблоны не найдены',

	'TEMPLATES_ERROR_ACTIVATE'                  => 'Ошибка установки шаблона по умолчанию',
	'TEMPLATES_ERROR_INSTALL'                   => 'Ошибка инсталляции шаблона',
	'TEMPLATES_ERROR_REMOVE'                    => 'Ошибка удаления шаблона',
	'TEMPLATES_ERROR_SAVE'                      => 'Ошибка сохранения настроек',

	# Users

	'USERS_NOT_FOUND'                           => 'Пользователи не найдены',

	'USERS_COLUMN_NAME'                         => 'Имя пользователя',
	'USERS_COLUMN_RANK'                         => 'Уровень доступа',

	'USERS_ITEM_CREATE'                         => 'Создать пользователя',
	'USERS_ITEM_NEW'                            => 'Новый пользователь',
	'USERS_ITEM_EDIT'                           => 'Редактировать',
	'USERS_ITEM_REMOVE'                         => 'Удалить',

	'USERS_ITEM_INFO_ROW_TIME_REGISTERED'       => 'Дата регистрации',
	'USERS_ITEM_INFO_ROW_TIME_LOGGED'           => 'Дата последнего посещения',

	'USERS_ITEM_CONFIRM_REMOVE'                 => 'Вы действительно хотите удалить выбранного пользователя?',

	# Settings

	'SETTINGS_TAB_COMMON'                       => 'Общие',

	'SETTINGS_GROUP_SITE'                       => 'Настройки сайта',
	'SETTINGS_GROUP_SYSTEM'                     => 'Настройки системы',
	'SETTINGS_GROUP_ADMIN'                      => 'Настройки панели управления',

	'SETTINGS_FIELD_SITE_TITLE'                 => 'Название',
	'SETTINGS_FIELD_SITE_SLOGAN'                => 'Слоган',
	'SETTINGS_FIELD_SITE_STATUS'                => 'Статус',
	'SETTINGS_FIELD_SITE_DESCRIPTION'           => 'Описание',
	'SETTINGS_FIELD_SITE_KEYWORDS'              => 'Ключевые слова',

	'SETTINGS_FIELD_SYSTEM_URL'                 => 'Корневой URL',
	'SETTINGS_FIELD_SYSTEM_EMAIL'               => 'E-mail',
	'SETTINGS_FIELD_SYSTEM_TIMEZONE'            => 'Часовая зона',

	'SETTINGS_FIELD_ADMIN_LANGUAGE'             => 'Язык по умолчанию',
	'SETTINGS_FIELD_ADMIN_TEMPLATE'             => 'Шаблон по умолчанию',
	'SETTINGS_FIELD_ADMIN_AJAX_NAVIGATION'      => 'Ajax-навигация',

	'SETTINGS_ERROR_SYSTEM_URL'                 => 'Неверный формат URL',
	'SETTINGS_ERROR_SYSTEM_EMAIL'               => 'Неверный формат e-mail',

	'SETTINGS_ERROR_SAVE'                       => 'Ошибка сохранения настроек',

	'SETTINGS_SUCCESS'                          => 'Настройки были успешно сохранены!',

	# Information

	'INFORMATION_TAB_COMMON'                    => 'Общее',
	'INFORMATION_TAB_PHP'                       => 'Конфигурация PHP',
	'INFORMATION_TAB_DIAGNOSTICS'               => 'Диагностика',

	'INFORMATION_GROUP_SERVER'                  => 'Сервер',
	'INFORMATION_GROUP_SYSTEM'                  => 'Система',
	'INFORMATION_GROUP_THIRD_PARTY'             => 'Стороннее ПО',

	'INFORMATION_GROUP_ERRORS'                  => 'Ошибки',
	'INFORMATION_GROUP_FILE_UPLOADS'            => 'Загрузка файлов',

	'INFORMATION_GROUP_EXTENSIONS'              => 'Расширения PHP',
	'INFORMATION_GROUP_DIRS'                    => 'Директории',

	'INFORMATION_ROW_OS_VERSION'                => 'Версия ОС',
	'INFORMATION_ROW_PHP_VERSION'               => 'Версия PHP',
	'INFORMATION_ROW_MYSQL_VERSION'             => 'Версия MySQL',

	'INFORMATION_ROW_SYSTEM_VERSION'            => 'Версия CMS',
	'INFORMATION_ROW_DEBUG_MODE'                => 'Режим отладки',

	'INFORMATION_ROW_JQUERY_VERSION'            => 'Версия jQuery',
	'INFORMATION_ROW_SEMANTIC_UI_VERSION'       => 'Версия Semantic UI',
	'INFORMATION_ROW_CKEDITOR_VERSION'          => 'Версия CKEditor',

	'INFORMATION_ROW_EXTENSION_MYSQLI'          => 'MySQLi',
	'INFORMATION_ROW_EXTENSION_MBSTRING'        => 'Multibyte String',
	'INFORMATION_ROW_EXTENSION_GD'              => 'GD',
	'INFORMATION_ROW_EXTENSION_SIMPLEXML'       => 'SimpleXML',
	'INFORMATION_ROW_EXTENSION_DOM'             => 'DOM',

	'INFORMATION_ROW_DIR_UPLOADS'               => '/uploads',
	'INFORMATION_ROW_DIR_DATA'                  => '/engine/System/Data',

	'INFORMATION_VALUE_DEBUG_MODE_ON'           => 'Включен',
	'INFORMATION_VALUE_DEBUG_MODE_OFF'          => 'Выключен',

	'INFORMATION_VALUE_EXTENSION_LOADED'        => 'Подключено',
	'INFORMATION_VALUE_EXTENSION_NOT_LOADED'    => 'Отключено',

	'INFORMATION_VALUE_DIR_WRITABLE'            => 'Доступна для записи',
	'INFORMATION_VALUE_DIR_NOT_WRITABLE'        => 'Недоступна для записи'
];
