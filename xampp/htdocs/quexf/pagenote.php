<?

/*	Copyright Australian Consortium for Social and Political Research Incorporated (ACSPRI) 2009
 *	Written by Adam Zammit - adam.zammit@acspri.org.au
 *	For ACSPRI: http://www.acspri.org.au/
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

if (isset($_GET['pid'])){

	include_once("config.inc.php");
	include_once("db.inc.php");
	
	global $db;

	$pid = intval($_GET['pid']);
	$vid = intval($_GET['vid']);
	$fid = intval($_GET['fid']);

	if (isset($_GET['submit']))
	{
		$note = $db->qstr($_GET['pagenote']);
		
		$sql = "INSERT INTO formpagenote (fpnid,fid,pid,vid,note)
			VALUES (NULL,'$fid','$pid','$vid',$note)";
		
		$db->Execute($sql);
	}

	
	$sql = "SELECT note
		FROM formpagenote
		WHERE pid = '$pid'
		AND fid = '$fid'";

	$rs = $db->GetAll($sql);

	foreach($rs as $r)
	{
		print "<div>" . $r['note'] . "</div>";
	}

	print "<form action='?' method='get'>";
	print "<p class='p2'><label for='pagenote'>" . T_("Napomena:") . "</br></label>";
	print "<input type='text' name='pagenote' id='pagenote'>";
	print "<input type='hidden' name='vid' value='$vid'/>";
	print "<input type='hidden' name='pid' value='$pid'/>";
	print "<input type='hidden' name='fid' value='$fid'/>";
	print "<input type='submit' value='" . T_("Dodaj") . "' name='submit' id='submit'/></p>";
	print "</form>";

}

?>
<style type="text/css">
@font-face {
  font-family: 'NotethisRegular';
  src: url('../css/fonts/Note_this.eot');
  src: local('Note this Regular'), local('Notethis'), url('../css/fonts/Note_this.ttf') format('truetype');
}
.p2{
font-family:sans-serif;
margin-left:5%;
font-size: 16px;
color:#FFFFFF;
}

#submit {
  /* General Properties */
  height:30px;
  width:100px;
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
  font-size:20px;
  padding-top:1px;
}
  
#submit:hover, input#upl:focus {
  background:-moz-radial-gradient(bottom, #656565, #404040 80%);
  background:-webkit-gradient(radial, center bottom, 0, center 230, 250, from(#656565), to(#404040));
}

#submit:active {
  -moz-box-shadow:0px 0px 2px #000;
  -webkit-box-shadow:0px 0px 2px #000;
  box-shadow:0px 0px 2px #000;
  text-shadow:0px 0px 8px rgba(255, 255,255, 1);
}


</style>