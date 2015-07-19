<?php

namespace System\Handlers\Admin\Install {

    use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity, System\Utils\Extend;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Configure extends System\Frames\Admin\Handler {

        private $form = false;

        # Errors

        const ERROR_CONFIG                          = 'INSTALL_ERROR_CONFIG';
        const ERROR_SYSTEM                          = 'INSTALL_ERROR_SYSTEM';

        const ERROR_DATABASE_CONNECT                = 'INSTALL_ERROR_DATABASE_CONNECT';
        const ERROR_DATABASE_SELECT                 = 'INSTALL_ERROR_DATABASE_SELECT';
        const ERROR_DATABASE_CHARSET                = 'INSTALL_ERROR_DATABASE_CHARSET';
        const ERROR_DATABASE_TABLES_CREATE          = 'INSTALL_ERROR_DATABASE_TABLES_CREATE';
        const ERROR_DATABASE_TABLES_FILL            = 'INSTALL_ERROR_DATABASE_TABLES_FILL';

        const ERROR_INPUT_SITE_TITLE				= 'INSTALL_ERROR_INPUT_SITE_TITLE';
        const ERROR_INPUT_SYSTEM_URL				= 'INSTALL_ERROR_INPUT_SYSTEM_URL';
        const ERROR_INPUT_SYSTEM_TIMEZONE			= 'INSTALL_ERROR_INPUT_SYSTEM_TIMEZONE';
        const ERROR_INPUT_SYSTEM_EMAIL				= 'INSTALL_ERROR_INPUT_SYSTEM_EMAIL';

        const ERROR_INPUT_DATABASE_SERVER			= 'INSTALL_ERROR_INPUT_DATABASE_SERVER';
        const ERROR_INPUT_DATABASE_USER             = 'INSTALL_ERROR_INPUT_DATABASE_USER';
        const ERROR_INPUT_DATABASE_PASSWORD         = 'INSTALL_ERROR_INPUT_DATABASE_PASSWORD';
        const ERROR_INPUT_DATABASE_NAME             = 'INSTALL_ERROR_INPUT_DATABASE_NAME';

        # Get pages table

        private function getPagesTable() {

            $table = new System\Utils\Table\Table(TABLE_PAGES);

            # Add fields

            $table->fieldset()->id          ('id', true);
            $table->fieldset()->id          ('parent_id');
            $table->fieldset()->range       ('access');
            $table->fieldset()->varchar     ('name', CONFIG_PAGE_NAME_MAX_LENGTH);
            $table->fieldset()->varchar     ('title', CONFIG_PAGE_TITLE_MAX_LENGTH);
            $table->fieldset()->text        ('contents');
            $table->fieldset()->varchar     ('description', CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);
            $table->fieldset()->varchar     ('keywords', CONFIG_PAGE_KEYWORDS_MAX_LENGTH);
            $table->fieldset()->boolean     ('robots_index', true);
            $table->fieldset()->boolean     ('robots_follow', true);
            $table->fieldset()->id          ('user_id');
            $table->fieldset()->time        ('time_created');
            $table->fieldset()->time        ('time_modified');

            # Add keys

            $table->keyset()->primary       ('id');
            $table->keyset()->index         ('parent_id');
            $table->keyset()->index         ('access');
            $table->keyset()->index         ('name');
            $table->keyset()->index         ('title');
            $table->keyset()->index         ('user_id');
            $table->keyset()->index         ('time_created');
            $table->keyset()->index         ('time_modified');

            # ------------------------

            return $table;
        }

        # Get menu table

        private function getMenuTable() {

            $table = new System\Utils\Table\Table(TABLE_MENU);

            # Add fields

            $table->fieldset()->id          ('id', true);
            $table->fieldset()->id          ('parent_id');
            $table->fieldset()->range       ('position');
            $table->fieldset()->varchar     ('link', CONFIG_MENUITEM_LINK_MAX_LENGTH);
            $table->fieldset()->varchar     ('text', CONFIG_MENUITEM_TEXT_MAX_LENGTH);
            $table->fieldset()->range       ('target');

            # Add keys

            $table->keyset()->primary       ('id');
            $table->keyset()->index         ('parent_id');
            $table->keyset()->index         ('position');

            # ------------------------

            return $table;
        }

        # Get users table

        private function getUsersTable() {

            $table = new System\Utils\Table\Table(TABLE_USERS);

            # Add fields

            $table->fieldset()->id          ('id', true);
            $table->fieldset()->range       ('rank', RANK_USER);
            $table->fieldset()->varchar     ('name', CONFIG_USER_NAME_MAX_LENGTH);
            $table->fieldset()->varchar     ('email', CONFIG_USER_EMAIL_MAX_LENGTH);
            $table->fieldset()->hash        ('auth_key');
            $table->fieldset()->hash        ('password');
            $table->fieldset()->varchar     ('first_name', CONFIG_USER_FIRST_NAME_MAX_LENGTH);
            $table->fieldset()->varchar     ('last_name', CONFIG_USER_LAST_NAME_MAX_LENGTH);
            $table->fieldset()->range       ('sex');
            $table->fieldset()->varchar     ('city', CONFIG_USER_CITY_MAX_LENGTH);
            $table->fieldset()->varchar     ('country', 2);
            $table->fieldset()->varchar     ('timezone', 64);
            $table->fieldset()->time        ('time_registered');
            $table->fieldset()->time        ('time_logged');

            # Add keys

            $table->keyset()->primary       ('id');
            $table->keyset()->unique        ('name');
            $table->keyset()->unique        ('email');
            $table->keyset()->index         ('time_registered');
            $table->keyset()->index         ('time_logged');

            # ------------------------

            return $table;
        }

        # Get users secrets table

        private function getUsersSecretsTable() {

            $table = new System\Utils\Table\Table(TABLE_USERS_SECRETS);

            # Add fields

            $table->fieldset()->id          ('id', true);
            $table->fieldset()->hash        ('code');
            $table->fieldset()->varchar     ('ip', 64);
            $table->fieldset()->time        ('time');

            # Add keys

            $table->keyset()->primary       ('id');
            $table->keyset()->unique        ('code');
            $table->keyset()->index         ('ip');
            $table->keyset()->index         ('time');

            # ------------------------

            return $table;
        }

        # Get users sessions table

        private function getUsersSessionsTable() {

            $table = new System\Utils\Table\Table(TABLE_USERS_SESSIONS);

            # Add fields

            $table->fieldset()->id          ('id', true);
            $table->fieldset()->hash        ('code');
            $table->fieldset()->varchar     ('ip', 64);
            $table->fieldset()->time        ('time');

            # Add keys

            $table->keyset()->primary       ('id');
            $table->keyset()->unique        ('code');
            $table->keyset()->index         ('ip');
            $table->keyset()->index         ('time');

            # ------------------------

            return $table;
        }

        # Create database tables

        private function createTables() {

            $tables[] = $this->getMenuTable();

            $tables[] = $this->getPagesTable();

            $tables[] = $this->getUsersTable();

            $tables[] = $this->getUsersSecretsTable();

            $tables[] = $this->getUsersSessionsTable();

            foreach ($tables as $table) if (!$table->create()) return false;

            # ------------------------

            return true;
        }

        # Fill pages table

        private function fillPagesTable() {

            # Count pages

            if (!(DB::select(TABLE_PAGES, "COUNT(*) as count") && (DB::last()->rows === 1))) return false;

            if (Number::unsigned(DB::last()->row()['count']) > 0) return true;

            # Insert initial pages

            $pages[] = array('name' => 'index', 'title' => Language::get('INSTALL_PAGE_INDEX_TITLE'),

                'contents' => Language::get('INSTALL_PAGE_INDEX_CONTENTS'),

                'time_created' => ENGINE_TIME, 'time_modified' => ENGINE_TIME);

            for ($i = 1; $i <= 3; $i++) $pages[] = array (

                'name' => ('page-' . $i), 'title' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i),

                'contents' => Language::get('INSTALL_PAGE_DEMO_CONTENTS'),

                'time_created' => ENGINE_TIME, 'time_modified' => ENGINE_TIME);

            return (DB::insert(TABLE_PAGES, $pages, true) && DB::last()->status);
        }

