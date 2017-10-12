<?php

define('APP_NAME', 'Auto Shop');
define('BASE_PASS', realpath(__DIR__ . '/..') . '/');

define("TYPE_DB", "mysql");

$config = [
	"db" => [
		"type" => "mysql",
		"mysql" => [
			"driver" => "mysql",
			"host" => "localhost",
			"username" => "user13",
			"password" => "tuser13",
			"dbname" => "user13",
			"charset" => "UTF8"
		],
	],
    "api" => [
        "defaultResponseFormat" => "json"
    ]
];
