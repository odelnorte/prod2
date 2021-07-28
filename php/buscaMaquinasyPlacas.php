<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 

$valor=$_POST["nx"];
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$pais=$_POST["paisIDx"];
$placa=$_POST["numeroPlacax"];
$region=$_POST["regionx"];
$sala=$_POST["salax"];

if($valor==1){
if($placa==''){
$query=mssql_query("select a.bodega,a.rack,b.serieCompleta,b.estatus,b.mueble, b.modelo, b.maquinaid,b.tipoPlaca  from cubicacion2 a inner join cmaquinas b on (b.ubicacionidfk=a.ubicacionid) where a.bodega = '".$bodega."' and a.rack = ".$rack." and a.nivel = ".$nivel." and a.serie is not null and b.ubicacionidfk is not null");}
else{$query=mssql_query("select * from cmaquinas where tipoPlaca = '".$placa."'");}

echo"
<table id='tablaMaq' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:60%; font-size:12px; border:0px;'>
<tr>
<th align='center'>Serie Completa</th>
<th align='center'>Placa</th>
<th align='center'>Mueble</th>
</tr>";
while($row=mssql_fetch_array($query)){
	$datos=mssql_query("select * from cmaquinas where maquinaid = ".$row["maquinaid"]."");
	$dat=mssql_fetch_array($datos);
	echo"
<tr>
<td>".$row["serieCompleta"]."</td>
<td align='center'><select id='selectPlaca' onchange='guardaPlaca(\"".$row["maquinaid"]."\",this.value);'>
<option value='0'>Selecciona Placa</option>
<option value='Sin Placa'";if($dat["tipoPlaca"]=='Sin Placa'){echo" selected='selected'";}echo">Sin Placa</option>
<option value='AVC3'";if($dat["tipoPlaca"]=='AVC3'){echo" selected='selected'";}echo">AVC3</option>
<option value='AVC4'";if($dat["tipoPlaca"]=='AVC4'){echo" selected='selected'";}echo">AVC4</option>
<option value='AVC5'";if($dat["tipoPlaca"]=='AVC5'){echo" selected='selected'";}echo">AVC5</option>
<option value='AVC6'";if($dat["tipoPlaca"]=='AVC6'){echo" selected='selected'";}echo">AVC6</option>
<option value='M2N'";if($dat["tipoPlaca"]=='M2N'){echo" selected='selected'";}echo">M2N</option>
<option value='M4N'";if($dat["tipoPlaca"]=='M4N'){echo" selected='selected'";}echo">M4N</option>
<option value='Asus'";if($dat["tipoPlaca"]=='Asus'){echo" selected='selected'";}echo">Asus</option>
<option value='BENUS 1.0'";if($dat["tipoPlaca"]=='BENUS 1.0'){echo" selected='selected'";}echo">BENUS 1.0</option>
<option value='BENUS 2.0'";if($dat["tipoPlaca"]=='BENUS 2.0'){echo" selected='selected'";}echo" >BENUS 2.0</option>
<option value='ASUS'";if($dat["tipoPlaca"]=='ASUS'){echo" selected='selected'";}echo" >ASUS</option>
</select></td>
<td>".$row["mueble"]."</td>
</tr>";}
echo"</table>";
}
if($valor==2){
	if($placa==''){
	$query=mssql_query("select * from cmaquinas where salaidfk = $sala");}
	else{$query=mssql_query("select * from cmaquinas where tipoPlaca = '".$placa."' and ubicacionidfk is NULL");}
	echo"
<table id='tablaMaq' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:60%; font-size:12px; border:0px;'>
<tr>
<th align='center'>Serie Completa</th>
<th align='center'>Placa</th>
<th align='center'>Mueble</th>
</tr>";
while($row=mssql_fetch_array($query)){
	$datos=mssql_query("select * from cmaquinas where maquinaid = ".$row["maquinaid"]."");
	$dat=mssql_fetch_array($datos);
	echo"
<tr>
<td>".$row["serieCompleta"]."</td>
<td align='center'><select id='selectPlaca' onchange='guardaPlaca(\"".$row["maquinaid"]."\",this.value);'>
<option value='0'>Eligue Placa</option>
<option value='Sin Placa'";if($dat["tipoPlaca"]=='Sin Placa'){echo" selected='selected'";}echo">Sin Placa</option>
<option value='AVC3'";if($dat["tipoPlaca"]=='AVC3'){echo" selected='selected'";}echo">AVC3</option>
<option value='AVC4'";if($dat["tipoPlaca"]=='AVC4'){echo" selected='selected'";}echo">AVC4</option>
<option value='AVC5'";if($dat["tipoPlaca"]=='AVC5'){echo" selected='selected'";}echo">AVC5</option>
<option value='AVC6'";if($dat["tipoPlaca"]=='AVC6'){echo" selected='selected'";}echo">AVC6</option>
<option value='M2N'";if($dat["tipoPlaca"]=='M2N'){echo" selected='selected'";}echo">M2N</option>
<option value='M4N'";if($dat["tipoPlaca"]=='M4N'){echo" selected='selected'";}echo">M4N</option>
<option value='BENUS 1.0'";if($dat["tipoPlaca"]=='BENUS 1.0'){echo" selected='selected'";}echo">BENUS 1.0</option>
<option value='BENUS 2.0'";if($dat["tipoPlaca"]=='BENUS 2.0'){echo" selected='selected'";}echo" >BENUS 2.0</option>
<option value='ASUS'";if($dat["tipoPlaca"]=='ASUS'){echo" selected='selected'";}echo" >ASUS</option>
</select></td>
<td>".$row["mueble"]."</td>
</tr>";}
echo"</table>";
	}

$sd->desconectar();
?>