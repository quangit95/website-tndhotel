<?php
// Using Medoo namespace
use Medoo\Medoo;

// Initialize
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'dev_export',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    "charset" => "utf8",
    // Enable logging
    "logging" => true
]);
