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

/**
 * XHTML functions
 */
include ("../functions/functions.xhtml.php");
include ("../lang.inc.php");
include ("../config.inc.php");

xhtml_head(T_("OMR"),true,array("../css/admin.css"));
xhtml_head(T_("OMR"),true,array("../css/demo.css"));
xhtml_head(T_("OMR"),true,array("../css/style6.css"));


?>
		<?php
	session_start();
	if(isset($_SESSION['username']))
	{
	$_username=$_SESSION['username'];
	}
	?>
	     <div class="header">
          <a href="../../index.php?logout=1"><strong>&laquo; Odjavi se</strong></a>
                <span class="right">
                    <a href="#"><strong>LOGOVANI STE KAO: <?php print $_username;?></strong></a>
                </span>
                <div class="clr"></div>
            </div>
<div id="menu">
<p class="p1"><? echo T_("Administratorske opcije"); ?></p>
<ul>
<li><p><? echo T_("Formular"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=pagetest.php"><? echo T_("Test kompabitilnosti formulara"); ?></a></li>
<li><a href="?page=new.php"><? echo T_("Dodavanje formulara"); ?></a></li>
<!--<li><a href="?page=importbandingxml.php"><? //echo T_("Import/Update banding from XML"); ?></a></li>-->
<li><a href="?page=delete.php"><? echo T_("Brisanje formulara"); ?></a></li>
<!--<li><a href="?page=touchup.php"><? //echo T_("Touch-up a form"); ?></a></li>-->
<li><a href="?page=band.php"><? echo T_("Postavke formulara"); ?></a></li>
<li><a href="?page=bandajax.php"><? echo T_("Interaktivne postavke"); ?></a></li>
<li><a href="?page=reorder.php"><? echo T_("Varijable formulara"); ?></a></li>
<!--<li><a href="?page=limesurvey.php"><? //echo T_("queXS and Limesurvey integration"); ?></a></li>-->
</ul></li>
</ul>
<li><p><? echo T_("Testovi"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=subjects.php"><? echo T_("Dodavanje predmeta"); ?></a></li>
<li><a href="?page=students.php"><? echo T_("Dodavanje studenata"); ?></a></li>
<li><a href="../results.php"><? echo T_("Ispis rezultata"); ?></a></li>
</ul></li>
</ul>
<li><p><? echo T_("Korisnici"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=../../quexf/admin/operators.php"><? echo T_("Dodavanje operatora"); ?></a></li>
<li><a href="?page=verifierquestionnaire.php"><? echo T_("Dodjeljivanje formulara"); ?></a></li></ul></li>
</ul>
<? if (ICR_ENABLED) { ?>
<!--<li><p><? echo T_("ICR"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=icrtrain.php"><? echo T_("Trening ICR"); ?></a></li>
<li><a href="?page=icrmonitor.php"><? echo T_("Monitoring ICR trening procesa"); ?></a></li>
<li><a href="?page=icrkb.php"><? echo T_("Unos i export ICR KB"); ?></a></li>
<li><a href="?page=icrassign.php"><? echo T_("Dodjeljivanje ICR KB"); ?></a></li></ul></li>
<? } ?>
</ul>-->
<li><p><? echo T_("Dodavanje"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=import.directory.php"><? echo T_("Dodavanje skeniranih formulara"); ?></a></li>
<li><a href="?page=listfiles.php?status=1"><? echo T_("Prikaz formulara"); ?></a></li>
<li><a href="?page=listfiles.php?status=2"><? echo T_("Prikaz gresaka"); ?></a></li>
<li><a href="?page=listduplicates.php"><? echo T_("Prikaz duplikata"); ?></a></li>
<li><a href="?page=listforms.php"><? echo T_("Ponovna verifikacija"); ?></a></li>
<li><a href="?page=listpagenotes.php"><? echo T_("List page notes"); ?></a></li>
<!--<li><a href="?page=pagesmissing.php"><? //echo T_("Pages missing from scan"); ?></a></li>-->
<!--<li><a href="?page=missingpages.php"><? //echo T_("Handle undetected pages"); ?></a></li></ul></li>-->
<!--<li><h3><? //echo T_("Output"); ?></h3>-->
<!--<ul><li><a href="?page=outputunverified.php"><? //echo T_("Output unverified data"); ?></a></li>-->
<!--<li><a href="?page=output.php"><? //echo T_("Output data/ddi"); ?></a></li>-->
</ul></li>
</ul>
<li><p><? echo T_("Progres"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=progress.php"><? echo T_("Prikaz progresa"); ?></a></li>
<li><a href="?page=performance.php"><? echo T_("Prikaz performansi"); ?></a></li></ul></li>
</ul>
<li><p><? echo T_("Klijenti"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=../../quexs/admin/clients.php"><? echo T_("Dodavanje klijenata"); ?></a></li>
<li><a href="?page=clientquestionnaire.php"><? echo T_("Dodjeljivanje formulara"); ?></a></li></ul></li>
</ul>
<li><p><? echo T_("Sistemske postavke"); ?></p>
<ul class="bmenu">
<ul><li><a href="?page=pagesetup.php"><? echo T_("Postavke stranice"); ?></a></li>
<li><a href="?page=testconfig.php"><? echo T_("Test konfiguracije"); ?></a></li></ul></li>
</ul></ul>
</div>
<?

$page = "testconfig.php";

if (isset($_GET['page']))
	$page = $_GET['page'];

print "<div id='main'>";
xhtml_object($page,"mainobj");
print "</div>";


xhtml_foot();

?>
