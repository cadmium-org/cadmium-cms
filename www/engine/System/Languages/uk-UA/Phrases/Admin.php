<?php

/**
 * @package Cadmium\System\Languages\uk-UA
 * @author Dariia Romanova
 * @copyright Copyright (c) 2015-2017, Dariia Romanova
 * @link http://cadmium-cms.com
 */

return [

	# Titles

	'TITLE_INSTALL_CHECK'                       => 'Крок 1. Перевірка вимог',
	'TITLE_INSTALL_DATABASE'                    => 'Крок 2. Налаштування MySQL',

	'TITLE_AUTH_LOGIN'                          => 'Вхід',
	'TITLE_AUTH_RESET'                          => 'Відновлення пароля',
	'TITLE_AUTH_RECOVER'                        => 'Змінення пароля',
	'TITLE_AUTH_REGISTER'                       => 'Реєстрація',

	'TITLE_CONTENT_PAGES'                       => 'Сторінки',
	'TITLE_CONTENT_PAGES_CREATE'                => 'Створення сторінки',
	'TITLE_CONTENT_PAGES_EDIT'                  => 'Редагування сторінки',

	'TITLE_CONTENT_MENUITEMS'                   => 'Меню',
	'TITLE_CONTENT_MENUITEMS_CREATE'            => 'Створення елемента',
	'TITLE_CONTENT_MENUITEMS_EDIT'              => 'Редагування елемента',

	'TITLE_CONTENT_VARIABLES'                   => 'Змінні',
	'TITLE_CONTENT_VARIABLES_CREATE'            => 'Створення змінної',
	'TITLE_CONTENT_VARIABLES_EDIT'              => 'Редагування змінної',

	'TITLE_CONTENT_WIDGETS'                     => 'Віджети',
	'TITLE_CONTENT_WIDGETS_CREATE'              => 'Створення віджета',
	'TITLE_CONTENT_WIDGETS_EDIT'                => 'Редагування віджета',

	'TITLE_CONTENT_FILEMANAGER'                 => 'Файли',
	'TITLE_CONTENT_FILEMANAGER_DIR'             => 'Редагування директорії',
	'TITLE_CONTENT_FILEMANAGER_FILE'            => 'Редагування файла',

	'TITLE_EXTEND_ADDONS'                       => 'Аддони',
	'TITLE_EXTEND_LANGUAGES'                    => 'Мови',
	'TITLE_EXTEND_TEMPLATES'                    => 'Шаблони',

	'TITLE_SYSTEM_USERS'                        => 'Користувачі',
	'TITLE_SYSTEM_USERS_CREATE'                 => 'Створення користувача',
	'TITLE_SYSTEM_USERS_EDIT'                   => 'Редагування користувача',

	'TITLE_SYSTEM_SETTINGS'                     => 'Налаштування',
	'TITLE_SYSTEM_INFORMATION'                  => 'Інформація',

	'TITLE_DASHBOARD'                           => 'Огляд',
	'TITLE_PROFILE'                             => 'Профіль',

	# Groups

	'GROUP_CONTENT'                             => 'Контент',
	'GROUP_EXTEND'                              => 'Розширення',
	'GROUP_SYSTEM'                              => 'Система',

	# Dashboard

	'DASHBOARD_GROUP_SITE'                      => 'Інформація про сайт',
	'DASHBOARD_GROUP_SERVER'                    => 'Сервер',

	'DASHBOARD_ROW_SITE_TITLE'                  => 'Назва',
	'DASHBOARD_ROW_SITE_STATUS'                 => 'Статус',

	'DASHBOARD_ROW_SYSTEM_EMAIL'                => 'E-mail',
	'DASHBOARD_ROW_SYSTEM_TIMEZONE'             => 'Часова зона',

	'DASHBOARD_ROW_OS_VERSION'                  => 'Версія ОС',
	'DASHBOARD_ROW_PHP_VERSION'                 => 'Версія PHP',
	'DASHBOARD_ROW_MYSQL_VERSION'               => 'Версія MySQL',

	'DASHBOARD_LINK_SETTINGS'                   => 'Редагувати налаштування',
	'DASHBOARD_LINK_INFORMATION'                => 'Більше інформації',

	'DASHBOARD_MESSAGE_INSTALL_REQUIREMENTS'    => 'Деякі можливості можуть бути недоступні через невірну конфігурацію сервера. Детальніше на ' .
	                                               '<a href="$install_path$/admin/system/information#diagnostics">сторінці діагностики</a>.',
	'DASHBOARD_MESSAGE_INSTALL_FILE'            => 'Інсталяційний файл <b>install.php</b> досі знаходиться в кореневій директорії сайта. '.
	                                               'Рекомендовано видалити його.',
	'DASHBOARD_MESSAGE_SETTINGS_FILE'           => 'Схоже, Ви поки не редагували налаштування сайта. '.
	                                               'Перейдіть на <a href="$install_path$/admin/system/settings">сторінку налаштувань</a> для введення актуальних даних.',

	# Pages

	'PAGES_NOT_FOUND'                           => 'Сторінки не знайдені',

	'PAGES_COLUMN_TITLE'                        => 'Заголовок',
	'PAGES_COLUMN_ACCESS'                       => 'Доступ',

	'PAGES_ITEM_LIST'                           => 'Список сторінок',
	'PAGES_ITEM_CREATE'                         => 'Створити сторінку',
	'PAGES_ITEM_CREATE_SUB'                     => 'Створити підсторінку',
	'PAGES_ITEM_EDIT'                           => 'Редагувати',
	'PAGES_ITEM_BROWSE'                         => 'Переглянути',
	'PAGES_ITEM_REMOVE'                         => 'Видалити',
	'PAGES_ITEM_SELECT'                         => 'Обрати',

	'PAGES_ITEM_CONFIRM_REMOVE'                 => 'Ви дійсно бажаєте видалити обрану сторінку?',

	# Menuitems

	'MENUITEMS_NOT_FOUND'                       => 'Елементи не знайдені',

	'MENUITEMS_COLUMN_TEXT'                     => 'Текст',
	'MENUITEMS_COLUMN_POSITION'                 => 'Позиція',

	'MENUITEMS_ITEM_LIST'                       => 'Список елементів',
	'MENUITEMS_ITEM_CREATE'                     => 'Створити елемент',
	'MENUITEMS_ITEM_CREATE_SUB'                 => 'Створити піделемент',
	'MENUITEMS_ITEM_EDIT'                       => 'Редагувати',
	'MENUITEMS_ITEM_BROWSE'                     => 'Перейти',
	'MENUITEMS_ITEM_REMOVE'                     => 'Видалити',
	'MENUITEMS_ITEM_SELECT'                     => 'Обрати',

	'MENUITEMS_ITEM_CONFIRM_REMOVE'             => 'Ви дійсно бажаєте видалити обраний елемент?',

	# Variables

	'VARIABLES_NOT_FOUND'                       => 'Змінні не знайдені',

	'VARIABLES_COLUMN_TITLE'                    => 'Назва',
	'VARIABLES_COLUMN_VALUE'                    => 'Значення',

	'VARIABLES_ITEM_CREATE'                     => 'Створити змінну',
	'VARIABLES_ITEM_NEW'                        => 'Нова змінна',
	'VARIABLES_ITEM_EDIT'                       => 'Редагувати',
	'VARIABLES_ITEM_REMOVE'                     => 'Видалити',

	'VARIABLES_ITEM_CONFIRM_REMOVE'             => 'Ви дійсно бажаєте видалити обрану змінну?',

	# Widgets

	'WIDGETS_NOT_FOUND'                         => 'Віджети не знайдені',

	'WIDGETS_COLUMN_TITLE'                      => 'Назва',

	'WIDGETS_ITEM_CREATE'                       => 'Створити віджет',
	'WIDGETS_ITEM_NEW'                          => 'Новий віджет',
	'WIDGETS_ITEM_EDIT'                         => 'Редагувати',
	'WIDGETS_ITEM_REMOVE'                       => 'Видалити',

	'WIDGETS_ITEM_CONFIRM_REMOVE'               => 'Ви дійсно бажаєте видалити обраний віджет?',

	# Filemanager

	'FILEMANAGER_ORIGIN_ADDONS'                 => 'Аддони',
	'FILEMANAGER_ORIGIN_LANGUAGES'              => 'Мови',
	'FILEMANAGER_ORIGIN_TEMPLATES'              => 'Шаблони',
	'FILEMANAGER_ORIGIN_UPLOADS'                => 'Завантаження',

	'FILEMANAGER_UPLOAD_SELECT'                 => 'Обрати файл...',

	'FILEMANAGER_LABEL_CREATE'                  => 'Нова директорія',

	'FILEMANAGER_ACTION_CREATE'                 => 'Створити',
	'FILEMANAGER_ACTION_RELOAD'                 => 'Оновити',

	'FILEMANAGER_DIR_NAME'                      => 'Назва директорії',
	'FILEMANAGER_DIR_INFO'                      => 'Відомості про директорію',

	'FILEMANAGER_DIR_ROW_TIME_CREATED'          => 'Час створення',
	'FILEMANAGER_DIR_ROW_TIME_MODIFIED'         => 'Час змінення',
	'FILEMANAGER_DIR_ROW_PERMISSIONS'           => 'Права доступу',

	'FILEMANAGER_FILE_NAME'                     => 'Назва файла',
	'FILEMANAGER_FILE_INFO'                     => 'Відомості про файл',

	'FILEMANAGER_FILE_ROW_SIZE'                 => 'Розмір',
	'FILEMANAGER_FILE_ROW_MIME'                 => 'MIME-тип',
	'FILEMANAGER_FILE_ROW_TIME_CREATED'         => 'Час створення',
	'FILEMANAGER_FILE_ROW_TIME_MODIFIED'        => 'Час змінення',
	'FILEMANAGER_FILE_ROW_PERMISSIONS'          => 'Права доступу',

	'FILEMANAGER_ITEMS_NOT_FOUND'               => 'Директорія пуста',

	'FILEMANAGER_COLUMN_NAME'                   => 'Назва файла',
	'FILEMANAGER_COLUMN_SIZE'                   => 'Розмір',

	'FILEMANAGER_ITEM_EDIT'                     => 'Редагувати',
	'FILEMANAGER_ITEM_REMOVE'                   => 'Видалити',

	'FILEMANAGER_ITEM_INSERT_AS_MEDIA'          => 'Вставити як медіа',
	'FILEMANAGER_ITEM_INSERT_AS_LINK'           => 'Вставити як посилання',

	'FILEMANAGER_FIELD_NAME'                    => 'Введіть назву...',

	'FILEMANAGER_SUCCESS_UPLOAD'                => 'Файл був успішно завантажений!',

	'FILEMANAGER_SUCCESS_DIR_CREATE'            => 'Директорія була успішно створена!',
	'FILEMANAGER_SUCCESS_DIR_RENAME'            => 'Директорія була успішно перейменована!',

	'FILEMANAGER_SUCCESS_FILE_RENAME'           => 'Файл був успішно перейменований!',
	'FILEMANAGER_SUCCESS_FILE_EDIT'             => 'Файл був успішно збережений!',

	'FILEMANAGER_ERROR_NAME_INVALID'            => 'Назва не може містити наступні символи: \\ / ? % * : | &quot; &lt; &gt;',
	'FILEMANAGER_ERROR_HIDDEN'                  => 'Назва не може починатися з крапки',
	'FILEMANAGER_ERROR_EXISTS'                  => 'Директорія або файл з вказаною назвою вже існує',

	'FILEMANAGER_ERROR_DIR_CREATE'              => 'Помилка створення директорії',
	'FILEMANAGER_ERROR_DIR_RENAME'              => 'Помилка перейменування директорії',
	'FILEMANAGER_ERROR_DIR_REMOVE'              => 'Помилка видалення директорії',

	'FILEMANAGER_ERROR_FILE_RENAME'             => 'Помилка перейменування файла',
	'FILEMANAGER_ERROR_FILE_EDIT'               => 'Помилка збереження файла',
	'FILEMANAGER_ERROR_FILE_REMOVE'             => 'Помилка видалення файла',

	'FILEMANAGER_CONFIRM_DIR_REMOVE'            => 'Ви дійсно бажаєте видалити обрану директорію і весь її вміст?',
	'FILEMANAGER_CONFIRM_FILE_REMOVE'           => 'Ви дійсно бажаєте видалити обраний файл?',

	# Uploader

	'UPLOADER_ERROR_INI_SIZE'                   => 'Розмір завантаженого файла перевищив значення upload_max_filesize в php.ini',
	'UPLOADER_ERROR_FORM_SIZE'                  => 'Розмір завантаженого файла перевищив значення MAX_FILE_SIZE, вказане у формі',
	'UPLOADER_ERROR_PARTIAL'                    => 'Завантажений файл був отриманий лише частково',
	'UPLOADER_ERROR_NO_FILE'                    => 'Файл не був завантажений',
	'UPLOADER_ERROR_NO_TMP_DIR'                 => 'Вістутня тимчасова директорія',
	'UPLOADER_ERROR_CANT_WRITE'                 => 'Не вдалося записати файл на диск',
	'UPLOADER_ERROR_EXTENSION'                  => 'PHP-розширення зупинило завантаження файла',

	'UPLOADER_ERROR_SECURITY'                   => 'Можлива атака за участю завантаження файла',
	'UPLOADER_ERROR_SIZE'                       => 'Розмір завантаженого файла не повинен перевищувати 100 MB',
	'UPLOADER_ERROR_TYPE'                       => 'PHP-файли не дозволені для завантаження',
	'UPLOADER_ERROR_DIR'                        => 'Помилка створення цільової директорії',
	'UPLOADER_ERROR_EXISTS'                     => 'Файл або директорія з таким іменем вже існує',
	'UPLOADER_ERROR_SAVE'                       => 'Помилка збереження файла',
	'UPLOADER_ERROR_UNKNOWN'                    => 'Помилка завантаження файла',

	# Add-ons

	'ADDONS_NOT_FOUND'                          => 'Аддони не знайдені',

	'ADDONS_ERROR_INSTALL'                      => 'Помилка інсталяції аддона',
	'ADDONS_ERROR_UNINSTALL'                    => 'Помилка деінсталяції аддона',

	'ADDONS_ITEM_CONFIRM_UNINSTALL'             => 'Ви дійсно бажаєте деінсталювати обраний аддон?',

	# Languages

	'LANGUAGES_NOT_FOUND'                       => 'Мови не знайдені',

	'LANGUAGES_ERROR_ACTIVATE'                  => 'Помилка встановлення мови за промовчанням',
	'LANGUAGES_ERROR_INSTALL'                   => 'Помилка інсталяції мови',
	'LANGUAGES_ERROR_REMOVE'                    => 'Помилка видалення мови',
	'LANGUAGES_ERROR_SAVE'                      => 'Помилка збереження налаштувань',

	# Templates

	'TEMPLATES_NOT_FOUND'                       => 'Шаблони не знайдені',

	'TEMPLATES_ERROR_ACTIVATE'                  => 'Помилка встановлення шаблона за промовчанням',
	'TEMPLATES_ERROR_INSTALL'                   => 'Помилка інсталяції шаблона',
	'TEMPLATES_ERROR_REMOVE'                    => 'Помилка видалення шаблона',
	'TEMPLATES_ERROR_SAVE'                      => 'Помилка збереження налаштувань',

	# Users

	'USERS_NOT_FOUND'                           => 'Користувачі не знайдені',

	'USERS_COLUMN_NAME'                         => 'Ім\'я користувача',
	'USERS_COLUMN_RANK'                         => 'Рівень доступу',

	'USERS_ITEM_CREATE'                         => 'Створити користувача',
	'USERS_ITEM_NEW'                            => 'Новий користувач',
	'USERS_ITEM_EDIT'                           => 'Редагувати',
	'USERS_ITEM_REMOVE'                         => 'Видалити',

	'USERS_ITEM_INFO_ROW_TIME_REGISTERED'       => 'Дата реєстрації',
	'USERS_ITEM_INFO_ROW_TIME_LOGGED'           => 'Дата останнього відвідування',

	'USERS_ITEM_CONFIRM_REMOVE'                 => 'Ви дійсно бажаєте видалити обраного користувача?',

	# Settings

	'SETTINGS_TAB_COMMON'                       => 'Загальні',
	'SETTINGS_TAB_ADMIN'                        => 'Панель керування',

	'SETTINGS_GROUP_SITE'                       => 'Налаштування сайта',
	'SETTINGS_GROUP_SYSTEM'                     => 'Налаштування системи',

	'SETTINGS_GROUP_MAIN'                       => 'Основні налаштування',
	'SETTINGS_GROUP_APPEARANCE'                 => 'Налаштування відображення',

	'SETTINGS_FIELD_SITE_TITLE'                 => 'Назва',
	'SETTINGS_FIELD_SITE_SLOGAN'                => 'Слоган',
	'SETTINGS_FIELD_SITE_STATUS'                => 'Статус',
	'SETTINGS_FIELD_SITE_DESCRIPTION'           => 'Опис',
	'SETTINGS_FIELD_SITE_KEYWORDS'              => 'Ключові слова',

	'SETTINGS_FIELD_SYSTEM_URL'                 => 'Кореневий URL',
	'SETTINGS_FIELD_SYSTEM_EMAIL'               => 'E-mail',
	'SETTINGS_FIELD_SYSTEM_TIMEZONE'            => 'Часова зона',

	'SETTINGS_FIELD_ADMIN_LANGUAGE'             => 'Мова за замовчуванням',
	'SETTINGS_FIELD_ADMIN_TEMPLATE'             => 'Шаблон за замовчуванням',

	'SETTINGS_FIELD_ADMIN_DISPLAY_ENTITIES'     => 'Елементів на сторінці',
	'SETTINGS_FIELD_ADMIN_DISPLAY_FILES'        => 'Файлів на сторінці',

	'SETTINGS_ERROR_SYSTEM_URL'                 => 'Невірний формат URL',
	'SETTINGS_ERROR_SYSTEM_EMAIL'               => 'Невірний формат e-mail',

	'SETTINGS_ERROR_SAVE'                       => 'Помилка збереження налаштувань',

	'SETTINGS_SUCCESS'                          => 'Налаштування були успішно збережені!',

	# Information

	'INFORMATION_TAB_COMMON'                    => 'Загальне',
	'INFORMATION_TAB_PHP'                       => 'Конфігурація PHP',
	'INFORMATION_TAB_DIAGNOSTICS'               => 'Діагностика',

	'INFORMATION_GROUP_SERVER'                  => 'Сервер',
	'INFORMATION_GROUP_SYSTEM'                  => 'Система',
	'INFORMATION_GROUP_THIRD_PARTY'             => 'Стороннє ПЗ',

	'INFORMATION_GROUP_ERRORS'                  => 'Помилки',
	'INFORMATION_GROUP_FILE_UPLOADS'            => 'Завантеження файлів',

	'INFORMATION_GROUP_EXTENSIONS'              => 'Розширення PHP',
	'INFORMATION_GROUP_DIRS'                    => 'Директорії',

	'INFORMATION_ROW_OS_VERSION'                => 'Версія ОС',
	'INFORMATION_ROW_PHP_VERSION'               => 'Версія PHP',
	'INFORMATION_ROW_MYSQL_VERSION'             => 'Версія MySQL',

	'INFORMATION_ROW_SYSTEM_VERSION'            => 'Версія CMS',
	'INFORMATION_ROW_DEBUG_MODE'                => 'Режим налагодження',

	'INFORMATION_ROW_JQUERY_VERSION'            => 'Версія jQuery',
	'INFORMATION_ROW_SEMANTIC_UI_VERSION'       => 'Версія Semantic UI',
	'INFORMATION_ROW_CKEDITOR_VERSION'          => 'Версія CKEditor',
	'INFORMATION_ROW_ACE_VERSION'               => 'Версія Ace Editor',

	'INFORMATION_ROW_EXTENSION_MYSQLI'          => 'MySQLi',
	'INFORMATION_ROW_EXTENSION_MBSTRING'        => 'Multibyte String',
	'INFORMATION_ROW_EXTENSION_GD'              => 'GD',
	'INFORMATION_ROW_EXTENSION_SIMPLEXML'       => 'SimpleXML',
	'INFORMATION_ROW_EXTENSION_DOM'             => 'DOM',

	'INFORMATION_ROW_DIR_UPLOADS'               => '/uploads',
	'INFORMATION_ROW_DIR_DATA'                  => '/engine/System/Data',

	'INFORMATION_VALUE_DEBUG_MODE_ON'           => 'Ввімкнений',
	'INFORMATION_VALUE_DEBUG_MODE_OFF'          => 'Вимкнений',

	'INFORMATION_VALUE_EXTENSION_LOADED'        => 'Підключене',
	'INFORMATION_VALUE_EXTENSION_NOT_LOADED'    => 'Відключене',

	'INFORMATION_VALUE_DIR_WRITABLE'            => 'Доступна для запису',
	'INFORMATION_VALUE_DIR_NOT_WRITABLE'        => 'Недоступна для запису'
];
