<?php 
/**
 * Modify the call restriction times 
 *
 *
 *	This file is part of queXS
 *	
 *	queXS is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *	
 *	queXS is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *	
 *	You should have received a copy of the GNU General Public License
 *	along with queXS; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 * @author Adam Zammit <adam.zammit@deakin.edu.au>
 * @copyright Deakin University 2007,2008
 * @package queXS
 * @subpackage admin
 * @link http://www.deakin.edu.au/dcarf/ queXS was writen for DCARF - Deakin Computer Assisted Research Facility
 * @license http://opensource.org/licenses/gpl-2.0.php The GNU General Public License (GPL) Version 2
 * 
 */

/**
 * Configuration file
 */
include ("../config.inc.php");

/**
 * Database file
 */
include ("../db.inc.php");

/**
 * XHTML functions
 */
include ("../functions/functions.xhtml.php");

global $db;

$year="2008";
$woy="1";


if (isset($_POST['day']))
{
	$db->StartTrans();
	
	$sql = "DELETE FROM call_restrict
		WHERE 1";

	$db->Execute($sql);
	
	foreach($_POST['day'] as $key => $val)
	{
		if (!empty($val))
		{
			$val = intval($val);
			$key = intval($key);

			$start = $db->qstr($_POST['start'][$key],get_magic_quotes_gpc());
			$end = $db->qstr($_POST['end'][$key],get_magic_quotes_gpc());

			$sql = "INSERT INTO call_restrict (day_of_week,start,end)
				VALUES ('$val',$start,$end)";

			$db->Execute($sql);
		}
	}

	$db->CompleteTrans();
}

xhtml_head(T_("Modify call restriction times"),true,array("../css/shifts.css"),array("../js/addrow-v2.js"));

/**
 * Display warning if timezone data not installed
 *
 */

$sql = "SELECT CONVERT_TZ(NOW(),'Australia/Victoria','UTC') as t";
$rs = $db->GetRow($sql);

if (empty($rs) || !$rs || empty($rs['t']))
	print "<div class='warning'><a href='http://dev.mysql.com/doc/mysql/en/time-zone-support.html'>" . T_("Your database does not have timezones installed, please see here for details") . "</a></div>";


print "<h2>" . T_("Enter the start and end times for each day of the week to restrict calls within") . "</h2>";

/**
 * Begin displaying currently loaded restriction times
 */

$sql = "SELECT DATE_FORMAT( STR_TO_DATE( CONCAT( '$year', ' ', '$woy', ' ', day_of_week -1 ) , '%x %v %w' ) , '%W' ) AS dt,day_of_week,start,end
	FROM call_restrict";	
		
$shifts = $db->GetAll($sql);
translate_array($shifts,array("dt"));	
	
$sql = "SELECT DATE_FORMAT(STR_TO_DATE(CONCAT($year, ' ',$woy,' ',day_of_week - 1),'%x %v %w'), '%W') as description, day_of_week as value, '' as selected 
	FROM day_of_week";
	
$daysofweek = $db->GetAll($sql);
translate_array($daysofweek,array("description"));	
	
?>
	<form method="post" action="">
	<table>
<?php 
	print "<tr><th>" . T_("Day") . "</th><th>" . T_("Start") . "</th><th>" . T_("End") . "</th></tr>";
	$count = 0;
	foreach($shifts as $shift)
	{
		print "<tr id='row-$count' class='row_to_clone'><td>";
		display_chooser($daysofweek, "day[$count]", false, true, false, false, false, array("description",$shift['dt']));
		print "</td><td><input size=\"8\" name=\"start[$count]\" maxlength=\"8\" type=\"text\" value=\"{$shift['start']}\"/></td><td><input name=\"end[$count]\" type=\"text\" size=\"8\" maxlength=\"8\" value=\"{$shift['end']}\"/></td></tr>";
		$count++;
	}
	print "<tr class='row_to_clone' id='row-$count'><td>"; 
	display_chooser($daysofweek, "day[$count]", false, true, false, false, false, false);
	print "</td><td><input size=\"8\" name=\"start[$count]\" maxlength=\"8\" type=\"text\" value=\"00:00:00\"/></td><td><input name=\"end[$count]\" type=\"text\" size=\"8\" maxlength=\"8\" value=\"00:00:00\"/></td></tr>";


?>
	</table>
	<div><a onclick="addRow(); return false;" href="#"><?php  echo T_("Add row"); ?></a></div>
	<p><input type="submit" name="submit" value="<?php  echo T_("Save changes to restriction times"); ?>"/></p>
	</form>
<?php 
	

xhtml_foot();
?>
