<?php

	$DB_HOST = 'localhost';
	$DB_USER = 'elaeltdc_jubo_48_user';
	$DB_PASS = 'Bog@Tar_A25';
	$DB_NAME = 'elaeltdc_jubo_48_db';
	
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	
?>