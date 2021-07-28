<?php //require ('permiso.php');
include("../../Conexion/conectaBase.php");

$paisID=$_POST["paisIDx"];
if($paisID==''){$paisID=1;}
$folioN='0';
//$NumFolio=str_replace("-2011","",$folio);
$sd =new conexion();
$sd->conectar();

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
					  {if($row4["juegoid"]==50){$juegos=$juegos."<option value='".$row4["juegoid"]."' selected>".$row4["nombre"]."</option>";}
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
$caja="<select id='cajaPedido".$folioN."1' ><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='ATR'>ATR</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='SAC'>SAC</option>
<option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option>
<option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option>
<option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
$denominacion="<select id='denominacionPedido".$folioN."1' ><option value=''></option><option value='25c-50c-(1)-2'>25c-50c-(1)-2</option><option value='25c-50c-(1)-2-5'>25c-50c-(1)-2-5</option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option>
<option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";

 echo" <fieldset id='fieldset'><legend>Solicitud de Refaccion</legend>
 Destino: ".$departamentos." &nbsp;&nbsp; <span id='spanCamposDepartamento'></span>
 <span id='spanCamposSala'></span>
 &nbsp;&nbsp;&nbsp;Proyecto: 
 <select id='selProyecto' ><option value='SIN PROYECTO'>SIN PROYECTO</option><option value='PROYECTO CODERE'>PROYECTO CODERE</option><option value='PROYECTO CODERE JOKER'>PROYECTO CODERE JOKER</option><option value='PROYECTO CODERE PRODUCCION'>PROYECTO CODERE PRODUCCION</option><option value='PROYECTO CONVERSION ZF 4000 A D2'>PROYECTO CONVERSION ZF 4000 A D2</option>
 <option value='TAPAS CODERAS BLACK'>TAPAS CODERAS BLACK</option><option value='SERVIDORES BENUS'>SERVIDORES BENUS</option><option value='240 MAQUINAS'>240 MAQUINAS</option><option value='INGRESO 50C'>INGRESO 50C</option><option value='PROYECCION SERVIDORES BENUS INTERNACIONAL'>PROYECCION SERVIDORES BENUS INTERNACIONAL</option><option value='BIG BANG'>BIG BANG</option><option value='INGRESO DE MAQUINAS'>INGRESO DE MAQUINAS</option>
 </select>
				<table id='tablaNuevoPedido0' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cant</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Serie</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Caja</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Denominacion</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Licencia</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Version</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>IP</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Juego</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Motivo</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Diagnostico</th>
				</tr>
				<tr>
				      <td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>1</td><td><input size='5' id='clavePedido".$folioN."1' maxlength='6' onKeyUp='traeDesRefaccion(this,0);' name='1' /></td>
					  <td><textarea id='descRef".$folioN."1' cols='20' rows='2' readonly></textarea></td>
					  <td><input size='1' id='cantidadPedido".$folioN."1' ></td>
					  <td><input size='6' id='seriePedido".$folioN."1' ></td><td>".$caja."</td>
					  <td>".$denominacion."</td>
					  <td><input size='6' id='licenciaPedido".$folioN."1' name='".$folioN."1' onKeyUp='buscaLicenciaSF(this.value,this.name);' />
					  <div class='divBuscaFallas' id='divBuscaLicenciasSF".$folioN."1' ></div></td>
					  
					  <td><input size='6' id='versionPedido".$folioN."1'></td><td><input size='6' id='ipPedido".$folioN."1' ></td>
					  <td id='JuegoPedidoTD1'>".$juegos."</td><td><input size='30' id='motivoPedido".$folioN."1' ></td>
					  <td title='diagnosticoPedido".$folioN."1'><textarea id='diagnosticoPedido".$folioN."1' cols='20' rows='2'></textarea></td>
				</tr><tr id='PedidoTR2'></tr></table>
				<table width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'><tr>    
				      <td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>*</td><td><input name='2' size='5' id='contadorInput0' maxlength='6' onFocus='agregarFila(0);' value='nuevo' class='nuevoTR'></td>
					  <td><input size='35' id='desRef*' onFocus='agregarFila(0);' value='nuevo' class='nuevoTR'></td>
					  <td><input size='1' id='cantidad*' onFocus='agregarFila(0);' value='nuevo' class='nuevoTR'></td>
					  <td><input size='6' id='serie*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td><td><input size='15' id='caja*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td>
					  <td><input size='18' id='denominacion*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td><td><input size='6' id='licencia*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td>
					  <td><input size='6' id='version*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td><td><input size='6' id='ip*' value='nuevo' class='nuevoTR'></td>
					  <td><input size='25' id='juego*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td><td><input size='30' id='motivo*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td><td><input size='30' id='diagnostico*' value='nuevo' class='nuevoTR' onFocus='agregarFila(0);'></td>
				</tr>
		</table>
				Obsevaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservacionesNP0' style='color:#666'></textarea>
				<br>
	<span id='spanDesRefaccion0' class='spanDesRefaccion'></span>
	<span id='spanEnviaSup0'><img src='imgs/flechaVerde.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Enviar a Supervisor' onclick='enviaSupervisor(1,\"\",0);'/></span><span id='spanCatalogo0'><img src='imgs/catalogo.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Catalogo' onClick='ventanaCatalogoPiezasPro(0);'/></span></fieldset>";
$sd->desconectar();
?>