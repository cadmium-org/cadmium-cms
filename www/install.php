<?php

require_once 'engine/Main.php';

try { $installer = new System\Installer(); $installer->handle(); }

catch (Error\Error $error) { Engine::error($error->message()); }
