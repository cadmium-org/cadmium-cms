<?php

# Admin ip

define('CONFIG_ADMIN_IP',							'');

# Session

define('CONFIG_SESSION_NAME',                       '_sessid');
define('CONFIG_SESSION_LIFETIME',                   2592000);       # 30 days

# Language

define('CONFIG_LANGUAGE_COOKIE_EXPIRES',            30758400);      # 356 days

# Template

define('CONFIG_TEMPLATE_COOKIE_EXPIRES',            30758400);      # 356 days

# Page

define('CONFIG_PAGE_TITLE_MAX_LENGTH',              255);
define('CONFIG_PAGE_NAME_MAX_LENGTH',               60);
define('CONFIG_PAGE_DESCRIPTION_MAX_LENGTH',        512);
define('CONFIG_PAGE_KEYWORDS_MAX_LENGTH',           512);

# Menuitem

define('CONFIG_MENUITEM_TEXT_MAX_LENGTH',           255);
define('CONFIG_MENUITEM_LINK_MAX_LENGTH',           255);
define('CONFIG_MENUITEM_POSITION_MAX_LENGTH',       2);

# File

define('CONFIG_FILE_NAME_MAX_LENGTH',               128);

# User

define('CONFIG_USER_SESSION_LIFETIME',              604800);        # 7 days
define('CONFIG_USER_SECRET_LIFETIME',               86400);         # 1 day

define('CONFIG_USER_NAME_MIN_LENGTH',               4);
define('CONFIG_USER_NAME_MAX_LENGTH',               16);

define('CONFIG_USER_PASSWORD_MIN_LENGTH',           4);
define('CONFIG_USER_PASSWORD_MAX_LENGTH',           32);

define('CONFIG_USER_EMAIL_MAX_LENGTH',              128);

define('CONFIG_USER_FIRST_NAME_MAX_LENGTH',         32);
define('CONFIG_USER_LAST_NAME_MAX_LENGTH',          32);

define('CONFIG_USER_CITY_MAX_LENGTH',               32);

define('CONFIG_USER_CAPTCHA_MAX_LENGTH',            16);

# Captcha

define('CONFIG_CAPTCHA_LENGTH',                     5);

define('CONFIG_CAPTCHA_WIDTH',                      150);
define('CONFIG_CAPTCHA_HEIGHT',                     40);

define('CONFIG_CAPTCHA_FONT',                       'Fonts/airstrip.ttf');
define('CONFIG_CAPTCHA_FONT_SIZE',                  20);

define('CONFIG_CAPTCHA_TEXT_INDENT',                15);
define('CONFIG_CAPTCHA_TEXT_STEP',                  25);

# Admin

define('CONFIG_ADMIN_LANGUAGE_DEFAULT',             'en-US');
define('CONFIG_ADMIN_TEMPLATE_DEFAULT',             'Default');

define('CONFIG_ADMIN_PAGES_DISPLAY',                50);
define('CONFIG_ADMIN_MENUITEMS_DISPLAY',            50);
define('CONFIG_ADMIN_FILES_DISPLAY',                50);
define('CONFIG_ADMIN_USERS_DISPLAY',                50);

# Site

define('CONFIG_SITE_LANGUAGE_DEFAULT',              'en-US');
define('CONFIG_SITE_TEMPLATE_DEFAULT',              'Default');

define('CONFIG_SITE_TITLE_DEFAULT',                 'Demo Site');
define('CONFIG_SITE_SLOGAN_DEFAULT',                'A place for site slogan');

define('CONFIG_SITE_TITLE_MAX_LENGTH',              128);
define('CONFIG_SITE_SLOGAN_MAX_LENGTH',             255);
define('CONFIG_SITE_DESCRIPTION_MAX_LENGTH',        512);
define('CONFIG_SITE_KEYWORDS_MAX_LENGTH',           512);

# System

define('CONFIG_SYSTEM_URL_MAX_LENGTH',				128);
define('CONFIG_SYSTEM_URL_DEFAULT',				    'http://example.com');

define('CONFIG_SYSTEM_EMAIL_MAX_LENGTH',			128);
define('CONFIG_SYSTEM_EMAIL_DEFAULT',				'admin@example.com');

define('CONFIG_SYSTEM_TIMEZONE_DEFAULT',			'UTC');

# Database

define('CONFIG_DATABASE_SERVER_MAX_LENGTH',         128);
define('CONFIG_DATABASE_USER_MAX_LENGTH',           64);
define('CONFIG_DATABASE_PASSWORD_MAX_LENGTH',       64);
define('CONFIG_DATABASE_NAME_MAX_LENGTH',           64);

# Other

define('CONFIG_UPLOADS_MAX_SIZE',                   107374182400);  # 100 MB
