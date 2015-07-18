<?php

require_once 'engine/Main.php';

try { new System\Installer(); }

catch (Error\Error $error) { Engine::error($error->message()); }

catch (Warning\Warning $warning) { Engine::warning($warning->message()); }

?>
