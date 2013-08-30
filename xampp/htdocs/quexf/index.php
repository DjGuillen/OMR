<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="css/demo1.css" />
   <link rel="stylesheet" type="text/css" href="css/style7.css" />
   <link href='http://fonts.googleapis.com/css?family=Terminal+Dosis' rel='stylesheet' type='text/css' />
   <link rel="stylesheet" type="text/css" href="css/jquery.gritter.css" />
   <script type="text/javascript" src="http://www.google.com/jsapi"></script>
   <script type="text/javascript">google.load('jquery', '1.5');</script>
   <script type="text/javascript" src="js/jquery.gritter.min.js"></script>
   <title>OMR</title>
 </head>
	<body>
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

include("functions/functions.xhtml.php");
include("lang.inc.php");
include("db.inc.php");

/*xhtml_head();
xhtml_head(T_("Verify"),true,array("css/demo.css"),array("css/style7.css"));*/
session_start();
	if(isset($_SESSION['username']))
	{
	$_username=$_SESSION['username'];
	}
?>
        <div class="container">
            <div class="header">
            <a href="../index.php?logout=1"><strong>&laquo; Odjavi se</strong></a>
                <span class="right">
                    <a href="#"><strong>LOGOVANI STE KAO: <?php print $_username;?></strong></a>
                </span>
                <div class="clr"></div>
            </div>
<h1><? echo T_("Verifikacija formulara za operatore sistema"); ?></h1>
            <div class="content">
                <ul class="ca-menu">
                    <li>
                        <a href="verifyjs.php">
                            <span class="ca-icon">.</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Verifikacija formulara</h2>
                                <h3 class="ca-sub">Potvrda ili izmjena prepoznavanja koje sistem izvrši</h3>
                            </div>
                        </a>
                    </li>
					<li>
                        <a href="review.php">
                            <span class="ca-icon">q</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Pregled formulara</h2>
                                <h3 class="ca-sub">Prikaz formulara pozivom iz baze podataka</h3>
                            </div>
                        </a>
                    </li>
					<li>
                        <a href="#">
                            <span class="ca-icon">Z</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Dokumentacija</h2>
                                <h3 class="ca-sub">Uputstvo za korištenje programa</h3>
                            </div>
                        </a>
                    </li>
					<li>
                        <a href="postavke.php">
                            <span class="ca-icon">U</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Postavke</h2>
                                <h3 class="ca-sub">Korisničke opcije</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="ca-icon">@</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Poruke</h2>
                                <h3 class="ca-sub">Pošaljite poruku korisnicima sistema</h3>
                            </div>
                        </a>
                    </li>					
                </ul>
            </div><!-- content -->
        </div>
<?php
		$sql = mysql_query("SELECT COUNT(f.done)NbLeft  FROM verifiers v LEFT JOIN verifierquestionnaire w ON v.vid=w.vid LEFT JOIN forms f ON w.qid=f.qid WHERE v.http_username='".$_SESSION['username']."' AND f.done=0");
		$nbleft = mysql_fetch_assoc($sql);
		//echo $nbleft['NbLeft'];
if($nbleft['NbLeft']>0){		
?>
	<form method="post" action="index.php">
		    <input type="hidden" name="nmb" value="<?php print $nbleft['NbLeft'] ?>" id="nmb"/>
	</form>
<script type="text/javascript">
            var number=document.getElementById('nmb').value;
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: 'Broj formulara koji nisu verifikovani: '+number,
				// (string | mandatory) the text inside the notification
				text: 'Otvorite tab za verifikaciju da bi ste mogli verifikovati preostale formulare.',
				// (string | optional) the image to display on the left
				image: 'css/images/icon.png',
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: false,
				// (int | optional) the time you want it to be alive for before fading out
				time: ''
			});
</script>
<?
}
?>
<?
xhtml_foot();

//display list of jobs
//display totals for work done

$sql = "
SELECT w.vid, v.description, w.fid, TIME_TO_SEC( TIMEDIFF( completed, assigned ) ) AS secondstaken, DATE( assigned ) AS dateassigned, f.qid, q.description
FROM worklog AS w, verifiers AS v, forms AS f, questionnaires AS q
WHERE w.vid = v.vid
AND w.fid = f.fid
AND f.qid = q.qid
ORDER BY w.completed
";






?>
