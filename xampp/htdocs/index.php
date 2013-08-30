<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="shortcut icon" href="images/icon.png">
   <link href="css/style.css" rel="stylesheet" type="text/css" />
   <title>OMR</title>
 </head>
	<body>
	<?php
	include 'quexf/db.inc.php';
	session_start();	
	
		if (isset($_GET['logout'])){
	    session_unset();
		}
//echo $_SESSION['username'];		
// LOGIN
	if (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$t=mysql_query("select type from users where username='".mysql_real_escape_string($username)."';");
		    $d = mysql_fetch_assoc($t);
			if($d['type']=="administrator"){
		    header("Location:main.php");
		    }
		    else if($d['type']=="operator"){
		    header("Location:quexf/index.php");
		     }
	}
	
	else if (isset($_POST['submit'])){		
		$username= $_REQUEST['username'];
		$q=mysql_query("select * from users where username='".mysql_real_escape_string($username)."';");
		
		if($q){		
			$password = sha1($_REQUEST['password']);
			
			   if($data = mysql_fetch_assoc($q)){
				
				    if($data['password'] == $password){
					    $_SESSION['username'] = $_REQUEST['username'];
		                    $t=mysql_query("select type from users where username='".mysql_real_escape_string($username)."';");
		                        $d = mysql_fetch_assoc($t);
							    if($d['type']=="administrator"){
		                        header("Location:main.php");
		                        }
		                        else if($d['type']=="operator"){
		                        header("Location:quexf/index.php");
		                        }
				}
				else{
?>
					<h3>Neispravni podaci!</h3><br>
<?php
				}
							
			}
			   else{
?>			   
				<h3>Neispravni podaci!</h3>
<?php				
			} 
		}
		
	}
	


?>		
        <div id="box">
        <div class="elements">
        <div class="avatar"></div>
        <form action="" method="post">
            <input type="text" name="username" class="username"/>
            <input type="password" name="password" class="password"/>
            <input type="submit" name="submit" class="submit" value="Prijavi se" />
			<a href="forgot.php">Zaboravili ste šifru?</a>
        </form>
</div>
</div>	
	</body>
</html>