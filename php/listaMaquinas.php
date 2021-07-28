<?php
include("../../Conexion/conectaBase.php");
//$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();

$maqIncomp=mssql_query("select a.*,b.modelo from tmaquinas_incompletas a
left join cmaquinas b on (b.maquinaid=a.maquinaidfk)
where a.estatus = 2 or a.estatus is NULL 
order by a.fecha desc");

echo "<table id='listaFolios'>";
while($row=mssql_fetch_array($maqIncomp)){
	//$datosMaq=mssql_query("select * from cmaquinas where maquinaid = ".$row["maquinaidfk"]." ");
	//$datMaq=mssql_fetch_array($datosMaq);
	echo"
	<tr><td bgcolor='#00FF00'; style='cursor:pointer'; onclick='mostrarMaquinaIncomp(".$row["folioID"].");'>".$row['folioID']."&nbsp;&nbsp;".$row["serieCompleta"]."&nbsp;&nbsp;".$row["modelo"]."</td></tr>";
	//echo"hola";
}
//echo"hola";
$sd->desconectar();
?>