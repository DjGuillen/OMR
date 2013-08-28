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
include_once("../functions/functions.xhtml.php");

global $db;

$a = false;

xhtml_head(T_("OMR"),true,array("../css/style5.css"),array("../css/table1.css"));

if (isset($_POST['indexnb']))
{
    $fname = $db->qstr($_POST['fname'],get_magic_quotes_gpc());
	$lname = $db->qstr($_POST['lname'],get_magic_quotes_gpc());
	$indexnb = $db->qstr($_POST['indexnb'],get_magic_quotes_gpc());
	
	if (!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['indexnb']))
	{
		$sql = "INSERT INTO students
			(`id` ,`fname` ,`lname`,`indexnb`)
			VALUES (NULL , $fname, $lname, $indexnb);";
	
		if ($db->Execute($sql))
		{
			$a = T_("Student ") . ": $fname $lname ".T_(" uspješno dodan!");	
		}else
		{
			$a = T_("Greška pri dodavanju studenta: ") . " $fname $lname .". T_(" Moguće je da taj broj indexa već postoji!");
		}
	}
}

if ($a)
{
?>
	<h3><? echo $a; ?></h3>
<?
}
?>
<h1><? echo T_("Dodajte novog studenta"); ?></h1>
<form enctype="multipart/form-data" action="" method="post">
<table>
<tr>
<td><p><? echo T_("Unesite ime studenta:"); ?></p></td>
<td><p><input name="fname" type="text"/></p></td>
</tr>
<tr>
<td><p><? echo T_("Unesite prezime studenta:"); ?></p></td>
<td><p><input name="lname" type="text"/></p></td>
</tr>
<tr>
<td><p><? echo T_("Unesite broj indexa studenta:"); ?></p></td>
<td><p><input name="indexnb" type="text"/></p></td>
</tr>
</table>
<p><input type="submit" value="<? echo T_("Dodaj studenta"); ?>" class="upl1"/></p>
</form>
</body>
</html>
