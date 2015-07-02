<?php

# Admin ip

define('CONFIG_ADMIN_IP',							'');

# Session

define('CONFIG_SESSION_NAME',						'sessid');
define('CONFIG_SESSION_LIFETIME',					2592000);		# 30 days

# Page

define('CONFIG_PAGE_NAME_MAX_LENGTH',				128);
define('CONFIG_PAGE_TITLE_MAX_LENGTH',				256);
define('CONFIG_PAGE_DESCRIPTION_MAX_LENGTH',		256);
define('CONFIG_PAGE_KEYWORDS_MAX_LENGTH',			256);

# Menuitem

define('CONFIG_MENUITEM_TEXT_MAX_LENGTH',			256);
define('CONFIG_MENUITEM_LINK_MAX_LENGTH',			512);
define('CONFIG_MENUITEM_POSITION_MAX_LENGTH',		2);

# User

define('CONFIG_USER_SESSION_LIFETIME',				604800);		# 7 days
define('CONFIG_USER_SECRET_LIFETIME',				86400);			# 1 day

define('CONFIG_USER_NAME_MIN_LENGTH',				4);
define('CONFIG_USER_NAME_MAX_LENGTH',				16);

define('CONFIG_USER_PASSWORD_MIN_LENGTH',			4);
define('CONFIG_USER_PASSWORD_MAX_LENGTH',			32);

define('CONFIG_USER_EMAIL_MAX_LENGTH',				128);

define('CONFIG_USER_FIRST_NAME_MAX_LENGTH',			32);
define('CONFIG_USER_LAST_NAME_MAX_LENGTH',			32);

define('CONFIG_USER_CITY_MAX_LENGTH',				32);

# Captcha

define('CONFIG_CAPTCHA_LENGTH',						5);

define('CONFIG_CAPTCHA_WIDTH',						150);
define('CONFIG_CAPTCHA_HEIGHT',						40);

define('CONFIG_CAPTCHA_FONT',						'Fonts/airstrip.ttf');
define('CONFIG_CAPTCHA_FONT_SIZE',					20);

define('CONFIG_CAPTCHA_TEXT_INDENT',				15);
define('CONFIG_CAPTCHA_TEXT_STEP',					25);

# Admin

define('CONFIG_ADMIN_LANGUAGE_DEFAULT',				'en_US');
define('CONFIG_ADMIN_TEMPLATE_DEFAULT',				'Default');

define('CONFIG_ADMIN_PAGES_DISPLAY',				50);
define('CONFIG_ADMIN_MENUITEMS_DISPLAY',			50);
define('CONFIG_ADMIN_USERS_DISPLAY',				50);

define('CONFIG_ADMIN_EMAIL_MAX_LENGTH',				128);

# Site

define('CONFIG_SITE_LANGUAGE_DEFAULT',				'en_US');
define('CONFIG_SITE_TEMPLATE_DEFAULT',				'Default');

define('CONFIG_SITE_TITLE_MAX_LENGTH',				128);
define('CONFIG_SITE_DESCRIPTION_MAX_LENGTH',		512);
define('CONFIG_SITE_KEYWORDS_MAX_LENGTH',			512);

# System

define('CONFIG_SYSTEM_URL_MAX_LENGTH',				128);

?>