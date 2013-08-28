<?
print"<style type='text/css'>
@font-face {
  font-family: 'NotethisRegular';
  src: url('../../css/fonts/Note_this.eot');
  src: local('Note this Regular'), local('Notethis'), url('../../css/fonts/Note_this.ttf') format('truetype');
}
body{
color: 	#E0E0E0 ;
font-family:sans-serif;
}
p{
font-size:18px;
font-family:sans-serif;
}
h1{
font-family:'NotethisRegular', Verdana, Arial, sans-serif;
color:#000000;
}
h2{
font-family:sans-serif;
}
.submit {
  /* General Properties */
  height:34px;
  width:270px;
  border:1px solid #494949;
  background:#404040;
  /* CSS3 Styling */
  background:-moz-radial-gradient(bottom, #656565, #404040 60%);
  background:-webkit-gradient(radial, center bottom, 0, center 230, 230, from(#656565), to(#404040));
  -moz-border-radius:3px;
  -webkit-border-radius:3px;
  border-radius:3px;
  -moz-box-shadow:0px 0px 3px #000;
  -webkit-box-shadow:0px 0px 3px #000;
  box-shadow:0px 0px 3px #000;
  /* Text Styling */
  color:#fff;
  text-shadow:0px 0px 5px rgba(255, 255,255, 0.5);
  font-family:'NotethisRegular', Verdana, Arial, sans-serif;
  font-size:24px;
  padding-top:1px;
  margin-left:1.5%;
}
  
.submit:hover, input#upl:focus {
  background:-moz-radial-gradient(bottom, #656565, #404040 80%);
  background:-webkit-gradient(radial, center bottom, 0, center 230, 250, from(#656565), to(#404040));
}

.submit:active {
  -moz-box-shadow:0px 0px 2px #000;
  -webkit-box-shadow:0px 0px 2px #000;
  box-shadow:0px 0px 2px #000;
  text-shadow:0px 0px 8px rgba(255, 255,255, 1);
}
</style>";
/*	Copyright Deakin University 2007,2008,2009
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
include("../functions/functions.database.php");
include("../functions/functions.xhtml.php");

if (isset($_POST['submit']))
{
	//submitted, now update database
	foreach($_POST as $key => $val)
	{
		if (substr($key,0,4) == 'pfid')
		{
			$key = intval(substr($key,4));
			$val = intval($val);
			$sql = "UPDATE processforms
				SET allowanother = '$val'
				WHERE pfid = '$key'";
			$db->Execute($sql);
		}

	}
}

xhtml_head(T_("Listing of imported files by status"),true,array("../css/table.css"));

$status = 1;
if (isset($_GET['status'])) $status = intval($_GET['status']);
if (isset($_POST['status'])) $status = intval($_POST['status']);

if ($status == 1)
	print "<h1>" . T_("Lista dodanih formulara") . "</h1>";
if ($status == 2)
	print "<h1>" . T_("Formulari koji nisu dodani") . "</h1>";

$sql = "SELECT pfid,filepath,filehash,date,status, CONCAT('<input type=\'radio\' value=\'1\' name=\'pfid', pfid, '\' ', CASE WHEN allowanother = '1' THEN 'checked=\'checked\'' ELSE '' END, '/> Yes <input type=\'radio\' value=\'0\' name=\'pfid', pfid, '\' ', CASE WHEN allowanother = '0' THEN 'checked=\'checked\'' ELSE '' END, '/> No') as allowanother
	FROM processforms
	WHERE status = $status
	ORDER BY date ASC";

$fs = $db->GetAll($sql);

print "<form method='post' action=''>";

xhtml_table($fs,array('filepath','filehash','date','allowanother'),array(T_('File'),T_('SHA1'),T_('Datum'),T_('Dozvoli ponovni unos?')));

print "<p><input name='status' type='hidden' id='status' value='$status'/><input class='submit' name='submit' type='submit' value='" . T_("Spasi promjene") . "'/></p></form>";

xhtml_foot();

?>
