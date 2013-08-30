<?php
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		include_once("../config.inc.php");
		include_once("../db.inc.php");
		include_once("../functions/functions.database.php");
		include("../functions/functions.xhtml.php");
						
		global $db;

		$info = $db->GetRow("select * from users where id = '".$id."';");
		?>
		<p class="p1">Postavke za: <?php print $info['username'];?></p>
	<div id="prikaz">
	<hr>
	<table>
		<tr><td class="static">Korisničko ime: </td><td><code><?php print $info['username'];?></code></td><td><a href="usrpostavke.php?mijenjajuser=<?php print $info['id']; ?>"><button>Promijeni</button></a></td></tr>
		<tr><td class="static">Korisnički e-mail: </td><td><code><?php print $info['email'];?></code></td><td><a href="usrpostavke.php?mijenjajemail=<?php print $info['id']; ?>"><button>Promijeni</button></a></td></tr>
		<tr><td class="static">Tip korisnika: </td><td><code><?php print $info['type'];?></code></td></tr>
	</table>
	<hr>
	<p class="p3">Promjena šifre</p>
	<form action="" method="post">
	<table style="margin-top:20px;">
		<tr><td class="static">Unesite staru šifru:</td><td><input type="password" name="oldpassword"></td></tr>
		<tr><td class="static">Unesite novu šifru:</td><td><input type="password" name="newpassword"></td></tr>
		<tr><td class="static">Unesite novu šifru ponovo:</td><td><input type="password" name="newpassword1"></td></tr>
		<tr><td></td><td><input type="submit" value="Promijeni"></td>
	</table>
		<input type="hidden" name="id" value="<?php print $info['id'];?>">
	</form>
	</div>
	<?php
	}

?>