        # Fill menu table

        private function fillMenuTable() {

            # Count menuitems

            if (!(DB::select(TABLE_MENU, "COUNT(*) as count") && (DB::last()->rows === 1))) return false;

            if (Number::unsigned(DB::last()->row()['count']) > 0) return true;

            # Insert initial menuitems

            for ($i = 1; $i <= 3; $i++) $menu[] = array (

                'position' => ($i - 1), 'link' => ('/page-' . $i),

                'text' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i));

            return (DB::insert(TABLE_MENU, $menu, true) && DB::last()->status);
        }

        # Fill tables

        private function fillTables() {

            return ($this->fillPagesTable() && $this->fillMenuTable());
        }

        # Install CMS

        private function install($data) {

			# Check dataset

			$dataset = array('site_title', 'system_url', 'system_timezone', 'system_email',

							 'database_server', 'database_user', 'database_password', 'database_name');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

            # Set language/template values

            Config::set(CONFIG_PARAM_ADMIN_LANGUAGE,    Extend\Languages::active());
            Config::set(CONFIG_PARAM_ADMIN_TEMPLATE,    Extend\Templates::active());

            Config::set(CONFIG_PARAM_SITE_LANGUAGE,     Extend\Languages::active());
            Config::set(CONFIG_PARAM_SITE_TEMPLATE,     Extend\Templates::active());

			# Validate configuration values

            if (false === Config::set(CONFIG_PARAM_SITE_TITLE, $site_title)) return self::ERROR_INPUT_SITE_TITLE;

            if (false === Config::set(CONFIG_PARAM_SYSTEM_URL, $system_url)) return self::ERROR_INPUT_SYSTEM_URL;

            if (false === Config::set(CONFIG_PARAM_SYSTEM_TIMEZONE, $system_timezone)) return self::ERROR_INPUT_SYSTEM_TIMEZONE;

            if (false === Config::set(CONFIG_PARAM_SYSTEM_EMAIL, $system_email)) return self::ERROR_INPUT_SYSTEM_EMAIL;

            # Check database values

			if (false === ($database_server = String::validate($database_server))) return self::ERROR_INPUT_DATABASE_SERVER;

			if (false === ($database_user = String::validate($database_user))) return self::ERROR_INPUT_DATABASE_USER;

			if (false === ($database_password = String::validate($database_password))) return self::ERROR_INPUT_DATABASE_PASSWORD;

			if (false === ($database_name = String::validate($database_name))) return self::ERROR_INPUT_DATABASE_NAME;

            # Connect to DB

            try { DB::connect($database_server, $database_user, $database_password, $database_name); }

            catch (Error\DBConnect $error) { return self::ERROR_DATABASE_CONNECT; }

            catch (Error\DBSelect $error) { return self::ERROR_DATABASE_SELECT; }

            catch (Error\DBCharset $error) { return self::ERROR_DATABASE_CHARSET; }

            # Create tables

            if (!$this->createTables()) return self::ERROR_DATABASE_TABLES_CREATE;

            # Fill tables

            if (!$this->fillTables()) return self::ERROR_DATABASE_TABLES_FILL;

            # Save configuration

            if (!Config::save()) return self::ERROR_CONFIG;

            $system['database']['server']       = $database_server;
            $system['database']['user']         = $database_user;
            $system['database']['password']     = $database_password;
            $system['database']['name']         = $database_name;

            $system['time'] = ENGINE_TIME;

            if (!Explorer::save((DIR_SYSTEM_DATA . 'System.json'), json_encode($system, JSON_PRETTY_PRINT))) return self::ERROR_SYSTEM;

            # ------------------------

            return true;
		}

        # Get contents

        private function getContents() {

            $contents = Template::block('Contents/Install/Configure');

            # Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
        }

		# Handle request

		protected function handle() {

            # Create form

			$this->form = new Form(); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text          ('site_title', CONFIG_SITE_TITLE, CONFIG_SITE_TITLE_MAX_LENGTH);

			$fieldset->text          ('system_url', CONFIG_SYSTEM_URL, CONFIG_SYSTEM_URL_MAX_LENGTH);

			$fieldset->select        ('system_timezone', CONFIG_SYSTEM_TIMEZONE, Timezone::range(), Language::get('SELECT_TIMEZONE'));

			$fieldset->text          ('system_email', CONFIG_SYSTEM_EMAIL, CONFIG_SYSTEM_EMAIL_MAX_LENGTH);

			$fieldset->text          ('database_server', 'localhost', CONFIG_INSTALL_DATABASE_SERVER_MAX_LENGTH);

			$fieldset->text          ('database_user', false, CONFIG_INSTALL_DATABASE_USER_MAX_LENGTH);

			$fieldset->password      ('database_password', false, CONFIG_INSTALL_DATABASE_PASSWORD_MAX_LENGTH);

			$fieldset->text          ('database_name', false, CONFIG_INSTALL_DATABASE_NAME_MAX_LENGTH);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (true !== ($result = $this->install($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/register');
			}

            # Fill template

			$this->setTitle(Language::get('INSTALL_TITLE_CONFIGURE'));

			$this->setContents($this->getContents());

            # ------------------------

			return true;
		}
	}
}

?>
