<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$valor=$_POST["valorx"];
$dato=$_POST["datox"];
$noMostrar="";
if($valor=='Bodega 2'){$noMostrar="and rack!=1 and rack!=11";}
if($valor=='Bodega 5'){$noMostrar="and rack!=8 and rack!=9 and rack!=10 and rack!=11 and rack!=13 and rack!=14 and rack!=15 and rack!=16";}
if($valor=='Bodega 9'){$noMostrar="and rack!=15 and rack!=14 and rack!=13 and rack!=11 and rack!=10 and rack!=9 and rack!=8 and rack!=7";}
if($dato=='1'){$rackx=mssql_query("select distinct convert(int,rack)rack from cubicacion2 where bodega='".$valor."' ".$noMostrar." order by rack");
	echo"<select id='selectRack' onChange='traedatosMaq(this.value,2,selectBodega.value);'>";
	while($row = mssql_fetch_array($rackx)) 
	 { $banrack=0;
	  if($valor=='Bodega 2' && ($row["rack"]=='9' || $row["rack"]=='10')){$banrack=1;
		 //if($row["rack"]=='8'){echo"<option value='".$row["rack"]."' >SR B2</option>";}
		 if($row["rack"]=='9'){echo"<option value='".$row["rack"]."' >SALIDAS B2</option>";}
		 if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >SHOWROOM</option>";}
		 //if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >CGR</option>";}
		 }
		 if($valor=='Bodega 1' && ($row["rack"]=='1' || $row["rack"]=='2' || $row["rack"]=='3' || $row["rack"]=='4' || $row["rack"]=='5')){$banrack=1;
			 if($row["rack"]=='1'){echo"<option value='".$row["rack"]."' >S.DESARROLLO</option>";}
			 if($row["rack"]=='2'){echo"<option value='".$row["rack"]."' >C.GRABACIONVIDEOS</option>";}
			 if($row["rack"]=='3'){echo"<option value='".$row["rack"]."' >S.PRINCIPAL</option>";}
			 if($row["rack"]=='4'){echo"<option value='".$row["rack"]."' >S.ANDES</option>";}
			 if($row["rack"]=='5'){echo"<option value='".$row["rack"]."' >S.CAPACITACION</option>";}
			 }
		 if($valor=='Bodega 5'){
			  if($row["rack"]=='1' || $row["rack"]=='7' || $row["rack"]=='17'){
				  if($row["rack"]=='1'){echo"<option value='".$row["rack"]."' >Patio de salidas</option>";}
				  if($row["rack"]=='7'){echo"<option value='".$row["rack"]."' >Laboratorio B5</option>";}
				  if($row["rack"]=='17'){echo"<option value='".$row["rack"]."' >Ingresos</option>";}
			  }
			 else{echo"<option value='".$row["rack"]."' >C".$row["rack"]."</option>";}
		/* if($row["rack"]=='99'){echo"<option value='".$row["rack"]."' >V</option>";}
		 if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >SRD</option>";}
		 if($row["rack"]=='11'){echo"<option value='".$row["rack"]."' >SRV</option>";}
		 if($row["rack"]=='1'){echo"<option value='".$row["rack"]."' >C11</option>";}
		 if($row["rack"]=='2'){echo"<option value='".$row["rack"]."' >C8</option>";}
		 if($row["rack"]=='3'){echo"<option value='".$row["rack"]."' >C5</option>";}
		 if($row["rack"]=='8'){echo"<option value='".$row["rack"]."' >C4</option>";}*/
		// echo"<option value='".$row["rack"]."' >C".$row["rack"]."</option>";
		 }
     else{ if($valor=='Bodega 2' && $row["rack"]=='99'){echo"<option value='".$row["rack"]."' >V</option>";}
	 else{if($banrack==0){echo"<option value='".$row["rack"]."' >".$row["rack"]."</option>";}}}}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='2'){$bod=$_POST["bodx"];
$nivelx=mssql_query("select distinct convert(int,nivel)nivel from cubicacion2 where bodega='".$bod."' and rack=".$valor." and nivel!=0 order by nivel");
	echo"<select id='selectNivel' onchange='cambiaNivel(1);'>";
	while($row = mssql_fetch_array($nivelx)) 
	 {echo"<option value='".$row["nivel"]."' >".$row["nivel"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='3'){
$salax=mssql_query("select * from csala where regionidfk=".$valor." and estatusidfk=5 order by nombre");
	echo"<select id='selectSala'>";
	while($row = mssql_fetch_array($salax)) 
	 {echo"<option value='".$row["salaid"]."' >".$row["nombre"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='4'){$rackx=mssql_query("select distinct convert(int,rack)rack from cubicacion2 where bodega='".$valor."' ".$noMostrar." order by rack");
	echo"<select id='selectRackDes' onChange='traedatosMaq2(this.value,5,selectBodegaDes.value);'>";
	while($row = mssql_fetch_array($rackx)) 
	 {$banrack=0; if($valor=='Bodega 2' && ($row["rack"]=='9' || $row["rack"]=='10')){$banrack=1;
		 //if($row["rack"]=='8'){echo"<option value='".$row["rack"]."' >SR B2</option>";}
		 if($row["rack"]=='9'){echo"<option value='".$row["rack"]."' >SALIDAS B2</option>";}
		 if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >SHOWROOM</option>";}
		 //if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >CGR</option>";}
		 }
		 if($valor=='Bodega 1' && ($row["rack"]=='1' || $row["rack"]=='2' || $row["rack"]=='3' || $row["rack"]=='4' || $row["rack"]=='5')){$banrack=1;
			 if($row["rack"]=='1'){echo"<option value='".$row["rack"]."' >S.DESARROLLO</option>";}
			 if($row["rack"]=='2'){echo"<option value='".$row["rack"]."' >C.GRABACIONVIDEOS</option>";}
			 if($row["rack"]=='3'){echo"<option value='".$row["rack"]."' >S.PRINCIPAL</option>";}
			 if($row["rack"]=='4'){echo"<option value='".$row["rack"]."' >S.ANDES</option>";}
			 if($row["rack"]=='5'){echo"<option value='".$row["rack"]."' >S.CAPACITACION</option>";}
			 }
		 
		 if($valor=='Bodega 5'){
			  if($row["rack"]=='1' || $row["rack"]=='7' || $row["rack"]=='17'){
				  if($row["rack"]=='1'){echo"<option value='".$row["rack"]."' >Patio de salidas</option>";}
				  if($row["rack"]=='7'){echo"<option value='".$row["rack"]."' >Laboratorio B5</option>";}
				  if($row["rack"]=='17'){echo"<option value='".$row["rack"]."' >Ingresos</option>";}
			  }
			 else{echo"<option value='".$row["rack"]."' >C".$row["rack"]."</option>";}
		 /*if($row["rack"]=='99'){echo"<option value='".$row["rack"]."' >V</option>";}
		 if($row["rack"]=='10'){echo"<option value='".$row["rack"]."' >SRD</option>";}
		 if($row["rack"]=='11'){echo"<option value='".$row["rack"]."' >SRV</option>";}*/
		 //echo"<option value='".$row["rack"]."' >C".$row["rack"]."</option>";
		 }
     else{if($valor=='Bodega 2' && $row["rack"]=='99'){echo"<option value='".$row["rack"]."' >V</option>";}
	 else{if($banrack==0){
		 /*if($valor=='Bodega 5' && $row["rack"]=='99'){echo"<option value='".$row["rack"]."' >V</option>";}else{*/ echo"<option value='".$row["rack"]."' >".$row["rack"]."</option>";} }}}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='5'){$bod=$_POST["bodx"];
$nivelx=mssql_query("select distinct convert(int,nivel)nivel from cubicacion2 where bodega='".$bod."' and rack=".$valor." order by nivel");
	echo"<select id='selectNivelDes' onChange='cambiaNivel(2);'>";
	while($row = mssql_fetch_array($nivelx)) 
	 {echo"<option value='".$row["nivel"]."' >".$row["nivel"]."</option>";}
	  echo "</select>&nbsp;&nbsp;";
}
if($dato=='6'){
$salax=mssql_query("select * from csala where regionidfk=".$valor." and estatusidfk=5 order by nombre");
$officeID=mssql_query("select TOP(1)OfficeID from csala where regionidfk=".$valor." and estatusidfk=5 order by nombre");$officeIDx = mssql_fetch_array($officeID);
	echo"<select id='selectSalaDes' title='destino' onchange='traeOfficeID(this.value);'>";
	while($row = mssql_fetch_array($salax)) 
	 {echo"<option value='".$row["salaid"]."' >".$row["nombre"]."</option>";}
	  echo "</select>&nbsp;&nbsp;||OfficeID ".$officeIDx["OfficeID"]."";
}
$sd->desconectar();
?>