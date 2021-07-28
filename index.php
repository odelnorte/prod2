<?php require ('php/permiso.php');
include('php/calendario.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<HTML>
<HEAD>

	<TITLE>Producci&oacute;n</TITLE>
<link type="text/css" href="css/basicoAct.css"  rel="stylesheet"/>
<link type="text/css" href="css/basicoModal.css?ver=<?=date("his");?>"  rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="css/estiloMenu.css" />
<script type="text/javascript" src="js/funcionesCC.js?ver=<?=date("his");?>"></script>
<script type="text/javascript" src="../Vistas/ordenServicio/funcionesOS.js"></script>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<link href="date/datePicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="date/date.js"></script>
 <script type="text/javascript" src="php/redips-drag-min.js"></script>
<script type="text/javascript" src="php/script.js"></script>
<link rel="stylesheet" href="php/style.css" type="text/css" media="screen"/>
<script type="text/javascript" src="date/jquery.datePicker.js"></script>
<script type="text/javascript" src="js/calendario/jquery.functions.js"></script>

<script type="text/javascript" src="date/jquery.alerts.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="date/jquery.alerts.css" rel="stylesheet" type="text/css" >

</HEAD>
<body onload="usuario();">
<img alt="full screen background image" src="../imgsinicio/FondodePantallaSISCO.jpg" id="full-screen-background-image" />
<div id="contenedor" >
<div style=" background:url(../imgsinicio/fondoArriba21.jpg)" >
<!--LOGO, FLECHAS DE: ADELANTE, ATRAS, ACTUALIZAR-->

<img id="imgUsuID" src="imgs/ODNSFP.png" style="float:right; margin-bottom:5px;" alt="Op Nte" name="<?php echo $_SESSION["usuarioid"]; ?>"/>

  <!--dIV contenedor, base para la posición de la página-->  

 <div id="dir" style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#03F"><b>PRODUCCION</b></div>
 <br>
 <!--MENU-->
	<div>  
      <ul class="menu5">
        <li class="top" onClick="solPedidos();"><a href="#" class="topLink"><b>SOLICITUDES DE MATERIAL</b></a></li>
        <li class="top" onClick="maqIncomp();"><a href="#" class="topLink"><b>MAQ. INCOMPLETAS</b></a></li>
        <li class="top"><a href="#" class="topLink"><b>REPORTES</b></a>
        	<ul class="sm2">
                  <li onClick="reporteMaq();"><a href="#">Historial de Maquinas</a></li>
                  <li onClick="reporteDeMaquinas();"><a href="#">Ubicacion de Maquinas</a></li>
                  <li onClick="reporteOSPR();"><a href="#">Ordenes de Servicio</a></li>
                  <li onClick="reporteInventario();"><a href="#">Catalogo de Piezas</a></li>
                  <li onClick="mostrarReportePedido();"><a href="#">Solicitudes de Material</a></li>
                  <li onClick="ReporteDevolucionMat();"><a href="#">Devoluciones de Material</a></li>
                  <li onClick="reporteCNuevos();"><a href="#">Contratos de Clientes</a></li>
                  <li onClick="buscaPlacas();"><a href="#">Relacion de Placas en Bodega</a></li>
                  <li onClick="reportePlacas();"><a href="#">Relacion de Placas General</a></li>
                  <li onClick="modMaquinas();"><a href="#">Cambiar Estatus de Maquinas</a></li>
            </ul></li>
        <!--<li class="nivel1" onClick="entradasPro();"><a href="#" class="nivel1">ENTRADAS</a></li>
        <li class="nivel1" onClick="inventarioPro();"><a href="#" class="nivel1">INVENTARIO</a></li>-->
        <li class="top" onClick="movMaquinas();"><a href="#" class="topLink"><b>MOVIMIENTO DE MAQUINAS</b></a></li>
        <li class="top" onClick="listaOrden('Produccion');"><a href="#" class="topLink"><b>ORDEN DE SERVICIO</b></a></li>
        <li class="top"><a href="#" class="topLink"><b>ALMACEN</b></a>
        <ul class="sm2">
        <li onClick="pedidoNuevo2();"><a href="#">Solicitar Material</a></li>
        <li onClick="devolucion();"><a href="#">Crear Devolucion</a></li>
        <li onClick="CrearCB();"><a href="#">Codigo de Barras</a></li>
        <li onClick="RelSerieComDos();"><a href="#">Relacionar Componentes</a></li>
        <li onClick="RComponente();"><a href="#">Relación de componentes</a></li>
        <li onClick="impCompSinRel();"><a href="#">Impresion componentes</a></li>
        <!--<li onClick="CodigoBarras();"><a href="#">Còdigo de componentes.</a></li>-->
        <li onClick="conversionMaq();"><a href="#">Conversion de maquinas</a></li>
        </ul></li>
        <!--<li class="top" onClick="conversionMaq();"><a href="#" class="topLink"><b>CONVERSION MAQUINAS</b></a></li>-->
        <li class="top" ><a href="#" class="topLink"><b>CONFIGURACI&Oacute;N</b></a></a>
              <ul class="sm2">
                  <li onClick="cContrasena();"><a href="#">Contrase&ntilde;a</a></li>
              </ul>
        </li>
      </ul>  
        </div> <!--Fin de div menú-->
        </div>
<div style=" position:absolute; margin-top:3px; right:40px;"">
 <span class="spanimgback"><img src="imgs/back.png" border="0" style="cursor:pointer;" alt="Ir a menu de m&oacute;dulos" title="Ir a menu anterior" onClick="irMenuAnterior(<?php echo $_SESSION["usuarioid"]; ?>);"></span>
 <span class="spanimgback"><img src="imgs/reload.png" style="cursor:pointer;" onClick="actualizar(<?php echo $_SESSION["usuarioid"]; ?>);"/></span>
 <span class="spanimgback"> <a	href="../auten/salir.php" ><img src="imgs/exit.png" style="cursor:pointer;" title="Cerrar Sesion" /></a>&nbsp;</span>
</div>
<br>
<!--Muestra lista de pedidos-->
<div id="solPedidosDiv"></div>
<!--FIN Muestra lista de pedidos-->

<!--Muestra lista de maquinas Incompletas-->
<div id="maqIncompletasDiv"></div>
<!--FIN Muestra lista de maquinas Incompletas-->

<!--Muestra reporte de maquinas-->
<div id="reporteMaquinasDiv"></div>
<!--FIN Muestra reporte de maquinas-->
<!--Muestra catalogo de piezas con fotos-->
<div id="ReporteInventarioDiv"></div>
<!--Fin Muestra catalogo de piezas con fotos-->
<div id="inventarioDiv">
<div id="menuInventario"></div>
<div id="busquedaInventario"></div>
</div>
<!--Muestra reporte de maquinas-->
<div id="reporteDeMaquinasDiv"></div>
<!--FIN Muestra reporte de maquinas-->
 <div id="devolucionesMdiv" style="display:none">
     <input type="button" value="Crear Devolucion" onClick="crearDevolucion('Produccion');"><br>
     <span id="spanIngresaPiDe"></span>
     </div>
<!--Muestra reporte de Ordenes-->
<div id="divReporteOS"></div>
<!--Fin reporte de Ordenes-->
<div id="reportePedidosATdiv"></div>
<!--Muestra solicitud de material-->
<div id="pedidoNuevoDiv"></div>
<!--Fin solicitud material-->
<div id="crearCB"></div>
<!--Muestra las entradas recibidas de stock-->
<div id="entradasProDiv"></div>
<!--FIN Muestra las entradas recibidas de stock-->
<div id="ReporteDevolucionesdiv"></div>
<!--Muestra el inventario que hay en Produccion-->
<div id="inventarioProDiv"></div>
<!--FIN Muestra el inventario que hay en Produccion-->

<!--Muestra las maquinas en Bodega-->
<div id="divMaquinasBodegas"></div>
<!--Fin Maquinas bodega-->

<!--Muestra maquinas y placas-->
<div id="divMaquinasPlacas"></div>
<!--Fin maquinas placas-->
<div id="divReporteComponete"></div>
<!--Muestra placas-->
<div id="divReportedePlacas"></div>
<!--Fin placas-->
<div style="display:none" id="divConversionMaq">
Ingresa numero de serie o numero de OS: <input type="text" style='font-size:12px;' size='12' id='inputLicenciaConv' /> &nbsp;&nbsp;&nbsp;
<input id='buscarConversion' style='font-size:12px; margin-top:3px' type='button' value='Buscar' onClick='traeDatosLicenciaConv(1,inputLicenciaConv.value);' >
<br><br>
<div id="divDatosConversion"></div>
<br><br>

</div>
<div id="divRelacionComSerieDos"></div>
<div id="divImpCompMaq"></div>
<div id="divReporteContratos"></div>
<div id="GenCB"></div>
<div id="filtraInvCod"></div>
<!--Cambia contrasena-->
<div id="cContrasenaDiv"></div>
<!--FIN Cambio contrasena-->
<div id="ordenServicioDiv" style="height:85%; font-size:11px; display:none;">
<div id="buscar">
  <table>
    	<tr>
        	<td align="left" style="margin-right:0px;">
            	<img src="imgs/buscar.png" />
            </td>
            <td align="left" style="margin-right:0px; margin-left:0px">
            	<input id='busquedaListaInput' style='font-size:9px; color:#9E9E9E; height:10px; margin-top:3px' size='10' type='text' value='Buscar' onFocus='quitaTexto(this.id);' onKeyUp="listaOrden('Produccion');"  >
            </td>
        </tr>
    </table>
 </div>
<div id="C1ordenServicioDiv" class="caja" style="float:left; width:11%; background-color:#F3DFC5; height:100%; overflow:auto;"></div>
<div id="C2ordenServicioDiv" class="caja" style="float:left; width:37%; background-color:#F0F0F0; margin-left:1%; margin-right:1%; height:100%; overflow:auto;"></div>
<div id="C3ordenServicioDiv" class="caja" style="float:left; width:47%; background-color:#EEF2FB; margin-right:1%; overflow:auto; font-size:11px;"></div>
</div>
<!-- div de maquinas -->
<div id="maquinasDiv" style="display:none">
<div id="drag" style="width:100%; "><div id="origenMaq" style="width:49%; height:370px;float:left;font-size:12px; border-right:#999 solid 1px;"><strong>ORIGEN</strong><br><br>&nbsp;&nbsp;Ubicacion: <select id="selectUbicacion" onChange="traeBusqueda(this.value,1);"><option></option><option value="Bodega">Bodega</option><option value="Sala">Sala</option><option value="Nuevas">Espana</option><option value="contrato">Nuevos Contratos</option></select>&nbsp;&nbsp;<span id="busquedaMaq" style="font-size:12px;"></span><br><br>&nbsp;&nbsp;<span id="spanSeries">Serie:&nbsp;<div id='divBuscaSeries' ></div><input id="inputSerie" type="text" size="7" onKeyUp="traeSeriesMM(this.value,1);">&nbsp;&nbsp;&nbsp;&nbsp;<input id="buscarMaq1" type="button" value="Buscar" onClick="buscaMaquinas(1);"></span>
	 <span  id="spanexportarExcel"></span>&nbsp;<div style="float:left"  id="divpedimentos"></div><span style="float:left" id="div3Pedimentos"></span>&nbsp;
     											<div style="float:left"  id="divcontratos"></div><span style="float:left" id="div3Contratos"></span>
     <div id="divMuestraMaquinas" style="width:99%;overflow:auto;"></div>
     </div>
     <div id="destinoMaq" style="font-size:12px; width:50%;height:auto; padding-left:49%;">&nbsp;&nbsp;<strong>DESTINO</strong><br><br>&nbsp;&nbsp;&nbsp;&nbsp;Ubicacion: <select id="selectUbicacionDes" onChange="traeBusqueda(this.value,2);"><option></option><option value="Bodega">Bodega</option><option value="Sala">Sala</option><option value="contrato">Nuevos Contratos</option><option value="OS">Orden Servicio</option></select>&nbsp;&nbsp;<span id="busquedaMaqDes" style="font-size:12px;"></span><br><br>&nbsp;&nbsp;&nbsp;&nbsp;<!--Serie:&nbsp;&nbsp;<div id='divBuscaSeriesDes' ></div><input id="inputSerieDes" type="text" size="7" onKeyUp="traeSeriesMM(this.value,2);">--><span id="numMaq"></span>&nbsp;&nbsp;<span id="spanOfficeIDdes"></span>&nbsp;&nbsp;&nbsp;&nbsp;<input id="buscarMaq2" type="button" value="Buscar" onClick="buscaMaquinas(2);"><span id="botonPDF"></span>
     <div id="divMuestraMaquinasDes" style=" width:99%;overflow:auto;"></div>
     </div>
     </div><!--cierra drag--> 
<div id="movimientosMaq" style="padding-top:100px">
       <form id='form_mcheckbox' name='form_mcheckbox' action='' method='post'><table id="tablaMovimientos" title="0">
           <caption>Movimientos de Maquinas</caption>
       <thead>
               <tr><th width="100px">SERIE</th><th width="220px">ORIGEN</th><th width="220px">DESTINO</th><th></th></tr></thead>
           <tbody>
       </tbody>
       <div align="right"><input id="inputCadenaMov" type="button" value="Guardar" onClick="guardarMovimientos();"></div>
   </table></form>
   </div>
<!-- fin de div maquinas-->
<!--<div id="contenido" style="width:75%; height:70%; background-color:#FFF; overflow:auto; margin-left:15px; float:left";></div>-->
    </div>
    
    <!-- MODAL PARA LA IMAGENES GARGADAS POS REFACCION -->
    <div id="modal_cargando" class="dimensiones_modal">
        <div class="contenido">
					<div style="width: 100%;top: 40px;" >
						<center> <h1>Cargando...</h1> <p> <i  style="color: #1fa67a;" class="fa fa-spinner fa-spin fa-2x"></i> </p> </center>
					</div>            
        </div>
    </div>
    <div class="muestra_imagen" style="display:none;"></div>

    <div id="modal_imagenes" class="dimensiones_modal" >
        <div class="contenido" style="height: 50%;">
					<div style="width: 100%;display: inline-flex;justify-content: space-between;">
							<p class="title-modal"></p>
							<span class="cerrar" onClick="cerrar_modal_img();"> x</span> 
					</div>
					<div style="width: 100%;top: 40px;text-align: center;" class="contenido-modal">
								
					</div>            
        </div>
    </div>
    <script>
        $(".muestra_imagen").click(function() {
			$(this).toggle();
		 });
        </script>
    <!-- -->
</body>

</HTML>