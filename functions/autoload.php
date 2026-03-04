<?php
session_start();

function autoloadClases($className)
{
    $classFile = __DIR__ . "/../class/" . $className . ".php";
    if (file_exists($classFile)) {
        require_once $classFile;
    }
}

spl_autoload_register('autoloadClases');
