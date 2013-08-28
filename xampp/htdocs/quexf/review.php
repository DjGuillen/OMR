<?
    session_start();
	if(isset($_SESSION['username']))
	{
	$username=$_SESSION['username'];	
	}
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


include_once("config.inc.php");
include_once("db.inc.php");
include_once("functions/functions.database.php");
				
global $db;


$fid = "";
$pid = "";
$var = "";

if (isset($_GET['fid']))
{
	$fid = $_GET['fid'];
}


$q = get_qid_description($fid);

if (!isset($q['qid']))
	$qid = "";
else
	$qid = $q['qid'];

if (isset($_GET['pid']))
{
	$pid = intval($_GET['pid']);
}

if (isset($_GET['var']))
{
	$var = $_GET['var'];
	$vars = $db->qstr($_GET['var']);

	$sql = "SELECT b.pid
		FROM boxes as b, pages as p
		WHERE b.varname LIKE $vars
		AND p.pid = b.pid
		AND p.qid = '$qid'";

	$v = $db->GetRow($sql);
	
	if (isset($v['pid']))
	{
		$pid = $v['pid'];
	}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Review Form"); ?> - <? print "FID:$fid"; ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="css/demo1.css" />
<style type="text/css">
@font-face {
  font-family: 'NotethisRegular';
  src: url('../css/fonts/Note_this.eot');
  src: local('Note this Regular'), local('Notethis'), url('../css/fonts/Note_this.ttf') format('truetype');
}
.p2{
font-family:sans-serif;
font-size: 16px;
color:#FFFFFF;
}
td {
text-align:left;
width: 15%
}
.dd{
margin-left:10%;
margin-top:15%;
width:350px;
}
.ppl {
  /* General Properties */
  height:30px;
  width:150px;
  margin-left:5%;
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
  
.ppl:hover, input#upl:focus {
  background:-moz-radial-gradient(bottom, #656565, #404040 80%);
  background:-webkit-gradient(radial, center bottom, 0, center 230, 250, from(#656565), to(#404040));
}

.ppl:active {
  -moz-box-shadow:0px 0px 2px #000;
  -webkit-box-shadow:0px 0px 2px #000;
  box-shadow:0px 0px 2px #000;
  text-shadow:0px 0px 8px rgba(255, 255,255, 1);
}
#topper {
background: #999966;
  position : fixed;
  width : 100%;
  height : 5%;
  top : 0;
  right : 0;
  bottom : auto;
  left : 0;
  border-bottom : 2px solid #cccccc;
  overflow : auto;
	text-align:center;
}

#header {
  position : fixed;
  width : 22%;
  height : 95%;
  top : 5%;
  right : 0;
  bottom : auto;
  left : 0;
  border-bottom : 2px solid #cccccc;
  overflow : auto;
}
#content {
  position : fixed;
  top : 5%;
  left : 5%;
  bottom : auto;
  width : 85%;
  height : 100%;
  color : #000000;
  overflow : auto;
}

</style>
</head>
<body>
        <div class="container">
            <div class="header">
            <a href="../index.php?logout=1"><strong>&laquo; Odjavi se</strong></a>
                <span class="right">
                    <a href="#"><strong>LOGOVANI STE KAO: <?php print $username;?></strong></a>
                </span>
                <div class="clr"></div>
            </div>



<?



//show content
print "<div id=\"content\">";
	print "<div class='p2' style=\"position:relative;\"><img src=\"showpage.php?pid=$pid&amp;fid=$fid\" style=\"width:800px;\" alt=\"Slika stranice $pid, formular $fid\" />";
print "</div></div>";

//show list of bgid for this fid
print "<div id=\"header\">";

?>

	<form action="" method="get">
	<div class='dd'>
	<?php print "<p class='p2'>F:$fid</p>" ?>
	<table>
	<tr>
	<td><p class='p2'>Formular :</p></td>
	<td><input type="text" size="5" name="fid" value="<? echo $fid ?>"/></td>
	</tr>
	<tr>
	<td><p class='p2'>Varijabla :</p></td>
	<td><input type="text" size="9" name="var" value="<? echo $var ?>"/></td>
	</tr>
	<tr>
	<td><p class='p2'>Stranica :</p></td> 
	<td><input type="text" size="4" name="pid" value="<? echo $pid ?>"/></td>
	</tr>
	</table>
	</br>
	<input type="submit" value="Pošalji upit" class='ppl'/></div>
	</form>

<?

	/*
	foreach($_SESSION['boxgroups'] as $key => $val)
	{
		if ($val['pid'] == $pid)
		{
			//if ($bgid == $key)
				print "<strong>{$val['varname']}</strong><br/>";
			//else
			//	print "<a id=\"link$key\" href=\"" . $_SERVER['PHP_SELF'] . "?bgid=$key&amp;fid=$fid#boxGroup\">{$val['varname']}</a><br/>";
		}	
	}*/
	
print "</div>";

//show list of pid for this fid
	print "<div id=\"topper\">";

	$count = 1;	

	$sql = "SELECT pid
		FROM pages
		WHERE qid = '$qid'
		ORDER BY pidentifierval ASC";

	$pages = $db->GetAll($sql);
	

	foreach($pages as $page)
	{
		$p = $page['pid'];

		if ($pid == $p)
			print "<strong>$count</strong>";
		else
			print " <a href=\"" . $_SERVER['PHP_SELF'] . "?pid=$p&amp;fid=$fid\">$count</a> ";
		$count++;

	}
	
print "</div>";




?>


</body></html>




