<?php
mysql_connect("localhost","stuff","ffuts");
mysql_select_db("stuff");

extract($_POST);
$sql = "UPDATE `item` SET `xpos` = $x, `ypos` = $y, `name` = '$name', `beschreibung` = '$beschreibung' WHERE `id` = $liste";
mysql_query($sql) or die(mysql_error());
header("Location: index.php");
?>