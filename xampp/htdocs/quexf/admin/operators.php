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

xhtml_head(T_("Add an operator"),true,array("../css/style5.css"),array("../css/table1.css"));

if (isset($_POST['operator']) && isset($_POST['d']) && isset($_POST['p']))
{
    $password=$db->qstr(sha1($_POST['p']),get_magic_quotes_gpc());
	$operator = $db->qstr($_POST['operator'],get_magic_quotes_gpc());
	$d = $db->qstr($_POST['d'],get_magic_quotes_gpc());
	if ($d == "") $d = $operator;
	if (!empty($_POST['operator']))
	{
		$sql = "INSERT INTO verifiers
			(`vid` ,`description` ,`currentfid` ,`http_username`)
			VALUES (NULL , $d, NULL , $operator);";
			
		$sql1 = "INSERT INTO users
			(`id` ,`username` ,`password` ,`email` ,`type`)
			VALUES (NULL , $operator, $password, NULL , 'operator');";	
	
		if ($db->Execute($sql) && $db->Execute($sql1))
		{
			$a = T_("Added") . ": $operator";	
		}else
		{
			$a = T_("Could not add") . " $operator.". T_("There may already be an operator of this name");
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
<h1><? echo T_("Dodajte novog operatora"); ?></h1>
<form enctype="multipart/form-data" action="" method="post">
<table>
<tr>
<td><p><? echo T_("Unesite korisničko ime:"); ?></p></td>
<td><p><input name="operator" type="text"/></p></td>
</tr>
<tr>
<td><p><? echo T_("Unesite lozinku:"); ?></p></td>
<td><p><input name="p" type="password"/></p></td>
</tr>
<tr>
<td><p><? echo T_("Unesite ime operatora:"); ?></p></td> 
<td><p><input name="d" type="text"/></p></td>
</tr>
</table>
<p><input type="submit" value="<? echo T_("Dodaj operatora"); ?>" class="upl1"/></p>
</form>
</body>
</html>
