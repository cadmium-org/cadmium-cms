<?php

# Cadmium

define('CADMIUM_NAME',                              'Cadmium CMS');
define('CADMIUM_HOME',                              'http://cadmium-cms.com');

define('CADMIUM_VERSION',                           '0.2.0');
define('CADMIUM_COPY',                              '2015');

# External

define('JQUERY_VERSION',                            '2.1.4');
define('SEMANTIC_UI_VERSION',                       '2.1.4');
define('CKEDITOR_VERSION',                          '4.5.4');

# Sections

define('SECTION_ADMIN',                             'Admin');
define('SECTION_SITE',                              'Site');

# Entity types

define('ENTITY_TYPE_PAGE',                          'Page');
define('ENTITY_TYPE_MENUITEM',                      'Menuitem');
define('ENTITY_TYPE_USER',                          'User');
define('ENTITY_TYPE_USER_SECRET',                   'User\Secret');
define('ENTITY_TYPE_USER_SESSION',                  'User\Session');

# Access

define('ACCESS_PUBLIC',                             0);
define('ACCESS_REGISTERED',                         1);
define('ACCESS_ADMINISTRATOR',                      2);

# Frequency

define('FREQUENCY_ALWAYS',                          'always');
define('FREQUENCY_HOURLY',                          'hourly');
define('FREQUENCY_DAILY',                           'daily');
define('FREQUENCY_WEEKLY',                          'weekly');
define('FREQUENCY_MONTHLY',                         'monthly');
define('FREQUENCY_YEARLY',                          'yearly');
define('FREQUENCY_NEVER',                           'never');

# Rank

define('RANK_GUEST',                                0);
define('RANK_USER',                                 1);
define('RANK_ADMINISTRATOR',                        2);

# Sex

define('SEX_NOT_SELECTED',                          0);
define('SEX_MALE',                                  1);
define('SEX_FEMALE',                                2);

# Status

define('STATUS_ONLINE',                             0);
define('STATUS_MAINTENANCE',                        1);
define('STATUS_UPDATE',                             2);

# Target

define('TARGET_SELF',                               0);
define('TARGET_BLANK',                              1);

# Visibility

define('VISIBILITY_DRAFT',                          0);
define('VISIBILITY_PUBLISHED',                      1);
