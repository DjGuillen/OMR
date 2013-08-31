<?php
include_once("../config.inc.php");
include_once("../db.inc.php");

global $db;	
$predmeti = $db->GetAll("select * from sub");		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><? echo T_("Rezultati"); ?></title>
<link rel="stylesheet" type="text/css" href="../css/table.css">
<script>
		function prikaz()
		{
			var select = document.getElementById('subjects');
			var sid = select.options[select.selectedIndex].value;
			var select1 = document.getElementById('test');
			var qid = select1.options[select1.selectedIndex].value;
			var xmlhttp = "";
				if (window.XMLHttpRequest) 
				{
					xmlhttp = new XMLHttpRequest();
				}
				else
				{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				if(qid == "default")
				{
					document.getElementById('result').innerHTML = "";
				}
				else
				{
					xmlhttp.open('GET', 'ajax_prikaz_rezultata.php?sid='+encodeURIComponent(sid)+"&qid="+encodeURIComponent(qid), true);
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
		function testovi()
		{
			document.getElementById('result').innerHTML = "";
			var select = document.getElementById('subjects');
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
					document.getElementById('test').disabled = true;
					document.getElementById('test').innerHTML = "";
				}
				else
				{
					document.getElementById('test').disabled = false;
					xmlhttp.open('GET', 'ajax_prikaz_rezultata.php?id='+encodeURIComponent(id), true);
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById('test').innerHTML=xmlhttp.responseText;
						}
					}	
					xmlhttp.send();
				}
		}
   </script>
</head>
<body>
<div class="comboholder">
	Predmet: <select id="subjects" onChange="testovi();">
	<option value="default">Odabrite predmet</option>
	<?php 
		foreach($predmeti as $predmet)
		{
			print "<option value = '".$predmet['id']."'>".$predmet['name']."</option>";
		}
	?>
	</select>
	<select id="test" disabled onChange="prikaz();">
	
	</select>
	<hr>
	<div id="result">

	</div>
</body></html>




