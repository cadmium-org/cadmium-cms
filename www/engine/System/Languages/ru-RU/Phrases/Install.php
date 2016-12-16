<?php

/**
 * @package Cadmium\System\Languages\ru-RU
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

return [

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

	'INSTALL_REQUIREMENT_DOM_SUCCESS'           => 'Расширение DOM установлено.',
	'INSTALL_REQUIREMENT_DOM_FAIL'              => 'Расширение DOM не установлено.',

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

	'INSTALL_FIELD_DATABASE_SERVER'             => 'Сервер',
	'INSTALL_FIELD_DATABASE_USER'               => 'Имя пользователя',
	'INSTALL_FIELD_DATABASE_PASSWORD'           => 'Пароль',
	'INSTALL_FIELD_DATABASE_NAME'               => 'Название базы данных',

	# Pages

	'INSTALL_PAGE_INDEX_TITLE'                  => 'Главная',

	'INSTALL_PAGE_INDEX_CONTENTS'               => '<h2>Добро пожаловать!</h2>' .
	                                               '<p>Это демонстрационный сайт, работающий на <strong>Cadmium CMS</strong>.</p>' .
	                                               '<p>Вы можете войти в панель управления, перейдя по <a href="$install_path$/admin">этой ссылке</a>.</p>' .
	                                               '<h2>Смотрите также</h2>' .
	                                               '<ul><li><a href="http://cadmium-cms.com" target="_blank">Официальный сайт</a></li>' .
	                                               '<li><a href="https://github.com/cadmium-org/cadmium-cms" target="_blank">Страница проекта на GitHub</a></li></ul>',

	'INSTALL_PAGE_DEMO_TITLE'                   => 'Страница',

	'INSTALL_PAGE_DEMO_CONTENTS'                => '<h2>Lorem ipsum</h2>' .

	                                               '<p>Lorem ipsum dolor sit amet, ex etiam facilis vim. ' .
	                                               'Qui etiam soluta nostro no, te praesent consulatu eos. ' .
	                                               'His at modus diceret referrentur, exerci viderer aperiri et sed. ' .
	                                               'Ne errem appareat apeirian has, ut has eligendi comprehensam. ' .
	                                               'His ea adipisci eloquentiam, nec id temporibus appellantur. ' .
	                                               'Pri ut inermis persequeris contentiones, vel vidit ponderum cu.</p>' .

	                                               '<h3>Vix no suas populo</h3>' .

	                                               '<p>Vix no suas populo. Mea inani utinam ex. Duo vocibus noluisse partiendo ei. ' .
	                                               'Impedit voluptatibus pro ut, ea probatus reformidans pri. ' .
	                                               'An vix repudiandae complectitur, ex soluta numquam splendide nam.</p>' .

	                                               '<p>Mea ex novum contentiones, eleifend ocurreret voluptaria et usu. ' .
	                                               'No mel illum nonumy maiorum, pro saperet disputando in. Cum ei tritani accusam incorrupte. ' .
	                                               'Per animal saperet suavitate id, vim ex quod delicatissimi.</p>' .

	                                               '<h3>Ea mea tantas delenit</h3>' .

	                                               '<p>Ea mea tantas delenit, ut usu alii commune. ' .
	                                               'Te vix decore dolore scribentur. Ad pri malis invidunt ullamcorper, ' .
	                                               'qui eu laboramus vulputate scriptorem, id veri audiam integre pro. ' .
	                                               'Saperet luptatum recusabo quo cu, ' .'vix facer dolores persecuti no. ' .
	                                               'Eos id omnes affert possim. Vix id commune urbanitas.</p>' .

	                                               '<p>Cu eum quod prodesset, vix sale democritum delicatissimi et, ' .
	                                               'putant viderer inimicus pro ut. Sea ut tamquam hendrerit definitionem, ' .
	                                               'an quo illud persecuti, debet affert vis te. Mei ea omnes saepe nostrum. ' .
	                                               'In sed denique iudicabit. Id eos equidem scribentur.</p>'
];
