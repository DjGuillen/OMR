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
  width:600px;
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


include("../functions/functions.import.php");
include("../functions/functions.xhtml.php");
include("../functions/functions.process.php");

if (isset($_POST['dir']) && isset($_POST['watch']))
{
	$dir = $_POST['dir'];
	//start watching process
	start_process(realpath(dirname(__FILE__) . "/process.php") . " $dir");
}

$p = is_process_running();

if ($p)
{
	if (isset($_GET['kill']))
		kill_process($p);

	if (isset($_GET['force_kill']))
		end_process($p);

	xhtml_head(T_("Import a directory of PDF files"),true,array("../css/table.css"),false,false);

	print "<h1>" . T_("Process") . " $p " . T_("running...") . "</h1>";

	if (is_process_killed($p))
	{
		print "<h3>" . T_("Kill signal sent: Please wait..." ) . "</h3>";
		print "<p><a href='?force_kill'>" . T_("Mark the proces as killed (i.e. when the server is rebooted)"). "</a></p>";
	}
	else
		print "<p><a href='?kill=kill'>" . T_("Kill the running process") . "</a> (" . T_("may take up to a few minutes to take effect") .")</p>";

        $d = process_get_data($p);
        if ($d !== false)
        {
                xhtml_table($d,array('process_log_id','datetime','data'),array(T_("Id unosa"), T_("Datum"), T_("Unos")));
        }

}
else
{
	xhtml_head(T_("Import a directory of PDF files"),true,array("../css/table.css"));

	if (isset($_POST['dir']) && isset($_POST['process']))
	{
		$dir = $_POST['dir'];
		import_directory($dir);
	}

	?>	
	<h1><? echo T_("Folder"); ?></h1>
	<form enctype="multipart/form-data" action="?" method="post">
	<p><? echo T_("Folder na serveru  (npr. /mnt/iss/tmp/images)"); ?>: <input name="dir" type="text" value="<? echo realpath("../doc/filled"); ?>"/></p>
	<p><input name='process' class="submit" id='process' type="submit" value="<? echo T_("Pogledaj u folderu: browser prozor mora ostati otvoren"); ?>" /></p>
	<p><input name='watch' class="submit" id='watch' type="submit" value="<? echo T_("Provjeri folder u pozadini (preporučeno)"); ?>" /></p>
	</form>
	<?

	print "</br><p>" . T_("Ishod zadnjeg prrocesa (ako postoji)") . "</p>";
	
	$d = process_get_last_data(1);
	if ($d !== false)
        {
                xhtml_table($d,array('process_log_id','datetime','data'),array(T_("Id unosa"), T_("Datum"), T_("Unos")));
        }

}
xhtml_foot();
?>
