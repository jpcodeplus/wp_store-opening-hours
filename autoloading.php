<?php

// Include all PHP Classes with autoloding 

function cpm_include_files($path)
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    foreach ($iterator as $file) {
        $pathname = $file->getPathname();

        if ($file->isDir()) continue;
        if (strpos($pathname, '.php') !== false) require_once $pathname;
    }
}


function cpm_spl_autoloading($class_name)
{
    if (strpos($class_name, 'CPM_Plugin\\') !== 0) {
        return; // Nicht Teil des Plugins, also überspringen
    }

    $class_name = str_replace('CPM_Plugin\\', '', $class_name);
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);

    $file = CPM_INCLUDES . $class_name . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        // Optional: Fehlermeldung, wenn die Datei nicht gefunden wird
        error_log("Datei nicht gefunden: $file");
    }
}


spl_autoload_register('cpm_spl_autoloading');
