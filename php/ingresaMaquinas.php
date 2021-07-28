<?php
include("../../Conexion/conectaBase.php");
$ped=$_POST["pedx"];
$fechaPed=$_POST["fechaPedx"];
$costo=$_POST["costox"];
$fac=$_POST["facturax"];
$cer=$_POST["certificadox"];
$can=$_POST["canx"];
$prefijo=$_POST["prefijox"];
$sufijo=$_POST["sufijox"];
$mod=$_POST["modelox"];
$mue=$_POST["mueblex"];
$fab=$_POST["fabx"];
$fil=1; $col=0; $ban=0;

$sd =new conexion();
$sd->conectar();

for($i=1;$i<=$can;$i++){
$insert=mssql_query("INSERT INTO cmaquinas(serie,prefijo,sufijo,modelo,mueble,fabricante,pedimento,certificado,factura,serieCompleta,transito,fechaPedimento,costo)  VALUES('','".$prefijo."','".$sufijo."','".$mod."','".$mue."','".$fab."','".$ped."','".$cer."','".$fac."','','0','".$fechaPed."',".$costo.") ");
}
$rackOrigen = mssql_query ("select * from cmaquinas where pedimento='".$ped."' and factura='".$fac."' and serie='' ");
//$rackOrigen = mssql_query ("select * from cmaquinas where pedimento is not null ");
echo"<div id='right' style='float:left;'><table>";
while($res=mssql_fetch_array($rackOrigen)){$col=$col+1; /*if($col==8){$fil=$fil+1;echo"<tr>";}*/ if($fil==1 && $ban==0){echo"<tr>"; $ban=1;}
	echo '<td class="tablaOrigen" id="TDMN'.$res["maquinaid"].'"><input id="inputMN'.$res["maquinaid"].'" name="'.$res["maquinaid"].'--'.$prefijo.'--'.$sufijo.'" type="text" size="6" onChange="guardaSerieMN(this.value,this.name);" onDblClick="editarSer(this.id)"></td>';
	if($col==7){$fil=$fil+1;echo"</tr><tr>";$col=0;}//else{$fil=$fil+1;}
}echo '</tr></table><input type="button" value="Listo" onClick="traeTablaMaqNuevas(\''.$ped.'\',\''.$fac.'\')"></div>';
$sd->desconectar();
?>