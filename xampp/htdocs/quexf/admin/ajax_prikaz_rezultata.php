<?php
if(isset($_GET['sid']) && isset($_GET['qid']))
{
	include_once("../config.inc.php");
	include_once("../db.inc.php");
	$sid = $_GET['sid'];
	$qid = $_GET['qid'];
	global $db;	
	$result = $db->GetAll("select q.description as d, ss.fname n, ss.lname as l, r.points as points from results r, questionnaires q, students ss, subjects s where r.sid=".$sid." 
							and r.sid = s.id
							and r.ssid = ss.id
							and q.qid = ".$qid.";");
							
	?>
		<table>
		<tr><th>Naziv testa</th><th>Ime studenta</th><th>Prezime studenta</th><th>Broj bodova</th></tr>
		<?php foreach($result as $row)
		{
			print "<tr><td>".$row['d']."</td><td>".$row['n']."</td><td>".$row['l']."</td><td>".$row['points']."</td></tr>";
		}
		?>
		</table>
	<?php
}	
if(isset($_GET['id']))
{
	include_once("../config.inc.php");
	include_once("../db.inc.php");
	$id = $_GET['id'];
	global $db;	
	$result = $db->GetAll("select q.qid as qid, q.description as description from questionnaires q, subjects s where s.id = ".$id." and s.qid = q.qid"); 
	print "<option value ='default' >Odabrite test</option>";
	foreach($result as $row)
	{
		print "<option value ='".$row['qid']."' >".$row['description']."</option>";
	}
}
?>