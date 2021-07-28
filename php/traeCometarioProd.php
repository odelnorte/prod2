<?php
include("../../Conexion/conectaBase.php");
$folio=$_POST["NumFoliox"];
$sd =new conexion();
$sd->conectar();
$comx=mssql_query("select comentarios from tmaquinas_incompletas where folioID = ".$folio." ");
$com= mssql_fetch_array($comx);
echo $com["comentarios"];
$sd->desconectar();
?> 