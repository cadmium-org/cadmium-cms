<?php

/**
 * @package Cadmium\System
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Admin ip

define('CONFIG_ADMIN_IP',                           '');

# Session

define('CONFIG_SESSION_NAME',                       '_sessid');
define('CONFIG_SESSION_LIFETIME',                   2592000);       # 30 days

# Default settings

define('CONFIG_SITE_LANGUAGE',                      'en-US');
define('CONFIG_SITE_TEMPLATE',                      'Default');

define('CONFIG_SITE_TITLE',                         'Demo Site');
define('CONFIG_SITE_SLOGAN',                        'A place for site slogan');
define('CONFIG_SITE_STATUS',                        STATUS_ONLINE);
define('CONFIG_SITE_DESCRIPTION',                   '');
define('CONFIG_SITE_KEYWORDS',                      '');

define('CONFIG_SYSTEM_URL',                         'http://example.com');
define('CONFIG_SYSTEM_EMAIL',                       'admin@example.com');
define('CONFIG_SYSTEM_TIMEZONE',                    'UTC');

define('CONFIG_ADMIN_LANGUAGE',                     'en-US');
define('CONFIG_ADMIN_TEMPLATE',                     'Default');

define('CONFIG_ADMIN_DISPLAY_ENTITIES',             50);
define('CONFIG_ADMIN_DISPLAY_FILES',                40);

# Language

define('CONFIG_LANGUAGE_COOKIE_EXPIRES',            30758400);      # 356 days

# Template

define('CONFIG_TEMPLATE_COOKIE_EXPIRES',            30758400);      # 356 days

# Auth

define('CONFIG_USER_SESSION_LIFETIME',              604800);        # 7 days
define('CONFIG_USER_SECRET_LIFETIME',               86400);         # 1 day

# Entitizer

define('CONFIG_ENTITIZER_MAX_DEPTH',                6);

# Database fields

define('CONFIG_DATABASE_SERVER_MAX_LENGTH',         128);
define('CONFIG_DATABASE_USER_MAX_LENGTH',           64);
define('CONFIG_DATABASE_PASSWORD_MAX_LENGTH',       64);
define('CONFIG_DATABASE_NAME_MAX_LENGTH',           64);

# Page fields

define('CONFIG_PAGE_TITLE_MAX_LENGTH',              255);
define('CONFIG_PAGE_NAME_MAX_LENGTH',               40);
define('CONFIG_PAGE_DESCRIPTION_MAX_LENGTH',        512);
define('CONFIG_PAGE_KEYWORDS_MAX_LENGTH',           512);

# Menuitem fields

define('CONFIG_MENUITEM_TEXT_MAX_LENGTH',           255);
define('CONFIG_MENUITEM_SLUG_MAX_LENGTH',           255);
define('CONFIG_MENUITEM_POSITION_MAX_LENGTH',       2);

# Variable fields

define('CONFIG_VARIABLE_TITLE_MAX_LENGTH',          64);
define('CONFIG_VARIABLE_NAME_MAX_LENGTH',           32);
define('CONFIG_VARIABLE_VALUE_MAX_LENGTH',          255);

# Widget fields

define('CONFIG_WIDGET_TITLE_MAX_LENGTH',            64);
define('CONFIG_WIDGET_NAME_MAX_LENGTH',             32);

# Filemanager fields

define('CONFIG_FILEMANAGER_NAME_MAX_LENGTH',        128);

# User fields

define('CONFIG_USER_NAME_MIN_LENGTH',               4);
define('CONFIG_USER_NAME_MAX_LENGTH',               16);

define('CONFIG_USER_PASSWORD_MIN_LENGTH',           4);
define('CONFIG_USER_PASSWORD_MAX_LENGTH',           32);

define('CONFIG_USER_EMAIL_MAX_LENGTH',              128);

define('CONFIG_USER_FIRST_NAME_MAX_LENGTH',         32);
define('CONFIG_USER_LAST_NAME_MAX_LENGTH',          32);

define('CONFIG_USER_CITY_MAX_LENGTH',               32);

define('CONFIG_USER_CAPTCHA_MAX_LENGTH',            16);

# Settings fields

define('CONFIG_SITE_TITLE_MAX_LENGTH',              128);
define('CONFIG_SITE_SLOGAN_MAX_LENGTH',             255);
define('CONFIG_SITE_DESCRIPTION_MAX_LENGTH',        512);
define('CONFIG_SITE_KEYWORDS_MAX_LENGTH',           512);

define('CONFIG_SYSTEM_URL_MAX_LENGTH',              128);
define('CONFIG_SYSTEM_EMAIL_MAX_LENGTH',            128);

# Captcha

define('CONFIG_CAPTCHA_LENGTH',                     5);

define('CONFIG_CAPTCHA_WIDTH',                      150);
define('CONFIG_CAPTCHA_HEIGHT',                     40);

define('CONFIG_CAPTCHA_FONT',                       'Fonts/airstrip.ttf');
define('CONFIG_CAPTCHA_FONT_SIZE',                  20);

define('CONFIG_CAPTCHA_TEXT_INDENT',                15);
define('CONFIG_CAPTCHA_TEXT_STEP',                  25);

# Uploads

define('CONFIG_UPLOADS_MAX_SIZE',                   104857600);     # 100 MB
