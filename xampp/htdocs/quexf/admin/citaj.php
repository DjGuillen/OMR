<?php
    session_start();
	if(isset($_SESSION['username']))
	{
	$username=$_SESSION['username'];	
	}
	include_once("../db.inc.php");
	include("../functions/functions.xhtml.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Poruke"); ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" type="text/css" href="../css/demo.css" />
   <link rel="stylesheet" type="text/css" href="../css/table.css" />
   <link rel="stylesheet" type="text/css" href="../css/style6.css" />
   <style>
	body{
		overflow: hidden; 
	}
	table{
		margin-right:auto;
		margin-left:auto;
		width:600px;
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
	form{
		width:300px;
		margin-right:auto;
		margin-left:auto;
	}
	h2{
		width:30px;
		margin-right:auto;
		margin-left:auto;
	}
   </style>
</head>
<body>
<?php show_header($username); ?>
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
//We check if the user is logged
if(isset($_SESSION['username']))
{
//We check if the ID of the discussion is defined
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
//We get the title and the narators of the discussion
$req1 = mysql_query('select title, user1, user2 from pm where id="'.$id.'" and id2="1"');
$dn1 = mysql_fetch_array($req1);
//We check if the discussion exists
if(mysql_num_rows($req1)==1)
{
//We check if the user have the right to read this discussion
if($dn1['user1']==$_SESSION['userid'] or $dn1['user2']==$_SESSION['userid'])
{
//The discussion will be placed in read messages
if($dn1['user1']==$_SESSION['userid'])
{
	mysql_query('update pm set user1read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 2;
}
else
{
	mysql_query('update pm set user2read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 1;
}
//We get the list of the messages
$req2 = mysql_query('select pm.timestamp, pm.message, users.id as userid, users.username from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2');
//We check if the form has been sent
if(isset($_POST['message']) and $_POST['message']!='')
{
	$message = $_POST['message'];
	//We remove slashes depending on the configuration
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	//We protect the variables
	$message = mysql_real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
	//We send the message and we change the status of the discussion to unread for the recipient
	if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.(intval(mysql_num_rows($req2))+1).'", "", "'.$_SESSION['userid'].'", "", "'.$message.'", "'.time().'", "", "")') and mysql_query('update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"'))
	{
?>
<div class="message">Poruka uspješno poslana<br />
<a href="citaj.php?id=<?php echo $id; ?>">Idi na diskuiju</a></div>
<?php
	}
	else
	{
?>
<div class="message">Došlo je do greške<br />
<a href="citaj.php?id=<?php echo $id; ?>">Idi na diskuiju</a></div>
<?php
	}
}
else
{
//We display the messages
?>
<div class="content">
<h1><?php echo $dn1['title']; ?></h1>
<table class="messages_table">
	<tr>
    	<th class="author">Korisnik</th>
        <th>Poruka</th>
    </tr>
<?php
while($dn2 = mysql_fetch_array($req2))
{
?>
	<tr>
    	<td class="author center">
<br /><a href="nova_poruka.php?recip=<?php echo urlencode($dn2['username']);?>"><?php echo $dn2['username']; ?></a></td>
    	<td class="left"><div class="date">Poslano: <?php echo date('m/d/Y H:i:s' ,$dn2['timestamp']); ?></div>
    	<?php echo $dn2['message']; ?></td>
    </tr>
<?php
}
//We display the reply form
?>
</table><br />
<h2>Odgovor</h2>
<div class="center">
    <form action="citaj.php?id=<?php echo $id; ?>" method="post">
    	<label for="message" class="center">Poruka</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Pošalji" />
    </form>
</div>
</div>
<?php
}
}
else
{
	echo '<div class="message">You dont have the rights to access this page.</div>';
}
}
else
{
	echo '<div class="message">This discussion does not exists.</div>';
}
}
else
{
	echo '<div class="message">The discussion ID is not defined.</div>';
}
}
?>
</div>
</div>
</body></html>