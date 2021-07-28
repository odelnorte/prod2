<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$ordenSala=$_POST["ordenidx"];
$n=$_POST["nx"];
$con=0;

$arrgloOSsala = explode("-",$ordenSala,2);
$ordenid = $arrgloOSsala[0];
$salaid = $arrgloOSsala[1];

//echo".$ordenid.-.$salaid.";
?>
<div id='drag2' style='width:100%; '>
<?php

if($n==1){ $rackOrigen = mssql_query ("select u.*,m.maquinaid from cubicacion2 u
left join cmaquinas m on (m.ubicacionidfk=u.ubicacionid) where bodega='".$bodega."' and u.rack=".$rack." and nivel=".$nivel." order by convert(int,fila),columna");}
else {/*$muestraMaquinas=mssql_query("select a.solicitudid,a.ordenidfk,tipoMaquina,a.maquinaidfk,b.serieCompleta,c.nombre juego, a.version,a.denominacion from solicitudMaquinasOS a left join cmaquinas b on (b.maquinaid=a.maquinaidfk) inner join cjuego c on (c.juegoid=a.juegoidfk) where a.ordenidfk = ".$ordenid." and a.estatusidfk is NULL ");*/

$OSSalasDescx=mssql_query("select * from tOrdenSalasDesc where ordenidfk = ".$ordenid." and salaDescidfk = ".$salaid."");
$datosSalasDesc=mssql_fetch_array($OSSalasDescx);
$numOSDesc=mssql_num_rows($OSSalasDescx);

if($numOSDesc > 0){
	$muestraMaquinas=mssql_query("select tabla.row,ROW_NUMBER() OVER (ORDER BY a.solicitudid) AS row2,a.solicitudid,a.ordenidfk,a.tipoMaquina,a.maquinaidfk,b.serieCompleta,c.nombre juego, a.version,a.denominacion
from solicitudMaquinasOS a 
left join cmaquinas b on (b.maquinaid=a.maquinaidfk)
inner join ( SELECT solicitudid, ROW_NUMBER() OVER (ORDER BY solicitudid) AS row FROM solicitudMaquinasOS where ordenidfk = ".$ordenid." and estatusidfk is NULL and salaDesc = ".$salaid.")as tabla on (tabla.solicitudid=a.solicitudid)
inner join cjuego c on (c.juegoid=a.juegoidfk) 
where a.ordenidfk = ".$ordenid." and a.estatusidfk is NULL and salaDesc = ".$salaid."
and tabla.row>=1 and tabla.row<11");
	}else{
$muestraMaquinas=mssql_query("select tabla.row,ROW_NUMBER() OVER (ORDER BY a.solicitudid) AS row2,a.solicitudid,a.ordenidfk,a.tipoMaquina,a.maquinaidfk,b.serieCompleta,c.nombre juego, a.version,a.denominacion
from solicitudMaquinasOS a left join cmaquinas b on (b.maquinaid=a.maquinaidfk)
inner join ( SELECT solicitudid, ROW_NUMBER() OVER (ORDER BY solicitudid) AS row FROM solicitudMaquinasOS where ordenidfk = ".$ordenid." and estatusidfk is NULL and salaDesc is NULL)as tabla on (tabla.solicitudid=a.solicitudid)
inner join cjuego c on (c.juegoid=a.juegoidfk) where a.ordenidfk = ".$ordenid." and a.estatusidfk is NULL and salaDesc is NULL
and tabla.row>=1 and tabla.row<11");}
}// Fin $numOSDesc ?>

<?php if($n==1){echo"<div id='right' style='float:left;'> <table>";
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
				<th class="mark red_cell single">Juego</th>
				<th class="mark red_cell single">Version</th>
				<th class="mark red_cell single">Denominacion</th>
				</tr>';} 
				while($row=mssql_fetch_array($muestraMaquinas)){$con++; //$clase='';
				//$solicitud=$row["solicitudid"];
				if($row["serieCompleta"]!=NULL){$clase='class="mark green_cell single" ';}else{$clase='style="width:60px;"';}
				if($row["juego"]!=NULL && $row["tipoMaquina"]!=NULL){$clases='class="mark red_cell single" ';}
				else{$clase='style="width:60px;"';}
				if($row["ordenidfk"]==$ordenid){echo"<tr>";}
				echo"
				<td id='OS".$con."' ".$clase."  title='".$row["solicitudid"]."'>".$row["serieCompleta"]."</td>
				<td ".$clases.">".$row["tipoMaquina"]."</td>
				<td ".$clases.">".$row["juego"]."</td>
				<td ".$clases.">".$row["version"]."</td>
				<td ".$clases.">".$row["denominacion"]."</td>";}
				echo"</tr>
</table>";?>
</div>
</div>
<?php
if($numOSDesc > 0){
$cantidadx=mssql_query("select COUNT(ordenidfk)/10+1 cant from solicitudMaquinasOS where ordenidfk=".$ordenid." and salaDesc = ".$salaid." and estatusidfk is NULL");	
	}else{
$cantidadx=mssql_query("select COUNT(ordenidfk)/10+1 cant from solicitudMaquinasOS where ordenidfk=".$ordenid." and salaDesc is NULL and estatusidfk is NULL");} echo"|*|";
$cantidad=mssql_fetch_array($cantidadx);
echo"<br>";
for($i=0;$i<$cantidad["cant"];$i++){
	echo"&nbsp;&nbsp;&nbsp;<img src='imgs/editarPequeno.jpg' name='".$i."0' id='calendarioIco123' style='cursor: pointer;' onclick='traeParteListaOS($ordenid,this.name);' title='".$i."0'/>";//
}
 $sd->desconectar();
?>