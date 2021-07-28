<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$contratoid=$_POST["contratoidx"];
$n=$_POST["nx"];
$n2=$_POST["n2x"];
$con=0;
if($n2>00){	$n3=$n2+10;	$n2=$n2+1;}
else{$n2=1; $n3=10;}
//echo".$ordenid.";
?>
<div id='drag2' style='width:100%; '>
<?php


$muestraMaquinas=mssql_query("select tabla.row,ROW_NUMBER() OVER (ORDER BY a.solicitudid) AS row2,a.solicitudid,a.ordenidfk,a.tipoMaquina,a.maquinaidfk,b.serieCompleta
from maquinasCNuevos a left join cmaquinas b on (b.maquinaid=a.maquinaidfk)
inner join ( SELECT solicitudid, ROW_NUMBER() OVER (ORDER BY solicitudid) AS row FROM maquinasCNuevos where contratoidfk = ".$contratoid." and estatusidfk ='1')as tabla on (tabla.solicitudid=a.solicitudid)
where a.contratoidfk = ".$contratoid." and a.estatusidfk ='1'
and tabla.row>=".$n2." and tabla.row<=".$n3."");

if($n==1){echo"<div id='right' style='float:left;'> <table>";
$var2=1;
while($res2=mssql_fetch_array($rackOrigen)){
	//if($res2["serie"]!=NULL){$clase='class="mark green_cell single" ';}else{$clase='class="" ';}
	if($res2["columna"]=='A'){echo '<tr>';}
	//if($res2["serie"]=='' || $res2["serie"]==''){$res2["maquinaid"]=0;}
	if($res2["serie"]!=''){
		if($res2["fila"] == $var2){echo '<td class="tablaOrigen" id="'.$res2["ubicacionid"].'"><div id="'.$res2["maquinaid"].'" class="drag orange climit1_2" title="'.$res2["serie"].'" >'.$res2["serie"].'</div></td>';}else{++$var2; echo '<td id="'.$res2["ubicacionid"].'" class="tablaOrigen"><div id="'.$res2["maquinaid"].'" class="drag orange climit1_2" title="'.$res2["serie"].'" >'.$res2["serie"].'</div></td>';}}else{echo'<td width="35px"  class="tablaOrigen"></td>';}
} echo '</tr></table>';}
else{$var=1; $clase='';echo'<table id="table1">
				<colgroup>
					<col width="70"/>
					<col width="70"/>
					<col width="70"/>
					<col width="70"/>
					<col width="70"/>
					<col width="70"/>
					<col width="70"/>
				</colgroup>
				<tr>
				<th class="mark red_cell single">Serie</th>
				<th class="mark red_cell single">Maquina</th>
				</tr>';} 
				while($row=mssql_fetch_array($muestraMaquinas)){$con++; //$clase='';
				//$solicitud=$row["solicitudid"];
				if($row["serieCompleta"]!=NULL){$clase='class="mark green_cell single" ';}else{$clase='style="width:60px;"';}
				if($row["juego"]!=NULL && $row["tipoMaquina"]!=NULL){$clases='class="mark red_cell single" ';}
				else{$clase='style="width:60px;"';}
				if($row["ordenidfk"]==$ordenid){echo"<tr>";}
				echo"
				<td id='OS".$con."' ".$clase."  title='".$row["solicitudid"]."'>".$row["serieCompleta"]."</td>
				<td ".$clases.">".$row["tipoMaquina"]."</td>";}
				echo"</tr>
</table>";?>
</div>
</div>
<?php
$cantidadx=mssql_query("select COUNT(contratoidfk)/10+1 cant from maquinasCNuevos where contratoidfk=".$contratoid." and estatusidfk ='1'"); echo"|*|";
$cantidad=mssql_fetch_array($cantidadx);
echo"<br>";
for($i=0;$i<$cantidad["cant"];$i++){
	echo"&nbsp;&nbsp;&nbsp;<img src='imgs/editarPequeno.jpg' name='".$i."0' id='calendarioIco123' style='cursor: pointer;' onclick='traeParteListaOS($ordenid,this.name);' title='".$i."0'/>";//
}
 $sd->desconectar();
?>