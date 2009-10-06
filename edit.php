<?
mysql_connect("localhost","stuff","ffuts");
mysql_select_db("stuff");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Karten-Test</title>
</head>
<body>
<script type="text/javascript" src="js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript">
<!--

// --- Einstellungen ---

// Halbe Größen des Overlaybildes
var xhalbe = 15;
var yhalbe = 15;

// Größe des Hintergrunds
var hgx = 300;
var hgy = 300;

// --- Script ---
var elementid = -1;


function bildclick(ereignis) {
	if(!ereignis) 
		ereignis = window.event;
	if(elementid < 0)
		return;
	if(ereignis.layerX)	
		reposition(ereignis.layerX,ereignis.layerY)
	else if(ereignis.offsetX)
		reposition(ereignis.layerX,ereignis.layerY)
	else 
		alert("Funktion von Deinem Browser nicht unterstützt.")
}

function reposition(x,y) {
	if(x - xhalbe < 0) x = xhalbe;
	if(x + xhalbe > hgx) x = hgx - xhalbe;
	if(y - yhalbe < 0) y = yhalbe;
	if(y + yhalbe > hgy) y = hgy - yhalbe;
	xol = x - xhalbe;
	yol = y - yhalbe;	
	document.images[elementid].style.left = xol + "px";
	document.images[elementid].style.top = yol + "px";
	document.einstellungen.x.value = x;
	document.einstellungen.y.value = y;
}

function elementselect() {
	var id = document.einstellungen.liste.value;
	if(id == 0) {
		for(var i = 0; i < document.images.length; i++) {
			document.images[i].style.visibility = 'hidden';
		}
		elementid = -1;
		document.einstellungen.name.value = '';
		document.einstellungen.beschreibung.value = '';
	} else {
		if(elementid != -1) {
			document.images[elementid].style.visibility = "hidden"; 
		}
		elementid = id - 1;
		document.images[elementid].style.visibility = "visible";	
		document.einstellungen.name.value = namen[elementid];
		document.einstellungen.beschreibung.value = beschreibungen[elementid];
		document.einstellungen.x.value = Number(document.images[elementid].style.left.substr(0, document.images[elementid].style.left.length - 2)) + 15;
		document.einstellungen.y.value = Number(document.images[elementid].style.top.substr(0, document.images[elementid].style.top.length - 2)) + 15;
	}
}

function laden() {
	document.getElementById('map').onclick = bildclick;
}

window.onload = laden;

//-->
</script>
<div id="map" style="background-image:url(img/hg.png); position: relative; width: 300px; height: 300px; border: 1px dotted #000000; float: left;">
<?php
$namen = "";
$beschreibungen = "";
$sql = "SELECT * FROM `item` ORDER BY `id`";
$result = mysql_query($sql) or die(mysql_error());
while($data = mysql_fetch_assoc($result)):
?>
	<img src="img/<? echo $data['bild']?>" style="position: absolute; left: <? echo $data['xpos'] - 15 ?>px; top: <? echo $data['ypos'] - 15 ?>px;visibility:hidden;"/>
<?php
	$namen .= "'".$data['name']."',";
	$beschreibungen .= "'".strtr($data['beschreibung'], array("\n" => '<br />', "\r\n" =>'<br />'))."',";
endwhile;
?>
</div>
<script type="text/javascript">
<!--
var namen = new Array(<?=($namen."''")?>);
var beschreibungen = new Array(<?=($beschreibungen."''")?>);
//-->
</script>
<form name="einstellungen" action="edit2.php" method="post">
<select name="liste">
<option value="0" onclick="elementselect()">W&auml;hle das Element</option>
<?
$result = mysql_query($sql) or die(mysql_error());
while($data = mysql_fetch_assoc($result)):
?>	
	<option value="<?=$data['id']?>" onclick="elementselect()"><?=$data['name']?></option>
<?
endwhile;
?>
</select><br />
<input type="text" name="x" size="4" readonly="readonly" />x<input type="text" name="y" size="4" readonly="readonly" /><br />
Name: <input type="text" name="name"><br>
Beschreibung: <textarea name="beschreibung"></textarea><br />
<input type="submit">
</form>
<div style="clear:left;"><a href="index.php">Hauptansicht.</a></div>
</body>
</html>