<?

/*	Copyright Deakin University 2007,2008
 *	Written by Adam Zammit - adam.zammit@deakin.edu.au
 *	For the Deakin Computer Assisted Research Facility: http://www.deakin.edu.au/dcarf/
 *	
 *	This file is part of queXF
 *	
 *	queXF is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *	
 *	queXF is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *	
 *	You should have received a copy of the GNU General Public License
 *	along with queXF; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

include_once("../config.inc.php");
include_once("../db.inc.php");
include('../functions/functions.xhtml.php');
include('../functions/functions.import.php');

xhtml_head(T_("Add new questionnaire"),true,array("../css/style5.css"),array("../js/checkbox.js"));

$a = false;

if (isset($_FILES['form']))
{
	$a = true;
	$filename = $_FILES['form']['tmp_name'];
	$desc = $_POST['desc'];

	$r = newquestionnaire($filename,$desc);
	
	if (!is_array($r) && isset($_FILES['bandingxml']) && !empty($_FILES['bandingxml']['tmp_name']))
	{
		$xmlname = $_FILES['bandingxml']['tmp_name'];
		$r2 =  import_bandingxml(file_get_contents($xmlname),$r);
	}
}


if ($a)
{
	$suc = false;
	if (!is_array($r))
	{
		print "<h1>" . T_("Novi formular je uspješno dodan") . "</h1>";
		$suc = true;
		if (isset($r2))
		{
			if ($r2)
			{
				print "<h2>" . T_("XML file je uspješno dodan") . "</h2>";
			}
			else
			{
				print "<h2>" . T_("Greška u dodavanju XML file-a") . "</h2>";
				$suc = false;
			}
		}
		if ($suc == true)
		{
			print "<div><a href='pagesetup.php?qid=$r'>" . T_("Nastavite sa postavkama detekcije ivica (Postavke stranice)") . "</a></div>";
			xhtml_foot();
			die();
		}
	}
	else
	{
		print "<h1>" . T_("Greška pri dodavanju novog formulara. Provjerite id formulara .") . "</h1>";
		print "<p><a href='pagetest.php?filename=" . $r[1] . "'>" . T_("Testirajte kompatibilnost forme za detekciju grešaka") . "</a></p>";
	}


}

print "<h1>" . T_("Novi formular") . "</h1>";
print "<h2>" . T_("Kada koristite XML file sa postavkama:") . "</h2>";
print "<p>" . T_("Morate dodati PDF file sa XML file-om koji sadrži postavke (ne skeniranu verziju)") . "</p>";
print "<h2>" . T_("Kada koristite manuelne postavke:") . "</h2>";
print "<p>" . T_("Najbolje rezultate postižete ako:") . "</p>";
print "<ul><li>" . T_("Printate formular sa metodom koju ste koristili za generisane formulare") . "</li>";
print "<li>" . T_("Skenirate formular i spasite ga kao PDF file") . "</li>";
print "<li>" . T_("Preporučene opcije za skeniranje:");
print "<ul><li>" . T_("Monochrome (1 bit)") . "</li>";
print "<li>" . T_("300DPI Resolution") . "</li></ul></li></ul>";

?>

<form enctype="multipart/form-data" action="" method="post">
	<p><input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /></p>
	<p><? echo T_("Odaberite PDF file na osnovu kojeg želite kreirati fomular"); ?>: <input name="form" type="file" class="br"/></p>
	<p><? echo T_("(Neobavezno): Odaberite XML file sa postavkama"); ?>: <input name="bandingxml" type="file" class="br"/></p>	
<!--Učitavanje liste predmeta iz baze -->
<p><input type="checkbox" name="test" value="test" id="test">Formular koji želite dodati predstavlja test<br></p>
<?php
$sql="SELECT * FROM subjects ORDER BY name ASC";
$result=mysql_query($sql);
?>
<div id="subject" style="display:none" name="subject">
<p>Odaberite predmet za test koji želite dodati:<br/></p>
<select name="subject" >
<?php
while($rows=mysql_fetch_array($result)){
?>
<option value="<?php echo $rows['name'] ?>"><?php echo $rows['name'] ?></option>
<?php
}
 mysql_free_result($result);
?>

</select>
</div>
<!-- end-->
	<p><? echo T_("Opis forme"); ?>: <input name="desc" type="text"/><br/></p>
	<p><input type="submit" value="<? echo T_("Upload form"); ?>" class="upl"/></p>
</form>

<?

xhtml_foot();
?>
