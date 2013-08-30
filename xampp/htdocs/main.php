<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="shortcut icon" href="images/icon.jpg">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="css/demo.css" />
   <link rel="stylesheet" type="text/css" href="css/style5.css" />
   <link href='http://fonts.googleapis.com/css?family=Terminal+Dosis' rel='stylesheet' type='text/css' />
   <title>OMR</title>
 </head>
	<body>
	<?php
	session_start();
	if(isset($_SESSION['username']))
	{
	$_username=$_SESSION['username'];
	}
	?>
        <div class="container">
            <div class="header">
            <a href="index.php?logout=1"><strong>&laquo; Odjavi se</strong></a>
                <span class="right">
                    <a href="#"><strong>LOGOVANI STE KAO: <?php print $_username;?></strong></a>
                </span>
                <div class="clr"></div>
            </div>
            <h1>WEB bazirana OMR aplikacija za dodavanje i obradu formulara</h1>
            <div class="content">
                <ul class="ca-menu">
                    <li>
                        <a href="http://localhost/quexml/index.php">
                            <span class="ca-icon">A</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Kreiranje formulara</h2>
                                <h3 class="ca-sub">Dodavanje novog formulara na osnovu .xml file-a</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/quexf/admin/index.php">
                            <span class="ca-icon">I</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Obrada formulara</h2>
                                <h3 class="ca-sub">Podešavanje i editovanje formulara</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/quexf/admin/icrtab.php">
                            <span class="ca-icon">T</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Prepoznavanje teksta</h2>
                                <h3 class="ca-sub">Podešavanje i trening programa</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/phpmyadmin/">
                            <span class="ca-icon">S</span>
                            <div class="ca-content">
                                <h2 class="ca-main">MySQL Baza</h2>
                                <h3 class="ca-sub">Administracija baze podataka</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="ca-icon">Z</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Dokumentacija</h2>
                                <h3 class="ca-sub">Uputstvo za korištenje programa</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="ca-icon">U</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Postavke</h2>
                                <h3 class="ca-sub">Korisničke opcije</h3>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="ca-icon">@</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Poruke</h2>
                                <h3 class="ca-sub">Pošaljite poruku korisnicima sistema</h3>
                            </div>
                        </a>
                    </li>					
                </ul>
            </div><!-- content -->
        </div>
       <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
	
	</body>
</html>