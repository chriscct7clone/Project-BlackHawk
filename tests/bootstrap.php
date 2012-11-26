<?php
error_reporting(E_ALL | E_STRICT);
$file = 'tests/config.inc.php';
$newfile = 'assets/config.inc.php';
if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}
function loader($class)
{
    $file = $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('loader');
