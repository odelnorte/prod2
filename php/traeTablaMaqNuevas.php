<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$ped=$_POST["pedx"];
$fac=$_POST["facx"];

echo"<div id='drag2' style='width:100%; '> ";
			
$rackOrigen = mssql_query ("select * from cmaquinas where pedimento='".$ped."' and factura='".$fac."'");
//$rackOrigen = mssql_query ("select * from cmaquinas where pedimento is not null ");

echo"<div id='right' style='float:left;'> <table id='maquinasNuevas'>";
$var2=1;
while($res2=mssql_fetch_array($rackOrigen)){
   $col=$col+1; /*if($col==8){$fil=$fil+1;echo"<tr>";}*/ if($fil==1 && $ban==0){echo"<tr>"; $ban=1;}
	echo '<td class="tablaOrigen" id="Div'.$res2["maquinaid"].'"><div id="'.$res2["maquinaid"].'" class="drag orange climit1_2" title="'.$res2["serieCompleta"].'" >'.$res2["serieCompleta"].'</div></td>';
	if($col==7){$fil=$fil+1;echo"</tr><tr>";$col=0;}

	/*if($res2["columna"]=='A'){echo '<tr>';}
	if($res2["serie"]=='' || $res2["serie"]==''){$res2["maquinaid"]=0;}
		if($res2["fila"] == $var2){echo '<td class="tablaOrigen" id="'.$res2["ubicacionid"].'"><div id="'.$res2["maquinaid"].'" class="drag orange climit1_2" title="'.$res2["serie"].'" onmouseover="seleccionaSerie(this.title,'.$res2["maquinaid"].');">'.$res2["serie"].'</div></td>';}else{++$var2; echo '<td id="'.$res2["ubicacionid"].'" class="tablaOrigen"><div id="'.$res2["maquinaid"].'" class="drag orange climit1_2" title="'.$res2["serie"].'" onmouseover="seleccionaSerie(this.title,'.$res2["maquinaid"].');">'.$res2["serie"].'</div></td>';}*/
} echo '</tr></table>
            </div>
		</div>';

$sd->desconectar(); ?>