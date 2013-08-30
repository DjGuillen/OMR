<?php
    session_start();
	if(isset($_SESSION['username']))
	{
	$username=$_SESSION['username'];	
	}


include_once("../config.inc.php");
include_once("../db.inc.php");
include_once("../functions/functions.database.php");
include("../functions/functions.xhtml.php");
				
global $db;

$result = $db->GetAll("select * from users where type != 'administrator';");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="css/demo1.css" />
   <script>
		function prikaz()
		{
			var select = document.getElementById('users');
			var id = select.options[select.selectedIndex].value;
			var xmlhttp = "";
				if (window.XMLHttpRequest) 
				{
					xmlhttp = new XMLHttpRequest();
				}
				else
				{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				if(id == "default")
				{
					document.getElementById('result').innerHTML = "";
				}
				else
				{
					xmlhttp.open('GET', 'ajax_prikaz_korisnika.php?id='+encodeURIComponent(id), true);
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById('result').innerHTML=xmlhttp.responseText;
						}
					}	
					xmlhttp.send();
				}
		}
   </script>
   <style type="text/css">
@font-face {
		  font-family: 'NotethisRegular';
		  src: url('../../css/fonts/Note_this.eot');
		  src: local('Note this Regular'), local('Notethis'), url('../../css/fonts/Note_this.ttf') format('truetype');
		}
		.p1{
		font-family:'NotethisRegular', Verdana, Arial, sans-serif;
		font-size: 24px;
		color:#FFFFFF;
		text-shadow:1px 1px 1px #6E6E6E;
		margin-bottom:0px;
		text-align:center;
		}
		.p2{
		color:#FFFFFF;
		text-shadow:1px 1px 1px #6E6E6E;
		margin-top:5px;
		text-align:center;
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


.p3{
font-family:'NotethisRegular', Verdana, Arial, sans-serif;
font-size: 20px;
color:#FFFFFF;
text-shadow:1px 1px 1px #6E6E6E;
margin-bottom:0px;
margin-top:0px;
}

table{
	width:90%;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:50px;
}

.static{
	font-size:18px;
	color:#FFFFFF;
	text-shadow:1px 1px 1px #6E6E6E;
	font-family:sans-serif;
}

td code{
	float:right;
}

#comboholder{
	width:400px;
	margin-left:auto;
	margin-right:auto;
}
</style>
   </head>
<body>
<?php
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
				print "<a href= 'usrpostavke.php'>Povratak nazad</a>";
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
				print "<a href= 'usrpostavke.php'>Povratak nazad</a>";
			}
			else
			{
				print "Došlo je do greške prilikom inserta";
			}
		}
		else if(isset($_POST['oldpassword']))
		{
			$oldpass = $_POST['oldpassword'];
			$newpassword = $_POST['newpassword'];
			$newpassword1 = $_POST['newpassword1'];
			$id = $_POST['id'];
			if($info['password'] == sha1($oldpass))
			{
				if($newpassword == $newpassword1)
				{
					$db->execute("update users set password = '".sha1(mysql_real_escape_string($newpassword))."' where id = ".$id);
					print "<p>Šifra uspješno promijenjena</p>";
					print "<a href= 'usrpostavke.php'>Povratak nazad</a>";
				}
				else
				{
					print "<p>Greška kod nove šifre: unesene šifre se ne slažu</p>";
					print "<a href= 'usrpostavke.php'>Povratak nazad</a>";
				}
			}
			else
			{
				print "<p>Pogrešna šifra. Da biste promijenili šifru, morate unijeti ispravnu važeću šifru</p>";
				print "<a href= 'usrpostavke.php'>Povratak nazad</a>";
			}
		}
		else
		{
		?>
<div class="comboholder">
	Korisnik: <select id="users" onChange="prikaz();">
	<option value="default">Odabrite korisnika</option>
	<?php 
		foreach($result as $user)
		{
			print "<option value = '".$user['id']."'>".$user['username']."</option>";
		}
	?>
	</select>
</div>
<hr>

<div id="result">

</div>
<?php
}
?>
</body></html>