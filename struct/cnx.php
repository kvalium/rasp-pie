<?php

//p@r@m BDD

	$host = 'localhost';
	$user = 'root';
	$bdd = 'rasppie';
	$passwd  = '';

// Connexion au serveur
mysql_connect($host, $user,$passwd) or die("<div class='alert alert-error'><h4>Unable to connect to the server !</h4><p>".  mysql_error()."</p></div>");

// connexion a la BDD
mysql_select_db($bdd) or die("<div class='alert alert-error'><h4>Unable to connect to the database ! </h4><p>".  mysql_error()."</p></div>");

mysql_query("SET NAMES UTF8"); 
?>
