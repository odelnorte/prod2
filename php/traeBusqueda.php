<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$valor=$_POST["valorx"];
$n=$_POST["nx"];
if($n==1){
if($valor=='Bodega'){echo"<select id='selectBodega' onChange='traedatosMaq(this.value,1,0);'><option value='Bodega 2'>2</option><option value='Bodega 5'>5</option><option value='Bodega 9'>9</option><option value='Bodega 102'>102</option><option value='Bodega 1'>1</option></select>&nbsp;&nbsp;
Rack: <span id='spanRack'><select id='selectRack' onChange='traedatosMaq(this.value,2,selectBodega.value);'><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>SALIDAS B2</option><option value='10'>SHOWROOM</option></select></span>&nbsp;&nbsp;
Nivel: <span id='spanNivel'><select id='selectNivel' onchange='cambiaNivel(1);'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select></span>&nbsp;&nbsp;";}
if($valor=='Sala'){$regx=mssql_query("select * from cregion where regionid!=9 and regionid!=8 order by nombre");
$salax=mssql_query("select * from csala where regionidfk=1 and estatusidfk=5 order by nombre");
	 echo"Region: <select id='selectRegion' onChange='traedatosMaq(this.value,3,0);'>";
	 while($row = mssql_fetch_array($regx)) 
	 {echo"<option value='".$row["regionid"]."' >".$row["nombre"]."</option>";}
	  echo "<option value='9'>ARGENTINA</option><option value='8'>COLOMBIA</option></select>&nbsp;&nbsp;
	  Sala: <span id='spanSala2'><select id='selectSala' onChange='cambiaSala(1);'>";
	  while($row2 = mssql_fetch_array($salax)) 
	 {echo"<option value='".$row2["salaid"]."' >".$row2["nombre"]."</option>";}
	  echo "</select></span>";
}
if($valor=='Nuevas'){require("calendario.php"); $var='123';
echo"Pedimento: <input id='inputPedimento' type='text' size='7'>&nbsp;&nbsp;
Fecha Ped: <input id='txtFHRCalendario123' value=".date("d/m/Y")." size='8' style='font-size:10px;' type='text' readOnly/>&nbsp;<img src='imgs/calendario_ico.jpg' name='123' id='calendarioIco123' style='cursor: pointer;' onclick='show_calendar(this.name);' />&nbsp;&nbsp;<span class='divCalendario'><div id='calendario123'>";
    calendar_html($var);
echo"    </div></span>
&nbsp;&nbsp;Costo: $<input id='inputCosto' type='text' size='7'><br>
Factura: <input id='inputFactura' type='text' size='7'>&nbsp;&nbsp;Certificado: <input id='inputCertificado' type='text' size='7'>
No. Maquinas: <input id='inputCantidad' type='text' size='4'>&nbsp;&nbsp;Prefijo: <input id='inputPrefijo' type='text' size='5'>&nbsp;&nbsp;Sufijo: <input id='inputSufijo' type='text' size='5'>&nbsp;&nbsp;<br>Modelo: <select id='selectModelo'><option value='D2BLACK1'>D2BLACK1</option><option value='D2BLUEW1'>D2BLUEW1</option><option value='NW1000'>NW1000</option><option value='SZ8002'>SZ8002</option><option value='WBR1'>WBR1</option><option value='WBR2'>WBR2</option><option value='ZF3000'>ZF3000</option><option value='ZF4000'>ZF4000</option></select>&nbsp;&nbsp;Mueble: <select id='selectMueble'><option value='BLACKWAVE'>BLACKWAVE</option><option value='BLUEWAVE'>BLUEWAVE</option><option value='POKER ZITRO'>POKER ZITRO</option><option value='SLEIC'>SLEIC</option><option value='WBR1'>WBR1</option><option value='WBR2'>WBR2</option></select>&nbsp;&nbsp;Fabricante: <select id='selectFabricante'><option value='METRO'>METRO</option><option value='Operaciones del norte S.A. de C.V.'>ODN</option><option value='SLEIC'>SLEIC</option><option value='ZITRO'>ZITRO</option></select>&nbsp;<input type='button' id='ingresarMaqs' value='Ingresar' onClick='ingresarMaq();'>";}
if($valor=='contrato'){
	$contratos=mssql_query("select id,sa.nombre sala from tContratoNuevo c inner join csala sa on (sa.salaid=c.salaidfk) where c.estatusidfk=1 order by id");
	echo"Contratos Nuevos: <select id='selectContratosIni'>";
	while($contratosx=mssql_fetch_array($contratos)){
		echo"<option value=".$contratosx["id"].">".$contratosx["id"]." - ".$contratosx["sala"]."</option>";
		}
		echo"</select> ";
	}
}
if($n==2){if($valor=='Bodega'){echo"<select id='selectBodegaDes' onChange='traedatosMaq2(this.value,4,0);'><option value='Bodega 2'>2</option><option value='Bodega 5'>5</option><option value='Bodega 9'>9</option><option value='Bodega 102'>102</option><option value='Bodega 1'>1</option></select>&nbsp;&nbsp;
Rack: <span id='spanRackDes'><select id='selectRackDes' onChange='traedatosMaq2(this.value,2,selectBodegaDes.value);'><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>SALIDAS B2</option><option value='10'>SHOWROOM</option></select></span>&nbsp;&nbsp;
Nivel: <span id='spanNivelDes'><select id='selectNivelDes' onChange='cambiaNivel(2);'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select></span>&nbsp;&nbsp;";}
if($valor=='Sala'){$regx=mssql_query("select * from cregion where regionid!=9 and regionid!=8 order by nombre");
$salax=mssql_query("select * from csala where regionidfk=1 and estatusidfk=5 order by nombre");
	 echo"Region: <select id='selectRegionDes' onChange='traedatosMaq2(this.value,6,0);'>";
	 while($row = mssql_fetch_array($regx)) 
	 {echo"<option value='".$row["regionid"]."' >".$row["nombre"]."</option>";}
	  echo "<option value='9'>ARGENTINA</option><option value='8'>COLOMBIA</option></select>&nbsp;&nbsp;
	  Sala: <span id='spanSalaDes'><select id='selectSalaDes' onChange='traeOfficeID(this.value);'>";
	  while($row2 = mssql_fetch_array($salax)) 
	 {echo"<option value='".$row2["salaid"]."' >".$row2["nombre"]."</option>";}
	  echo "</select></span>||OfficeID 133";}
	   if($valor=='OS'){
	$ordenes=mssql_query("select a.ordenid,a.actividad,a.nombreActividad,a.estatusidfk,b.nombre sala, a.salaidfk salaid from torden_Servicio a
inner join csala b on (b.salaid=a.salaidfk)
where a.estatusidfk = 101 and a.actividad != ''
union
select a.ordenidfk,a.actividad,a.nombreActividad,a.estatusidfk,b.nombre sala, a.salaDescidfk salaid from tOrdenSalasDesc a
inner join csala b on (b.salaid=a.salaDescidfk)
where a.estatusidfk = 101 order by ordenid");
	echo"OS: <select id='selectOS'>";
	while($ordenesx=mssql_fetch_array($ordenes)){
		echo"<option value=".$ordenesx["ordenid"]."-".$ordenesx["salaid"].">".$ordenesx["ordenid"]." - ".$ordenesx["actividad"]." - ".$ordenesx["sala"]."</option>";
		}
		echo"</select>Motivo: &nbsp;<select id='selectMotivoMaq'>
		<option value='Reservado Nacional'>Reservado Nacional</option>
		<option value='Reservado Internacional'>Reservado Internacional</option>
		<option value='Inservible'>Inservible</option>
		</select><span id='spanDivOS'></span>";
	}
	if($valor=='contrato'){
	$contratos=mssql_query("select id,sa.nombre sala from tContratoNuevo c inner join csala sa on (sa.salaid=c.salaidfk) where c.estatusidfk=1 order by id");
	echo"Contratos Nuevos: <select id='selectContratos'>";
	
	while($contratosx=mssql_fetch_array($contratos)){
		echo"<option value=".$contratosx["id"].">".$contratosx["id"]."</option>";
		}
		echo"</select> &nbsp;&nbsp;&nbsp; Motivo: &nbsp;<select id='selectMotivoMaqCont'>
		<option value='Reservado Nacional'>Reservado Nacional</option>
		<option value='Reservado Internacional'>Reservado Internacional</option>
		</select>
		<span id='spanDivContratos'></span>";
	}
}
$sd->desconectar();
?>