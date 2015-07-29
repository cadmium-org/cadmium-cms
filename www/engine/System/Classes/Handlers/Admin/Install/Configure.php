<?php

namespace System\Handlers\Admin\Install {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

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

        # Create database tables

        private function createTables() {

            $entities[] = new Entity\Type\Page\Definition();

            $entities[] = new Entity\Type\Menuitem\Definition();

            $entities[] = new Entity\Type\User\Definition();

            $entities[] = new Entity\Type\User\Secret\Definition();

            $entities[] = new Entity\Type\User\Session\Definition();

            foreach ($entities as $entity) if (!$entity->createTable()) return false;

            # ------------------------

            return true;
        }

        # Fill pages table

        private function fillPagesTable() {

            # Count pages

            if (!(DB::select(TABLE_PAGES, "COUNT(*) as count") && (DB::last()->rows === 1))) return false;

            if (Number::unsigned(DB::last()->row()['count']) > 0) return true;

            # Insert initial pages

            $pages[] = array('visibility' => VISIBILITY_PUBLISHED,

				'name' => 'index', 'title' => Language::get('INSTALL_PAGE_INDEX_TITLE'),

                'contents' => Language::get('INSTALL_PAGE_INDEX_CONTENTS'),

                'time_created' => ENGINE_TIME, 'time_modified' => ENGINE_TIME);

            for ($i = 1; $i <= 3; $i++) $pages[] = array ('visibility' => VISIBILITY_PUBLISHED,

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

        private function install($fieldset) {

			# Check fieldset

			$fields = array('site_title', 'system_url', 'system_timezone', 'system_email',

							'database_server', 'database_user', 'database_password', 'database_name');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

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

            # Save system file

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

			$fieldset->text          ('site_title', CONFIG_SITE_TITLE, CONFIG_SITE_TITLE_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text          ('system_url', CONFIG_SYSTEM_URL, CONFIG_SYSTEM_URL_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->select        ('system_timezone', CONFIG_SYSTEM_TIMEZONE, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_REQUIRED);

			$fieldset->text          ('system_email', CONFIG_SYSTEM_EMAIL, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text          ('database_server', 'localhost', CONFIG_DATABASE_SERVER_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text          ('database_user', false, CONFIG_DATABASE_USER_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text          ('database_password', false, CONFIG_DATABASE_PASSWORD_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text          ('database_name', false, CONFIG_DATABASE_NAME_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			# Post form

			if (false !== ($post = $this->form->post()) && !$this->form->errors()) {

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
