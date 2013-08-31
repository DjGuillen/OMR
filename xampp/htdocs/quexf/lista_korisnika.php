<?php
    session_start();
	if(isset($_SESSION['username']))
	{
	$username=$_SESSION['username'];	
	}
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
<h1>Lista korisnika</h1>
<table>
    <tr>
    	<th>Id</th>
    	<th>Korisničko ime</th>
    	<th>Email</th>
    </tr>
<?php
//We get the IDs, usernames and emails of users
$req = mysql_query('select id, username, email from users');
while($dnn = mysql_fetch_array($req))
{
?>
	<tr>
    	<td><?php echo $dnn['id']; ?></td>
    	<td><a href="nova_poruka.php?recip=<?php echo urlencode($dnn['username']); ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
<?php
}
?>
</table>
</div>
</body></html>