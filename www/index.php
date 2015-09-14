<?php

require_once 'engine/Main.php';

try { $dispatcher = new System\Dispatcher(); $dispatcher->handle(); }

catch (Error\Error $error) { Engine::error($error->message()); }
