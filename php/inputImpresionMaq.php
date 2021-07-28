<?php 

include("conectaBase.php");
$sd = new conexion();
$sd->conectar();
$familiax=mssql_query("select * from cfamilia_refaccion order by nombre");

echo "Serie: 
<input id='serieImpComSinVincular' type='text' size='8'/>&nbsp;&nbsp;

<input type='button' value='Imprimir Componentes' onClick='impComMaqSinVincular(serieImpComSinVincular.value);'/>
<div id='divInvQR'></div>
";
$sd->desconectar(); 
?>
