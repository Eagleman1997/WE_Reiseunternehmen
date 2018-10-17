<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Vorschlag von https://codeburst.io/how-to-maintain-core-php-projects-594721858cad

// connect to database
$con = mysqli_connect('host', 'user', 'password', 'db_name');

// check for connection errors
if(mysqli_connect_errno())
	die(mysqli_connect_error());

// function to execute query and automatically check for errors
function query($sql){
	$result = mysqli_query($GLOBALS['con'], $sql);
	
        if(!$result){
		die(mysqli_error($GLOBALS['con']));
	}
	return $result;
}