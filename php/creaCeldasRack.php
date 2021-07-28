<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$celdas=$_POST["celdasx"];
$num=$_POST["numx"];
$cont=-1;
$tope=9;

if($num==2){
	echo'<table>
			<tr>';
		for($i=1; $i<=$celdas; $i++){++$cont;
			if($cont > $tope){$tope=$tope+10; echo '</tr><tr>';}
			echo '<td width="30px" id="sala'.$cont.'" title="'.$cont.'"></td>';
		}
			echo'</tr>';
	echo'</table>';
}

$sd->desconectar();
?>