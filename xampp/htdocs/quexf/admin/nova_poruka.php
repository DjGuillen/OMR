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
	table{
		margin-right:auto;
		margin-left:auto;
	}
	label{
		float:left;
	}
	input{
		float:right;
	}
	textarea{
		float:right;
	}
	form{
		width: 400px;
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
<?php show_header($username);  ?>
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
$form = true;
$otitle = '';
$orecip = '';
$omessage = '';
//We check if the form has been sent
if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
{
	$otitle = $_POST['title'];
	$orecip = $_POST['recip'];
	$omessage = $_POST['message'];
	//We remove slashes depending on the configuration
	if(get_magic_quotes_gpc())
	{
		$otitle = stripslashes($otitle);
		$orecip = stripslashes($orecip);
		$omessage = stripslashes($omessage);
	}
	//We check if all the fields are filled
	if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
	{
		//We protect the variables
		$title = mysql_real_escape_string($otitle);
		$recip = mysql_real_escape_string($orecip);
		$message = mysql_real_escape_string(nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
		//We check if the recipient exists
		$dn1 = mysql_fetch_array(mysql_query('select count(id) as recip, id as recipid, (select count(*) from pm) as npm from users where username="'.$recip.'"'));
		if($dn1['recip']==1)
		{
			//We check if the recipient is not the actual user
			if($dn1['recipid']!=$_SESSION['userid'])
			{
				$id = $dn1['npm']+1;
				//We send the message
				if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['userid'].'", "'.$dn1['recipid'].'", "'.$message.'", "'.time().'", "yes", "no")'))
				{
?>
<div class="message">Poruka uspješno poslana<br />
<a href="poruke.php">Lista poruka</a></div>
<?php
					$form = false;
				}
				else
				{
					//Otherwise, we say that an error occured
					$error = 'Greška prilikom slanja poruke';
				}
			}
			else
			{
				//Otherwise, we say the user cannot send a message to himself
				$error = 'Ne možete slati poruku samom sebi';
			}
		}
		else
		{
			//Otherwise, we say the recipient does not exists
			$error = 'Primaoc ne postoji';
		}
	}
	else
	{
		//Otherwise, we say a field is empty
		$error = 'Polje je prazno. Morate popuniti sva polja';
	}
}
elseif(isset($_GET['recip']))
{
	//We get the username for the recipient if available
	$orecip = $_GET['recip'];
}
if($form)
{
//We display a message if necessary
if(isset($error))
{
	echo '<div class="message">'.$error.'</div>';
}
//We display the form


?>

<h1>Nova privatna poruka</h1>
    <form action="nova_poruka.php" method="post">
		Popunite formu da pošaljete privatnu poruku.<br />
        <label for="title">Naslov</label><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" /><br />
        <label for="recip">Primaoc<span class="small">(Korisničko ime)</span></label><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" /><br />
        <label for="message">Poruka</label><textarea cols="40" rows="5" id="message" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
        <input type="submit" value="Pošalji" />
    </form>
	<?php
	}
	?>
</div>
</body></html>