<?php

include("db_connection.php");

echo '<a href="index.php">Naslovnica</a><br /><br />';

//brisanje filma
if(isset($_GET["act"]) && $_GET["act"]=="delete")
{
	$id = $_GET["id"];
	$img = 'img/'.$_GET["img"];
	
	$img_delete = unlink($img);
	
	$query_delete = "DELETE FROM filmovi WHERE id='$id' LIMIT 1";
	$result_delete = mysql_query($query_delete);
		
	if($result_delete && $img_delete)
	{
		echo 'Podaci uspješno obrisani.<br />';
	}
	else
	{
		echo '<font color="#FF0000">Greška kod brisanja podataka.</font><br />';
	}
}

//spremanje novog filma
if(isset($_POST["btn_unos"]))
{
	$dopusti_unos = 1;
	$poruka = '';
	
	$naslov = addslashes(trim($_POST["naslov"]));
	$zanr = $_POST["zanr"];
	$godina = $_POST["godina"];
	$trajanje = $_POST["trajanje"];
	
	//provjere i pohrana
	if($naslov == "" && $trajanje == "" && $_FILES["slika"]["name"] == "")
	{
		$dopusti_unos = 0;
		$poruka .= '<font color="#FF0000">Potrebno je ispuniti sva polja.</font><br />';
	}
	else
	{
		if($naslov == "")
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Polje <i>Naslov</i> je obavezno.</font><br />';
		}
		
		$provjera_zanra_query = "SELECT COUNT(id) FROM zanr WHERE id='$zanr'";
		$provjera_zanra_result = mysql_query($provjera_zanra_query);
		list($provjera_zanra) = mysql_fetch_array($provjera_zanra_result);
		
		if (!$provjera_zanra)
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Polje <i>Žanr</i> nije ispravno popunjeno.</font><br />';
		}
		
		if (!(ctype_digit($godina) && strlen($godina) == 4))
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Polje <i>Godina</i> nije ispravno popunjeno.</font><br />';
		}
		
		if(!ctype_digit($trajanje) && $trajanje != "")
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Polje <i>Trajanje</i> mora biti broj.</font><br />';
		}
		
		if($trajanje == "")
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Polje <i>Trajanje</i> je obavezno.</font><br />';
		}
		
		if($_FILES["slika"]["name"] == "")
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Slika je obavezna.</font><br />';
		}
	}
	
	if($dopusti_unos)
	{
		//upload slike
		$uploaddir = "img/";
		$uploadfile = basename($_FILES["slika"]["name"]);
		
		$file_array = explode(".", $uploadfile);
		$ext = end($file_array);
		$size = filesize($_FILES["slika"]["tmp_name"]);
		
		//provjera postoji li već slika s istim imenom
		$query_slika = "SELECT COUNT(id) FROM filmovi WHERE slika='$uploadfile'";
		$result_slika = mysql_query($query_slika);
		list($br_imena) = mysql_fetch_array($result_slika);
		if($br_imena >= 1)
		{
			$br_imena += 1;
			$uploadfile = $file_array[0].'_'.$br_imena.'.'.$ext;
		}
		
		$new_file_name = $uploaddir.$uploadfile;
		
		if(!move_uploaded_file($_FILES["slika"]["tmp_name"], $new_file_name))
		{
			$dopusti_unos = 0;
			$poruka .= '<font color="#FF0000">Greška kod pohrane slike.</font><br />';
		}
		
		//spremanje podataka
		if($dopusti_unos)
		{
			$query_unos = "INSERT INTO filmovi
						   (naslov, id_zanr, godina, trajanje, slika)
						   VALUES
						   ('$naslov', '$zanr', '$godina', '$trajanje', '$uploadfile')";
			$result_unos = mysql_query($query_unos);
			
			if($result_unos)
			{
				echo 'Podaci uspješno spremljeni.<br />';
			}
			else
			{
				echo '<font color="#FF0000">Greška kod spremanja podataka.</font><br />';
			}
		}
	}
	else
	{
		echo $poruka;
	}
}

//unos novog filma
echo '
<form method="POST" action="unos.php" enctype="multipart/form-data">
	<table border="0">
		<tr>
			<td><b>Naslov:</b></td>
			<td><input type="tekst" name="naslov" value="" /></td>
		</tr>
		<tr>
			<td><b>Žanr:</b></td>
			<td>
				<select name="zanr">';
					$query_zanr = "SELECT * FROM zanr ORDER BY naziv";
					$result_zanr = mysql_query($query_zanr);
					while($zanr = mysql_fetch_array($result_zanr))
					{
						echo '<option value="'.$zanr["id"].'">'.$zanr["naziv"].'</option>';
					}
					echo '
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Godina:</b></td>
			<td>
				<select name="godina">';
					for($i=1900; $i<=date("Y", time()); $i++)
					{
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				echo '
				<select>
			</td>
		</tr>
		<tr>
			<td><b>Trajanje:</b></td>
			<td><input type="tekst" name="trajanje" size="4" value="" /> min</td>
		</tr>
		<tr>
			<td><b>Slika:</b></td>
			<td><input type="file" name="slika" /></td>					
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="btn_unos" value="Spremi" /></td>					
		</tr>
	</table>
</form>';

//prikaz filmova u bazi

echo '
<table border="1">
	<thead>
		<tr bgcolor="#C0C0C0">
			<th><b>Slika</b></th>
			<th width="150"><b>Naslov filma</b></th>
			<th width="100"><b>Godina</b></th>
			<th width="100"><b>Trajanje</b></th>
			<th width="100"><b>Akcija</b></th>
		</tr>
	<thead>
	<tbody>';
		$query_prikaz = "SELECT * FROM filmovi ORDER BY naslov ASC";
		$result_prikaz = mysql_query($query_prikaz);
		if($result_prikaz)
		{
			while($film = mysql_fetch_array($result_prikaz))                                                  
			{
				echo '
				<tr>
					<td align="center"><img src="img/'.$film["slika"].'" height="150" /></td>
					<td align="center">'.$film["naslov"].'</td>
					<td align="center">'.$film["godina"].'.</td>
					<td align="center">'.$film["trajanje"].' min</td>
					<td align="center">[ <a href="unos.php?id='.$film["id"].'&img='.$film["slika"].'&act=delete">obriši</a> ]</td>
				</tr>';
			}		
		}
	echo '
	</tbody>
</table>';

?>