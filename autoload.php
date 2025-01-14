<?php

spl_autoload_register("gbStandardAutoload");

function gbStandardAutoload($className)
{
    $dirs = [
        'controllers',
        'views',
        'models'

    ];
    $found = false;
    foreach ($dirs as $dir) {

        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/' . $dir . '/' . $className . '.php';

        if (is_file($fileName)) {
            require_once ($fileName);
            $found = true;

        }
    }

    if (!$found) {
        throw new Exception('Unable to load ' . $className);
    }
    return true;
}