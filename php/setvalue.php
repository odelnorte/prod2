<?php
require('calendario.php');
$mes=$_GET['month'];
$anio=$_GET['year'];
$fol=$_GET['fol'];
$dia=1; 
calendar($mes,$anio,$fol);
?>

