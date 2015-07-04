<?php

# Cadmium

define('CADMIUM_NAME',								'Cadmium CMS');
define('CADMIUM_HOME',								'http://cadmium-cms.com');

define('CADMIUM_VERSION',							'0.1 (beta)');
define('CADMIUM_COPY',								'2015');

# Sections

define('SECTION_ADMIN',								'Admin');
define('SECTION_SITE',								'Site');

# Config params

define('CONFIG_PARAM_ADMIN_LANGUAGE',				'admin_language');
define('CONFIG_PARAM_ADMIN_TEMPLATE',				'admin_template');
define('CONFIG_PARAM_ADMIN_EMAIL',					'admin_email');

define('CONFIG_PARAM_SITE_LANGUAGE',				'site_language');
define('CONFIG_PARAM_SITE_TEMPLATE',				'site_template');
define('CONFIG_PARAM_SITE_TITLE',					'site_title');
define('CONFIG_PARAM_SITE_STATUS',					'site_status');
define('CONFIG_PARAM_SITE_DESCRIPTION',				'site_description');
define('CONFIG_PARAM_SITE_KEYWORDS',				'site_keywords');

define('CONFIG_PARAM_SYSTEM_TIMEZONE',				'system_timezone');
define('CONFIG_PARAM_SYSTEM_URL',					'system_url');

define('CONFIG_PARAM_USERS_REGISTRATION',			'users_registration');

# User

define('USER_SESSION_PARAM_CODE',					'code');
define('USER_SESSION_PARAM_CAPTCHA',				'captcha');

define('USER_SECRET_PARAM_CODE',					'code');

# Access

define('ACCESS_PUBLIC',								0);
define('ACCESS_REGISTERED',							1);
define('ACCESS_ADMINISTRATOR',						2);

# Frequency

define('FREQUENCY_ALWAYS',							'always');
define('FREQUENCY_HOURLY',							'hourly');
define('FREQUENCY_DAILY',							'daily');
define('FREQUENCY_WEEKLY',							'weekly');
define('FREQUENCY_MONTHLY',							'monthly');
define('FREQUENCY_YEARLY',							'yearly');
define('FREQUENCY_NEVER',							'never');

# Rank

define('RANK_GUEST',								0);
define('RANK_USER',									1);
define('RANK_ADMINISTRATOR',						2);

# Sex

define('SEX_NOT_SELECTED',							0);
define('SEX_MALE',									1);
define('SEX_FEMALE',								2);

# Status

define('STATUS_ONLINE',								0);
define('STATUS_MAINTENANCE',						1);
define('STATUS_UPDATE',								2);

# Target

define('TARGET_SELF',								0);
define('TARGET_BLANK',								1);

?>
