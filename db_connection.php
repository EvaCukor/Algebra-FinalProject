<?php

$server   = "localhost";
$username = "root";
$password = "";
$database = "kolekcija";

$db = mysql_connect($server, $username, $password);

if($db)
{
	#echo 'Konekcija uspostavljena';
	#echo '<br />';
	
	if(mysql_select_db($database, $db))
	{
		mysql_query("SET NAMES utf8");
		
		#echo 'Baza uspijesno odabrana';
		#echo '<br />';
	}
	else
	{
		echo 'Greska u odabiru baze'; 
		echo '<br />';
	}
}
else
{
	echo 'Doslo je do pogreske kod spajanja';
	echo '<br />';
}



?>