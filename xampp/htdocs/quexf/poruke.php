<?php
    include("../session.php");
	session_start();
	if(isset($_SESSION['username']))
	{
		$username=$_SESSION['username'];
		session_validate();
	if(isset($_SESSION['type'])  && $_SESSION['type'] == "operator")
	{
	include_once("db.inc.php");
	include("functions/functions.xhtml.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Poruke"); ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" type="text/css" href="css/demo1.css" />
   <link rel="stylesheet" type="text/css" href="css/table.css" />
   <link rel="stylesheet" type="text/css" href="css/style6.css" />
   <style>
	body{
		overflow: hidden; 
	}
	table{
		margin-right:auto;
		margin-left:auto;
	}
	.side{
		margin-bottom: -5000px; 
		padding-bottom: 5000px; 
		width:200px;
		float:left;
		border-right: 2px solid #211E1F;
		-moz-box-shadow: 0 1px 2px #d1d1d1;
		-webkit-box-shadow: 0 1px 2px #d1d1d1;
		box-shadow: 0 1px 2px #d1d1d1;
	}
	.sadrzaj{
		margin-left:200px;
		top:0px;
		float:left;
		width:600px;
	}
   </style>
</head>
<body>
<?php show_header_operator($username); ?>
<div>
<div class="side">
<li><p>Opcije poruka</p>
<ul class="bmenu">
<ul><li><a href="poruke.php">Sve poruke</a></li>
<li><a href="lista_korisnika.php">Lista korisnika</a></li>
<li><a href="nova_poruka.php">Nova poruka</a></li>
</ul></li>
</ul>
</div>
<div class="sadrzaj">
<?php
	$req1 = mysql_query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
	$req2 = mysql_query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
?>
<h1>Lista poruka:</h1>
<a href="nova_poruka.php">Nova poruka</a><br />
<h3>Nepročitane poruke(<?php echo intval(mysql_num_rows($req1)); ?>):</h3>
<table>
	<tr>
    	<th>Naslov</th>
        <th>Broj odgovora</th>
        <th>Učesnik</th>
        <th>Datum kreiranja</th>
    </tr>
<?php
//We display the list of unread messages
while($dn1 = mysql_fetch_array($req1))
{
?>
	<tr>
    	<td><a href="citaj.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['reps']-1; ?></td>
    	<td><a href="nova_poruka.php?recip=<?php echo urlencode($dn1['username']); ?>"><?php echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('Y/m/d H:i:s' ,$dn1['timestamp']); ?></td>
    </tr>
<?php
}
//If there is no unread message we notice it
if(intval(mysql_num_rows($req1))==0)
{
?>
	<tr>
    	<td colspan="4">Nemate nepročitanih poruka.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Pročitane poruke(<?php echo intval(mysql_num_rows($req2)); ?>):</h3>
<table>
	<tr>
    	<th>Naslov</th>
        <th>Broj odgovora</th>
        <th>Učesnik</th>
        <th>Datum kreiranja</th>
    </tr>
<?php
//We display the list of read messages
while($dn2 = mysql_fetch_array($req2))
{
?>
	<tr>
    	<td><a href="citaj.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn2['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo htmlentities($dn2['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('Y/m/d H:i:s' ,$dn2['timestamp']); ?></td>
    </tr>
<?php
}
//If there is no read message we notice it
if(intval(mysql_num_rows($req2))==0)
{
?>
	<tr>
    	<td colspan="4">Nemate pročitanih poruka.</td>
    </tr>
<?php
}
?>
</table>
</div>
</div>
<?php
}
else
	{
		print "<h1>Nemate pravo pristupa. Logujte se kao operator</h1>";
	}
	}
	else
	{
		header("Location:../index.php");
	}
?>
</body></html>