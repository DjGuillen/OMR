<?
/*	
	
 */

/**
 * XHTML functions
 */
include ("../functions/functions.xhtml.php");
include ("../lang.inc.php");
include ("../config.inc.php");
include("../../session.php");

xhtml_head(T_("OMR"),true,array("../css/admin.css"));
xhtml_head(T_("OMR"),true,array("../css/demo.css"));
xhtml_head(T_("OMR"),true,array("../css/style6.css"));


?>
		<?php
	session_start();
	if(isset($_SESSION['username']))
	{
		$_username=$_SESSION['username'];
		session_validate();
	if(isset($_SESSION['type'])  && $_SESSION['type'] == "administrator")
	{
		show_header($_username);
	
	?>
	     
<div id="menu">
<p class="p1"><? echo T_("Postavke"); ?></p>


<ul class="bmenu">
<ul><li><a href="?page=adminpostavke.php"><? echo T_("Postavke administratorskog računa"); ?></a></li>
<li><a href="?page=usrpostavke.php"><? echo T_("Postavke korisničkih računa"); ?></a></li>
</ul>
</div>

<?

$page = "adminpostavke.php";

if (isset($_GET['page']))
	$page = $_GET['page'];

print "<div id='main'>";
xhtml_object($page,"mainobj");
print "</div>";
}
else
	{
		print "<h1>Nemate pravo pristupa. Logujte se kao administrator</h1>";
	}
	}
	else
	{
		header("Location:../../index.php");
	}

xhtml_foot();

?>
