<?php

// This is the database connection configuration.
$x132 = array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=MorPa',
	'emulatePrepare' => true,
	'username' => 'admin',
	'password' => 'admin',
    'charset' => 'utf8',
);

	$myServer = "localhost";
	$myUser = "admin";
	$myPass = "admin";
	$myDB = "MorPa";
	
	//connection to the database
	$dbhandler = mysql_connect($myServer, $myUser, $myPass)
	  or die("Couldn't connect to SQL Server on $myServer");
	if(!$dbhandler){echo "FAULT";}
	
	//select a database to work with
	$selected = mysql_select_db($myDB, $dbhandler)
	  or die("Couldn't open database $myDB");

    mysql_query("SET NAMES utf8");




return $x132;