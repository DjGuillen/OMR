<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="../favicon.ico">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" type="text/css" href="../css/demo1.css" />
   <link href='http://fonts.googleapis.com/css?family=Terminal+Dosis' rel='stylesheet' type='text/css' />
   <title>OMR</title>
 </head>
	<body>
<?php
include "quexmlpdf.php";
include("../session.php");
include ("../quexf/functions/functions.xhtml.php");
if(isset($_FILES['userfile']))
{
	if((!is_uploaded_file($_FILES['userfile']['tmp_name']))) {
		print "Error: Incorrectly formatted file uploaded.<br />";
		exit;
	}

	$filename = $_FILES['userfile']['tmp_name'];
	
	// create new queXMLPDF document
	$quexmlpdf = new queXMLPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

	set_time_limit(120);

	$quexmlpdf->setStyle($_POST['style']);
	$quexmlpdf->setResponseTextFontSize($_POST['responseTextFontSize']);
	$quexmlpdf->setResponseLabelFontSize(array($_POST['responseLabelFontSize'],$_POST['responseLabelFontSizeSmall']));

	$quexmlpdf->create($quexmlpdf->createqueXML(file_get_contents($filename)));

	//NEED TO GET QID from $quexmlpdf
	$qid = intval($quexmlpdf->getQuestionnaireId());

	$zip = new ZipArchive();
	$filename = tempnam("/tmp", "queXMLPDF") . ".zip";
	
	if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
	    exit("cannot open temporary file\n");
	}
	
	$zip->addFromString("quexf_banding_$qid.xml", $quexmlpdf->getLayout());
	$zip->addFromString("quexmlpdf_$qid.pdf", $quexmlpdf->Output("quexml_$qid.pdf", 'S'));
	$zip->close();
	
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="quexmlpdf_' . $qid . '.zip"'); 
	header('Content-Transfer-Encoding: binary');
	// load the file to send:
	readfile($filename);
	unlink($filename);

}
else
{
	$quexmlpdf = new queXMLPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

	?>
	
		<?php
	session_start();
	if(isset($_SESSION['username']))
	{
	$_username=$_SESSION['username'];
	session_validate();
	if(isset($_SESSION['type'])  && $_SESSION['type'] == "administrator")
	{
	include("../quexf/db.inc.php");
	$result = $db->GetRow('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"');
	?>
	<div class="header">
        <a href="../../index.php?logout=1"><strong>&laquo; Odjavi se</strong></a>
            <div class="home"><a href="../../main.php">Home</a></div>
			<div class="home"><a href="poruke.php">Msg: <?php print $result['nb_new_pm'];?></a></div>
			<span class="right">
                <a href="#"><strong>LOGOVANI STE KAO: <?php print $_username;?></strong></a>
            </span>
        <div class="clr"></div>
    </div>	    
	<div class="container">			
	<h1>XML u PDF sa vrijednostima za obradu formulara</h1>
	<p>Ako je file XML validan .ZIP file sa formularom u .PDF i .XML formatu će biti kreiran za <a href='http://localhost/quexf/admin/index.php'>Obradu Formulara</a></p>
	<br>
		<form enctype="multipart/form-data" action="?" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
			<p>Odaberite XML file za upload: 
			<input name="userfile" type="file" class="br" />
			<br/><br/></p>
			<div><label for="style"><p>Stil:</p><br/></label><textarea name="style" id="style" cols="120" rows="14"><?php echo $quexmlpdf->getStyle(); ?></textarea></div><br/><br/>
<table>
<tr>
<td><div><label for="responseTextFontSize">Tekst formulara/veličina fonta pitanja</label></td>
<td><input name="responseTextFontSize" type="text" value="<?php echo $quexmlpdf->getResponseTextFontSize();?>"/></div></td>
</tr>
<tr>
<td><div><label for="responseLabelFontSize">Labela formulara/veličina fonta (normal)</label></td>
<td><input name="responseLabelFontSize" type="text" value="<?php $t = $quexmlpdf->getResponseLabelFontSize(); echo $t[0];?>"/></div></td>
</tr>
<tr>
<td><div><label for="responseLabelFontSizeSmall">Labela formulara/veličina fonta (small)</label></td>
<td><input name="responseLabelFontSizeSmall" type="text" value="<?php $t = $quexmlpdf->getResponseLabelFontSize(); echo $t[1];?>"/></div></td>
</tr>
</table>
			
			
			
			<br/><br/>
			<input class="upl" type="submit" value="Upload File" />
		</form>
	</div>
	
	</body>
	
	<?php 
	}
	else
	{
		print "<h1>Nemate pravo pristupa. Logujte se kao administrator</h1>";
	}
	}
	else
	{
		header("Location:../index.php");
	}
	?>
	</html>
	<?php
}
?>
