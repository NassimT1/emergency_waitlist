<?php

// Connection to database

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'emergency_waitlist';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$GLOBALS["appDir"] = resolve_path("app");

function resolve_path($name)
{
    if ($name == ".")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
        $appRoot = $_SERVER["DOCUMENT_ROOT"];
    }
    else if ($_SERVER["DOCUMENT_ROOT"] != "")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/../$name";
        $appRoot = $_SERVER["DOCUMENT_ROOT"] . "/$name";
    }
    else
    {
        return "../{$name}";
    }

    return file_exists($publicRoot) ? realpath($publicRoot) : realpath($appRoot);
}

spl_autoload_register(function ($fullName) {
    $parts = explode("\\", $fullName);
    $len = count($parts);
    $className = $parts[$len - 1];
    if (file_exists($GLOBALS["appDir"] . "/models/{$className}.php"))
    {
      require_once $GLOBALS["appDir"] . "/models/{$className}.php";
    }
});
