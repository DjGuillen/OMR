<?php
    session_start();
	if(isset($_SESSION['username']))
	{
	$username=$_SESSION['username'];	
	}


include_once("config.inc.php");
include_once("db.inc.php");
include_once("functions/functions.database.php");
include("functions/functions.xhtml.php");
				
global $db;

$info = $db->GetRow("select * from users where username = '".mysql_real_escape_string($username)."';");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Review Form"); ?> - <? print "FID:$fid"; ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="css/demo1.css" />
<style type="text/css">
@font-face {
  font-family: 'NotethisRegular';
  src: url('../css/fonts/Note_this.eot');
  src: local('Note this Regular'), local('Notethis'), url('../css/fonts/Note_this.ttf') format('truetype');
}
.p2{
font-family:sans-serif;
font-size: 16px;
color:#FFFFFF;
}

#header {
  position : relative;
  width : 22%;
  height : 95%;
  right : 0;
  bottom : auto;
  left : 0;
  border-bottom : 2px solid #cccccc;
  overflow : auto;
}
body{
margin:0px;
}

form{
	margin-left:auto;
	margin-right:auto;
	width: 500px;
}

#container{
	padding:20px;
}

#prikaz{
	margin-top:50px;
	width: 70%;
	margin-left:auto;
	margin-right:auto;
	text-align:center;
}

hr{
	margin-bottom:50px;
}

.p1{
font-family:'NotethisRegular', Verdana, Arial, sans-serif;
font-size: 35px;
color:#FFFFFF;
text-shadow:1px 1px 1px #6E6E6E;
margin-bottom:0px;
}
.p2{
color:#FFFFFF;
text-shadow:1px 1px 1px #6E6E6E;
margin-top:5px;
}
</style>
</head>
<body>
       <?php

		show_header_operator($username);
		if(isset($_GET['mijenjajuser']))
		{
			$id = $_GET['mijenjajuser'];
			?>	<div id="container">
				<p class="p1">Postavke korisničkog imena</p>
				<div id="container">
					<div id="prikaz">
						<form action="" method="get">
							<input type="text" name="username">
							<input type="hidden" name="id" value="<?php print $id;?>">
							<input type="submit" value="Promijeni">
						</form>
					</div>
				</div>
			<?php
		}
		else if(isset($_GET['username']))
		{
			$usr = mysql_real_escape_string($_GET['username']);
			$usr_id = $_GET['id'];
			if($db->execute("update users set username = '".$usr."' where id = ".$usr_id))
			{
				print "<p>Promjena uspješno izvršena</p>";
				print "<a href= 'postavke.php'>Povratak nazad</a>";
				$_SESSION['username'] = $usr;
			}
			else
			{
				print "Došlo je do greške prilikom inserta";
			}
		}
		else if(isset($_GET['mijenjajemail']))
		{
			$id = $_GET['mijenjajemail'];
			?>	<div id="container">
				<p class="p1">Postavke korisničkog emaila</p>
				<div id="container">
					<div id="prikaz">
						<form action="" method="get">
							<input type="text" name="email">
							<input type="hidden" name="id" value="<?php print $id;?>">
							<input type="submit" value="Promijeni">
						</form>
					</div>
				</div>
			<?php
		}
		else if(isset($_GET['email']))
		{
			$mail = mysql_real_escape_string($_GET['email']);
			$usr_id = $_GET['id'];
			if($db->execute("update users set email = '".$mail."' where id = ".$usr_id))
			{
				print "<p>Promjena uspješno izvršena</p>";
				print "<a href= 'postavke.php'>Povratak nazad</a>";
			}
			else
			{
				print "Došlo je do greške prilikom inserta";
			}
		}
		else
		{
	?>
	<div id="container">
	<p class="p1">Korisničke postavke</p>
	<p class="p2">Potavke za: <?php print $username;?></p>
	<div id="prikaz">
	<hr>
	<table>
		<tr><td>Korisničko ime: </td><td><?php print $info['username'];?></td><td><a href="postavke.php?mijenjajuser=<?php print $info['id']; ?>"><button>Promijeni</button></a></td></tr>
		<tr><td>Korisnički e-mail: </td><td><?php print $info['email'];?></td><td><a href="postavke.php?mijenjajemail=<?php print $info['id']; ?>"><button>Promijeni</button></a></td></tr>
		<tr><td>Tip korisnika: </td><td><?php print $info['type'];?></td></tr>
	</table>
	</div>
	</div>
<?php
}
?>


</body></html>




