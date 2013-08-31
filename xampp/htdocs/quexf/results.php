<?



//verifier

include_once("config.inc.php");
include_once("db.inc.php");

global $db;			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Rezultati"); ?></title>
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




