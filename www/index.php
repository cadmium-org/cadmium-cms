<?php

require_once 'engine/Main.php';

try { new System\Dispatcher(); } catch (Error\Error $error) { Engine::error($error->message()); }

?>