<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>OMR</title>
   <style>
	body{
	background:url(../images/pattern.png),url(../images/background.png);
	background-color: transparent;
    background-repeat: repeat, no-repeat;
    background-position: center center;
    background-attachment: fixed;
    -webkit-background-size: auto, cover;
    -moz-background-size: auto, cover;
    -o-background-size: auto, cover;
    background-size: auto, cover;
	color: #fff;
	font-family:'CandaraRegular';
	}
	
	#box{
	background:url(../images/shape.png) no-repeat center;
	margin:150px auto 0 auto;
	width:360px;
	height:264px;
	padding-top:20px;
	}

	p{
		color: #4C5C4C;
		display:block;
		text-align:center;
		margin-top:10px;
	}
	form{
		height:150px;
		margin: 10px;
	}
	input{
		width: 200px;
		margin-left:20%;
		margin-right:auto;
		border-radius:2px;
		border: 1px solid #C6C6C2;
	}
   </style>
 </head>
	<body>
	<?php
	include_once("quexf/config.inc.php");
	include_once("quexf/db.inc.php");
	include_once("quexf/functions/functions.database.php");
	global $db;
	error_reporting(E_ALL ^ E_STRICT);
	if(isset($_GET['email']))
	{
		function generatepass()
		{
			$alfabet = "qwertzuiopasdfghjklyxcvbnm1234567890";
			$pass = "";
			for($i = 1; $i<=10; $i++)
			{
				$pass .= $alfabet[rand(0, strlen($alfabet)-1)];
			}
			return $pass;
		}
		$mail = $_GET['email'];
		$generated_password = generatepass();
		$db->execute("update users set password = '".sha1($generated_password)."' where email = '".mysql_real_escape_string($mail)."'");
		$count = $db->Affected_Rows();
		if($count > 0)
		{
		@require_once "Mail.php";
		
		//----------------------------------------------
		//		MAIL
		//----------------------------------------------
		
		$from = "";
		$to = $mail;
		$subject = "OMR password reset";
		$body = "";
		
		$host = "ssl://smtp.gmail.com";
		$port = "465";
		$username = "";
		$password = "";
		
		$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
		$smtp = @Mail::factory('smtp',
			array ('host' => $host,
			 'port' => $port,
			 'auth' => true,
			 'username' => $username,
			 'password' => $password));
		//----------------------------------------------
		
			$body .= "Vaš novi password je: ".$generated_password;
			$email = @$smtp->send($to, $headers, $body);
			if(@PEAR::isError($email))
			{
				print "Greška. PEAR poruka ----> ".$email->getMessage();
				print "<a href='index.php'>Povratak nazad</a>";
			}
			else
			{
				print "Šifra resetovana<br>";
				print "<a href='index.php'>Povratak nazad</a><br>";
			}
		}
		else
		{
			print "Email adresa se ne nalazi u bazi korisnika. Unesite email adresu sa kojom ste registrovani.<br>";
			print "<a href='forgot.php'>Povratak nazad</a><br>";
			print "<a href='index.php'>Povratak na početnu stranu</a>";
		}
	}
	else
	{
?>

        <div id="box">
		
        <form action="" method="get">
		<p>Unesite vašu email adresu. Šifra će biti automatski generisana i poslana na putem emaila.</p>
            <input type="text" name="email"/><br>
            <input type="submit" name="submit" class="submit" value="Pošalji" />
        </form>
		</div>
		<?php } ?>
	</body>
</html>