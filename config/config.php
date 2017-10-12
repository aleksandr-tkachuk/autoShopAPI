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
			"username" => "root",
			"password" => "123456",
			"dbname" => "autoShop",
			"charset" => "UTF8"
		],
	],
    "api" => [
        "defaultResponseFormat" => "json"
    ]
];
