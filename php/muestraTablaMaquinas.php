<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$n=$_POST["nx"];
//$rackDestino = mssql_query ("select * from cubicacion2 where bodega='".$bodega."' and rack=".$rack."and nivel=".$nivel." ");
//$res=mssql_fetch_array($rack); echo $res["columna"];
?>
		<div id="drag2" style="width:100%; ">

<?php $ocultar=""; $ocultar2=""; 
if($bodega=='Bodega 2' && $rack==7 && $nivel==1){$ocultar="and fila<=12";}
if($bodega=='Bodega 2' && $rack==7 && $nivel==2){$ocultar="and fila<=11"; $ocultar2="and columna not in ('Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 2' && $rack==7 && $nivel==3){$ocultar="and fila<=11"; $ocultar2="and columna not in ('P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 2' && $rack==2){$ocultar="and fila<=15";} //  MODIFICACION PARA B2 Rack 2 quedando con 15 filas y 16 columnas (capacidad de 240 máquinas) ALDO LEDESMA  28.02.2020
if($bodega=='Bodega 2' && $rack==4){$ocultar="and fila<=15";}
if($bodega=='Bodega 2' && $rack==5){$ocultar="and fila<=8";}
if($bodega=='Bodega 2' && $rack==9){$ocultar="and fila<=12"; $ocultar2="and columna not in ('L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 2' && $rack==6){$ocultar=""; $ocultar2="and columna not in ('Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 2' && $rack==10){$ocultar="and fila<=10"; $ocultar2="and columna not in ('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==1){$ocultar="and fila<=12"; $ocultar2="and columna not in ('L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==2 && $nivel==1){$ocultar="and fila<=12"; $ocultar2="and columna not in ('M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==2 && $nivel==2){$ocultar="and fila<=11"; $ocultar2="and columna not in ('L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==3 && $nivel==1){$ocultar="and fila<=9"; $ocultar2="and columna not in ('M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==3 && $nivel==2){$ocultar="and fila<=9"; $ocultar2="and columna not in ('M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==3 && $nivel==3){$ocultar="and fila<=8"; $ocultar2="and columna not in ('K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==4){$ocultar="and fila<=12"; $ocultar2="";}// faltan filas
if($bodega=='Bodega 5' && $rack==5 && $nivel==1){$ocultar="and fila<=9"; $ocultar2="and columna not in ('N','O','P','Q','R','S','T','U','V','W')";}
if($bodega=='Bodega 5' && $rack==5 && $nivel==2){$ocultar="and fila<=5"; $ocultar2="and columna not in ('N','O','P','Q','R','S','T','U','V','W')";}

if($bodega=='Bodega 5' && $rack==6){$ocultar="and fila<=9"; $ocultar2="and columna not in ('H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W')";}
if($bodega=='Bodega 5' && $rack==7){$ocultar="and fila<=5"; $ocultar2="and columna not in ('F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T')";}
if($bodega=='Bodega 5' && $rack==8){$ocultar="and fila<=10"; $ocultar2="and columna not in ('H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 5' && $rack==9){$ocultar="and fila<=13"; }
if($bodega=='Bodega 5' && $rack==10){$ocultar="and fila<=7"; $ocultar2="and columna not in ('F','G','H','I','J')";}
if($bodega=='Bodega 5' && $rack==13){$ocultar="and fila<=15"; $ocultar2="";}//faltan
if($bodega=='Bodega 9' && $rack==6){$ocultar=""; $ocultar2="and columna not in ('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 9' && $rack==5){$ocultar="and fila<=12"; $ocultar2="and columna not in ('K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 9' && $rack==4){$ocultar="and fila<=12"; $ocultar2="and columna not in ('K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')";}
if($bodega=='Bodega 9' && $rack==6){$ocultar="and fila<=12";}


 if($n==1){
	$rackOrigen = mssql_query ("select u.*,m.maquinaid from cubicacion2 u
left join cmaquinas m on (m.ubicacionidfk=u.ubicacionid) where bodega='".$bodega."' and u.rack=".$rack." and nivel=".$nivel." ".$ocultar." ".$ocultar2." order by convert(int,fila),columna");}
else{$rackDestino = mssql_query ("select * from cubicacion2 where bodega='".$bodega."' and rack=".$rack."and nivel=".$nivel." ".$ocultar." ".$ocultar2." order by convert(int,fila),columna ");} ?>

<?php if($n==1){echo"<div id='right' style='float:left;'> <table>";
$var2=1;
$colx=mssql_query("select columna from cubicacion2 where bodega='".$bodega."' and rack=".$rack."and nivel=".$nivel." and fila=1 ".$ocultar2." order by columna");
echo "<tr bgcolor='#FFFFFF'><td></td>";
while($col=mssql_fetch_array($colx)){
	echo '<td style="font-size:14px;"><b>'.$col["columna"].'</b></td>';
	}
echo "</tr>";
while($res2=mssql_fetch_array($rackOrigen)){
	//if($res2["serie"]!=NULL){$clase='class="mark green_cell single" ';}else{$clase='class="" ';}
	if($res2["columna"]=='A'){echo '<tr><td width="20px" bgcolor="#FFFFFF" style="font-size:14px;"><b>'.$res2["fila"].'</b></td>';}
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
				</colgroup>';
				//$colx=mssql_query("select columna from cubicacion2 where bodega='".$bodega."' and rack=".$rack."and nivel=".$nivel." and fila=1 ".$ocultar2." order by columna");
/*echo "<tr bgcolor='#FFFFFF'><td></td>";
while($col=mssql_fetch_array($colx)){
	echo '<td style="font-size:14px;"><b>'.$col["columna"].'</b></td>';
	}
echo "</tr>";*/
while($res=mssql_fetch_array($rackDestino)){
	if($res["serie"]!=NULL){$clase='class="mark green_cell single" ';}else{$clase='style="width:60px;"';}
	if($res["columna"]=='A'){echo '<tr>';/*echo '<tr><td width="20px" bgcolor="#FFFFFF" style="font-size:14px;"><b>'.$res["fila"].'</b></td>';*/}
		if($res["fila"] == $var){echo '<td id="'.$res["ubicacionid"].'" '.$clase.' title="'.$res["fila"].'-'.$res["columna"].'">'.$res["serie"].'</td>';}else{++$var; echo '<td id="'.$res["ubicacionid"].'" '.$clase.' title="'.$res["fila"].'-'.$res["columna"].'">'.$res["serie"].'</td>';}
} echo '</tr></table>';}
?>
            </div>
		</div>
<?php $sd->desconectar(); ?>