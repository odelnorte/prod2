<?php
include("../../Conexion/conectaBase.php");
//$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();

$usuario=$_POST["usuarioIDx"];
$paisID=1;

$insert=mssql_query("insert into tmaquinas_incompletas(fecha,usuarioidfk)values(GETDATE(),".$usuario.")");

$revFolio=mssql_query("select top(1)* from tmaquinas_incompletas order by fecha desc");
$folio=mssql_fetch_array($revFolio);

echo"
<fieldset style='border: 2px solid blue'>
<fieldset style='border: 1px solid green'>
Serie Completa: &nbsp;&nbsp;&nbsp;<input type='text'; size='10'; id='serie".$folio["folioID"]."'; ></br><p><p>

<p>

Comentarios: &nbsp;&nbsp;&nbsp;</br><textarea readonly style='border:none;background:#F5F5F5' cols='70' rows='4' id='historial".$folio["folioID"]."' name='historial'>".$folio["comentarios"]."</textarea></br><p><p>
Escribe tus Comentarios: &nbsp;&nbsp;&nbsp;</br><textarea cols='70' rows='4' id='comentario".$folio["folioID"]."' name='comentarios'></textarea>&nbsp;&nbsp;&nbsp;
<input type='button'; value='Guardar'; onClick='guardaDatos(".$folio["folioID"].",comentario".$folio["folioID"].".value,serie".$folio["folioID"].".value);' >
</fieldset>";

$folioID=$folio["folioID"];

///////////////////////////////////////SOLICITAR MATERIAL/////////////////////////////////////
$sacaAreax=mssql_query("select * from cusuario where usuarioid = ".$usuario." and estatusidfk = 65");
$area=mssql_fetch_array($sacaAreax);

//$query="select * from cestado where estatusidfk=3 order by nombre";
$query="select * from cregion where estatusidfk=1 and paisidfk=".$paisID." order by nombre";
$result = mssql_query($query);
       	     // $estados="<select id='EstadoPN' onchange='traeSalasPN(this.value);'><option value='0'>Elije un estado ...</option>";  
					 // while($row = mssql_fetch_array($result)) 
					 // {$estados=$estados."<option value='".$row["regionid"]."'>".$row["nombre"]."</option>"; } 
					 // $estados=$estados."</select>";
$juegoQ="select * from cjuego order by nombre";
$juegoR = mssql_query($juegoQ);
             	      $juegos="<select id='juegoPedido".$folioN."1' style='font-size:10px' name='juego'>";  
					  while($row4 = mssql_fetch_array($juegoR))
					  {if($row4["juegoid"]==50){$juegos=$juegos."<option value='".$row4["juegoid"]."' selected >".$row4["nombre"]."</option>";}
					  else{$juegos=$juegos."<option value='".$row4["juegoid"]."'>".$row4["nombre"]."</option>"; } }
					  $juegos=$juegos."</select>";
$departamentoQ="select * from cdepartamento where departamentoid = 8 order by nombre";
if($paisID==1){
$departamentoR = mssql_query($departamentoQ);
             	      $departamentos="<select id='selectDepartamento' style='font-size:10px' name='departamento' onchange='ocultarCamposSala(this.value);'>
					  <option value='Sala'>Todos</option>";  
					  while($row5 = mssql_fetch_array($departamentoR)){
						$departamentos=$departamentos."<option value='".$row5["departamentoid"]."'>".$row5["nombre"]."</option>";
					  } 
					  $departamentos=$departamentos."</select>";
}
$caja="<select id='cajaPedido".$folioID."1' ><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='ATR'>ATR</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='SAC'>SAC</option>
<option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option>
<option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option>
<option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
$denominacion="<select id='denominacionPedido".$folioID."1' ><option value=''></option><option value='25c-50c-(1)-2'>25c-50c-(1)-2</option><option value='25c-50c-(1)-2-5'>25c-50c-(1)-2-5</option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option>
<option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";



 echo" <span id='spanNuevoPedido".$folioID."'><fieldset id='fieldset' style='border: 1px solid green'><legend>Solicitud de Refaccion</legend>
 Destino: ".$departamentos." &nbsp;&nbsp; <span id='spanCamposDepartamento'></span>
 <span id='spanCamposSala'></span>
				<table id='tablaNuevoPedido".$folioID."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cant</th>
				</tr>
				<tr>
				      <td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>1</td>
					  <td align='center'><input size='15' id='clavePedido".$folioID."1' maxlength='6' onKeyUp='traeDescrRefaccion(this,".$folioID.");' name='1' /></td>
					  <td align='center'><textarea id='descRef".$folioID."1' cols='50' rows='2' readonly></textarea></td>
					  <td align='center'><input size='15' id='cantidadPedido".$folioID."1' ></td>
					  
				</tr><tr id='PedidoTR2'></tr></table>
				<table width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'><tr>    
				      <td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>*</td><td align='center'><input name='2' size='15' id='contadorInput".$folioID."' maxlength='6' onFocus='agregarFilaRep(".$folioID.");' value='nuevo' class='nuevoTR'></td>
					  <td align='center'><input size='45' id='desRef*' onFocus='agregarFilaRep(".$folioID.");' value='nuevo' class='nuevoTR'></td>
					  <td align='center'><input size='15' id='cantidad*' onFocus='agregarFilaRep(".$folioID.");' value='nuevo' class='nuevoTR'></td>
					  
				</tr>
		</table>
				Obsevaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservacionesNP".$folioID."' style='color:#666'></textarea>
				<br>
	<span id='spanDesRefaccion".$folioID."' class='spanDesRefaccion'></span>
	<span id='spanEnviaSup".$folioID."'><img src='imgs/flechaVerde.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Enviar a Supervisor' onclick='enviaSupervisorRep(1,\"\",".$folioID.");'/></span><span id='spanCatalogo".$folioID."'><img src='imgs/catalogo.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Catalogo' onClick='ventanaCatalogoPiezasRep(".$folioID.");'/></span></fieldset>
</span>
</fieldset>";

echo ",,".$folio["folioID"];

$sd->desconectar();
?>