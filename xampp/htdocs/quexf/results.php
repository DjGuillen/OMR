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


//verifier

include_once("config.inc.php");
include_once("db.inc.php");

			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Verifier"); ?> - <? print "QID:$qid FID:$fid DESC:$description"; ?></title>
<body>


<?php
//AKO SE RADI O TESTU
//QID IMAMO
$sql1 = mysql_query("SELECT COUNT(s.qid) num  FROM questionnaires q LEFT JOIN subjects s ON q.qid=s.qid WHERE s.qid IS NOT NULL");
		$istest = mysql_fetch_assoc($sql1);

if($istest['num']>0){
//RADI SE O TESTU
$sql2 = mysql_query("SELECT *
                     FROM formboxverifychar f
                     INNER JOIN boxes b ON f.bid = b.bid
                     INNER JOIN boxgroupstype t ON b.bgid = t.bgid
                     WHERE t.varname IS NOT NULL
                     AND f.val IS NOT NULL
                     AND t.width = '24'
                     AND f.fid = '13'
                     AND f.vid = '5'
                     ORDER BY f.bid ASC") or die("Greska u upitu: ".mysql_error());
					 
		while($r = mysql_fetch_array($sql2)){
		
		if(isset($imeprezime))$imeprezime=$imeprezime.$r['val'];
		else $imeprezime="".$r['val'];
		}
//echo $imeprezime;
//echo "</br>";
preg_match_all('/[A-Z][^A-Z]*/', $imeprezime, $results);
$firstname=$results[0][0];
//echo $firstname;
//echo "</br>";
$lastname=$results[0][1];
//echo $lastname;

$sql3=mysql_query("SELECT b.value 
FROM forms f
INNER JOIN formboxverifychar fb ON f.fid = fb.fid
INNER JOIN boxes b ON fb.bid = b.bid
WHERE f.qid='13'
AND fb.val='1'
AND b.value='1'");
$pointsnb=0;

while($p = mysql_fetch_array($sql3)){
$pointsnb=$pointsnb+$p['value'];
}
echo $pointsnb; 
}
		


?>


</body></html>




