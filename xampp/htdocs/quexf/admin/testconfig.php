<?

include_once("../config.inc.php");
include_once("../db.inc.php");
include_once("../lang.inc.php");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../css/style5.css" />
<title><? echo T_("Test configuration"); ?></title>
</head>
<body>
<?
print "<h1>" . T_("Konfiguracijski test") . "</h1>";

global $db;

$fail = false;

$sql = "SELECT * 
	FROM worklog";

if (!($db->Execute($sql)))
{
	$fail = true;
	print "<p>" . T_("Greška prilikom uspostavljanja konekcije sa bazom. Provjerite da li: ") . DB_NAME .  T_(" postoji ") . DB_HOST . T_(" i da ") . DB_USER . T_(" ima privilegije za pristup bazi, ako ne modifikujte config.inc.php") . " <a href=\"../database/quexf.sql\">quexf.sql</a></p>";
}else
{
	print "<p>" . T_("Konekcija sa bazom podataka uspješno izvršena") . "</p>";
}

/*if (isset($_SERVER['PHP_AUTH_USER']))
{
	print "<p>" . T_("User authentication has been set up. You are user: ") . $_SERVER['PHP_AUTH_USER'] . "</p>";
}
else
{
	$fail = true;
	print "<p>" . T_("Could not detect user authentication. Please set up web server based authentication. If using apache, see here: ") . "<a href='http://httpd.apache.org/docs/2.0/howto/auth.html'>" . T_("Apache authentication") . "</a></p>";
}
*/
$post_max_size = ini_get('max veličina');
if (substr($post_max_size,0,-1) < 10)
	$pms = T_("Preporučeni minimum") . ": 10M";
else
	$pms = T_("OK");
$upload_max_filesize = ini_get('max veličina podatka');
if (substr($upload_max_filesize,0,-1) < 10)
	$umf = T_("Preporučeni minimum") . ": 10M";
else
	$umf = T_("OK");
$memory_limit = ini_get('RAM limit');
if (substr($memory_limit,0,-1) < 128)
	$ml = T_("Preporučeni minimum") . ": 128M";
else
	$ml = T_("OK");

print "<p>" . T_("Konfiguracijske opcije iz php.ini:") . "</p>";
print "<ul><li>max veličina = $post_max_size   <b>$pms</b></li>
	<li>max veličina podatka = $upload_max_filesize  <b>$umf</b></li>
	<li>RAM limit = $memory_limit  <b>$ml</b></li></ul>";

$gsbin = GS_BIN;
if($pos=stripos($gsbin," ")) $gsbin=substr($gsbin,0,$pos);
if (is_file($gsbin)) {
	$ver = exec(GS_BIN . " --version");
	if ($ver)
	{
		print "<p>" . T_("Pronađena GhostScript verzija") . " $ver</p>";
	}
	else
	{
		print "<p>" . GS_BIN . T_(" postoji ali se ne može pokrenuti") . "</p>";
		$fail = true;
	}
} else {
	echo "<p>" . T_("GhostScript nije pronađen, putanja: ") . GS_BIN .  "</p><p>" . T_("Modifikujte config.inc.php") . "</p>";
	$fail = true;
}

/*
if (OCR_ENABLED)
{
	
if (is_file(TESSERACT_BIN)) {
	print "<p>" . T_("Found Tesseract") . "</p>";
} else {
	echo "<p>"  . T_("Could not find Tesseract in path: ")  . TESSERACT_BIN .  "</p><p>" . T_("Please modify config.inc.php, TESSERACT_BIN to point to the tesseract executable or disable OCR by changing OCR_ENABLED to false") ."</p>";
		$fail = true;
}

if (is_file(CONVERT_BIN)) {
	print "<p>" .T_("Found ImageMagick") . "</p>";
} else
{
	echo "<p>" .T_("Could not find ImageMagick in path: ") . CONVERT_BIN .  "</p><p>" . T_("Please modify config.inc.php, CONVERT_BIN to point to the convert executable or disable OCR by changing OCR_ENABLED to false") . "</p>";
		$fail = true;
}
}
*/

if ($fail)
{
	print "<h2>" . T_("Greška !!!") . "</h2>";
}
else
{
	print "<h2>" . T_("Konfiguracijski test uspješno završen <img src='../css/images/Button-Ok-icon.png' alt='OK' height='32' width='32'>") . "</h2>";
}


?>
</body>
</html>
