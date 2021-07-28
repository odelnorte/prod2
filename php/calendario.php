<?php
function ultimoDia($mes,$ano){
    $ultimo_dia=28;
    while (checkdate($mes,$ultimo_dia + 1,$ano)){
       $ultimo_dia++;
    }
    return $ultimo_dia;
}

function calendar_html($fol){
	$meses= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	//$fecha_fin=date('d-m-Y',time());
	$mes=date('m',time());
	$anio=date('Y',time());
	?>
	<table style="width:200px;text-align:center;border:1px solid #808080;border-bottom:0px;" cellpadding="0" cellspacing="0">
	 <tr>
	  <td colspan="4">
	  	<select id="calendar_mes<?php echo $fol; ?>" onchange="update_calendar(<?php echo $fol; ?>)">
		 <?php
		 $mes_numero=1;
		 while($mes_numero<=12){
		 	if($mes_numero==$mes){
				echo "<option value=".$mes_numero." selected=\"selected\">".$meses[$mes_numero-1]."</option> \n";
			}else{
		 		echo "<option value=".$mes_numero.">".$meses[$mes_numero-1]."</option> \n";
			}
			$mes_numero++;
		 }
		 ?>
		</select>
	  </td>
	  <td colspan="3">
	  	<select style="width:70px;" id="calendar_anio<?php echo $fol; ?>" onchange="update_calendar(<?php echo $fol; ?>)">
		 <?php
		 // años a mostrar
		 
		 $anio_min=$anio-0; //hace 30 años
		 $anio_max=$anio+2; //año actual
		 
		 echo "<option value='2011'>2011</option>
		 	   <option value='2012'>2012</option>
			   <option value='2013'>2013</option>
			   <option value='2014'>2014</option>
			   <option value='2015'>2015</option>
			   <option value='2016'>2016</option>
			   <option value='2017'>2017</option>
			   <option value='2018' selected='selected'>2018</option>
			   <option value='2019'>2019</option>";
		 /*$anio_min=$anio-1; //hace 30 años
		 $anio_max=$anio; //año actual
		 while($anio_min<=$anio_max){
		 	echo "<option value=".$anio_min.">".$anio_min."hola</option> \n";
			echo "<option value=".$anio.">".$anio."</option> \n";
			$anio_min++;
		 }*/
		 ?>
		</select>
	  </td>
	 </tr>
	</table>
	<div id="calendario_dias<?php echo $fol; ?>">
	<?php calendar($mes,$anio,$fol) ?>
	</div>
	<?php
}

function calendar($mes,$anio,$fol){
	$dia=1;
	if(strlen($mes)==1) $mes='0'.$mes;
	?>
	<table style="width:200px;text-align:center;border:1px solid #808080;border-top:0px;" cellpadding="0" cellspacing="0">
	 <tr style="background-color:#CCCCCC;">
	  <td>D</td>
	  <td>L</td>
	  <td>M</td>
	  <td>M</td>
	  <td>J</td>
	  <td>V</td>
	  <td>S</td>
	 </tr>
	<?php

	//echo $mes.$dia.$anio;
	$numero_primer_dia = date('w', mktime(0,0,0,$mes,$dia,$anio));
	$ultimo_dia=ultimoDia($mes,$anio);
	if($mes==9){$ultimo_dia=$ultimo_dia+1;}
	$total_dias=$numero_primer_dia+$ultimo_dia;

	$diames=1;
	//$j dias totales (dias que empieza a contarse el 1º + los dias del mes)
	$j=1;
	while($j<$total_dias){
		echo "<tr> \n";
		//$i contador dias por semana
		$i=0;
		while($i<7){
			if($j<=$numero_primer_dia){
				echo " <td></td> \n";
			}elseif($diames>$ultimo_dia){
				echo " <td></td> \n";
			}else{
				if($diames<10) $diames_con_cero='0'.$diames;
				else $diames_con_cero=$diames;
if(($mes==9) && ($diames==30)){echo "<tr><td><a style=\"display:block;cursor:pointer;\" onclick=\"set_date('".$diames_con_cero."-".$mes."-".$anio."||".$fol."')\">".$diames."</a></td></tr>";}else{if(($mes==7) && ($diames==32)){}else{
				echo " <td><a style=\"display:block;cursor:pointer;\" onclick=\"set_date('".$diames_con_cero."-".$mes."-".$anio."||".$fol."')\">".$diames."</a></td> \n";}}
				$diames++;
			}
			$i++;
			$j++;
		}
		echo "</tr> \n";
	}
	?>
	</table>
	<?php
}
?>