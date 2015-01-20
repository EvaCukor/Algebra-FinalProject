<?php

include("db_connection.php");

echo '<a href="unos.php">Unos novog filma</a><br /><br />';

$slova = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "v", "z");
			   
foreach($slova as $key => $slovo)
{
	echo '<a href="index.php?s='.$slovo.'">'.mb_strtoupper($slovo).'</a> | ';
}

echo '<br />';
echo '<br />';

if(isset($_GET["s"]) && $_GET["s"] != "")
{
	$s = $_GET["s"];
	
	$query = "SELECT * FROM filmovi WHERE naslov LIKE '$s%' ORDER BY naslov ASC";
	$result = mysql_query($query);
	
	if($result)
	{
		while($film = mysql_fetch_array($result))
		{
			echo '
			<img src="img/'.$film["slika"].'" height="150" />
			<br />
			<i>'.$film["naslov"].' ('.$film["godina"].')</i>
			<br />
			<i>Trajanje: '.$film["trajanje"].' min</i>
			<br /><br />';
		}	
	}
}

?>