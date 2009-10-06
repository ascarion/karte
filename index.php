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
<div style="background-image:url(img/hg.png); position: relative; width: 300px; height: 300px; border: 1px dotted #000000">
<?php
$sql = "SELECT * FROM `item` ORDER BY `id`";
$result = mysql_query($sql) or die(mysql_error());
while($data = mysql_fetch_assoc($result)):
?>
	<img src="img/<? echo $data['bild']?>" style="position: absolute; left: <? echo $data['xpos'] - 15 ?>px; top: <? echo $data['ypos'] - 15 ?>px;" 
		onmouseover="return overlib('<?=strtr($data['beschreibung'], array("\n" => '<br />', "\r\n" =>'<br />'))?>', CAPTION, '<?=$data['name']?>');" onmouseout="return nd()" />
<?php
endwhile;
?>
</div>

<a href="edit.php">Bearbeiten</a>
</body>
</html>