<?php

global $mysqli;

$database = [
	'host'		=> 'localhost',
	'username'	=> 'root',
	'password'	=> 'root',
	'database'	=> 'chat',
];

$mysqli = new mysqli(
	$database['host'],
	$database['username'],
	$database['password'],
	$database['database'],
);