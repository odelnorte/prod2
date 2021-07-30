// JavaScript Document
var usuarioID=0;var seleccionada='',nueva_seleccionada=''; var tope=0; var a1=new Array(); var maxPestanas = 10;
var valorUbicacion1=''; var valorUbicacion2=''; //var paisID='1';
function usuario(){
usuarioID=document.getElementById('imgUsuID').name;
var n=1;
if(usuarioID!='1' && usuarioID!='51'){
$.ajax({
   url: 'php/cierraSesionCC.php',
   type: 'POST',
   async: true,
   data: 'nx='+n+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){},
   error: Error
   });}
}
//cierra la sesion del usuario
function cierraSesionCC2(){var n=2;
  $.ajax({
  url: 'php/cierraSesionCC.php',
  type: 'POST',
  async: true,
  data: 'usuarioIDx='+usuarioID+'&nx='+n,
  success: function respuesta(result){location.href='../index.html';},
  error: Error
 });
}
// trae lista de pedidos LAGE
function abrirLista(){
	/*var s= "<b>Ver</b> &nbsp;&nbsp;<img src='imgs/abajo2.bmp' id='imgAbajo' style='cursor:pointer; padding-top:5px' onClick='mostrarVentanaVer();'/>&nbsp;&nbsp;&nbsp;&nbsp;<input id='buscaListaFolio' style='float:right; font-size:9px; color:#9E9E9E; height:10px; margin-top:3px' size='10' type='text' value='Buscar' onFocus='quitar(this.id);' onKeyUp='buscaListaFolio(this.value);' >";*/
    $.ajax({
    url: 'php/listaPedidos.php',
    type: 'POST',
   async: true,
   data: '',
   dataType: "text",
   success: function Respuesta(result){
   document.getElementById('listaPedidosDiv').innerHTML = result;
   document.getElementById('listaPedidosDiv').style.width ='190px';
   if(document.getElementById('buscaListaPedido')!=''){document.getElementById('buscaListaPedido').value='';}
  },
   error: Error
   });
}
// muestra plantilla con datos del Pedido
function mostrarPedido(pedido, estatus){//alert(pedido+' '+estatus);
if(document.getElementById(pedido+'Div')){mostrar(pedido);}
else{
	if(tope <= maxPestanas){
   $.ajax({
   url: 'php/mostrarPedido.php',
   type: 'POST',
   async: true,
   data: 'pedidox='+pedido+'&estatusx='+estatus,
   dataType: "text",
   success: function Respuesta(result){
	   
   var div='<div id="'+pedido+'Div"></div>';
   if(seleccionada!=''){document.getElementById(seleccionada+'Div').style.display= "none";}
   insertarPestana(pedido, 'Solicitud '+ pedido); //alert (tope);
   document.getElementById('contenido').innerHTML += div;
   document.getElementById(pedido+'Div').style.display= "block";
   document.getElementById(pedido+'Div').innerHTML = result;
   /*document.getElementById('buscaListaFolio').value= 'Buscar';
   document.getElementById('buscaListaFolio').style.color='#9E9E9E';
   document.getElementById('listaFoliosDiv').value='';buscaListaFolio('%');*/
  },
   error: Error
   });}else{alert("ya no se pueden insertar mas pestanas");}// termina if (tope <= maxPestanas)
   }//termina if(document.getElementById(fol+'Div')){mostrar(fol);
}
function insertarPestana(id,name){
var img='<span class="uno"><img name='+id+' src="imgs/cerrar_folio.gif" style="border:none; padding-bottom:3px" onClick="cerrarPedido(this.name);" /></span>';
var li='<li id='+id+' class="current"><a href="#" ><span title='+id+' onClick="mostrar(this.title);"> '+name+'  </span>'+img+'</a></li>';
   document.getElementById('listaMenu2').innerHTML += li;document.getElementById(id).className = 'current';
		a1[tope]=id;
		tope++;
		
   if(seleccionada!=''){//alert(seleccionada);
   document.getElementById(seleccionada).className = 'nivel';}seleccionada=id;
}
function mostrar(id){//alert(id+" xx "+seleccionada);
if(seleccionada!=''){document.getElementById(seleccionada+'Div').style.display= "none";
document.getElementById(seleccionada).className = 'nivel';}
document.getElementById(id+'Div').style.display= "block";
document.getElementById(id).className = 'current';
seleccionada=id;
document.getElementById('dir').innerHTML='PRODUCCION > Pedido '+id;
}
//cierra pedido
function cerrarPedido(id){//alert(id);
var a2 = new Array();
	var j=-1; fol=''; tope2=-1;
	
	var divCA = document.getElementById(id+'Div'); 
	var cont = divCA.parentNode; 
	cont.removeChild(divCA);
	
	var divPA = document.getElementById(id); 
	var cont2 = divPA.parentNode; 
	cont2.removeChild(divPA);
	
	var actualId=id;
	for(var i=0; i<a1.length; i++) {
		
		if(a1[i]!=actualId){
			j++;
			a2[j]=a1[i];
			}
			else{tope2=i;}
	}	
	if(a1[tope2+1]){fol=a1[tope2+1];}
	else{if(a1[tope2-1]){fol=a1[tope2-1];}
	}//alert (fol);
	if(fol!=''){
	document.getElementById(fol+'Div').style.display= "block";
	document.getElementById(fol).className = 'current';	
    }
	seleccionada=fol;
	a1=a2;tope=j+1;
}
//activa cuadro de texto para agregar piezas
function imgAgregarCantPed(sol, con, clave, serie, cant, n){//alert(sol+' '+con+' '+clave+' '+serie+' '+cant+' '+n+' | '+'imgAgregarCantPed');
//if(n==8){alert(n); guardarCambCantPed(sol, con, clave, serie, cant);
if(cant==' '){cant='';}
if(n==2){var td='tdCamVerPed'; var maxlength='maxlength="10"';
var cText="<input type='text' id='catidad"+sol+con+"' size='2' "+maxlength+" value='"+cant+"' onkeydown='(event.keyCode==13)?guardarCambCantPed("+sol+", "+con+", "+clave+", \""+serie+"\", this.value, "+n+"):null'; />";
		 var imgGuardar="<img src='imgs/guardarPequeno.bmp' id='imgAgregarCantPed"+sol+con+"' style='cursor:pointer;' title='Guardar Cantidad' onClick='guardarCambCantPed("+sol+", "+con+", "+clave+", \""+serie+"\", catidad"+sol+con+".value, "+n+");' />";
		 document.getElementById(td+sol+con).innerHTML='';
		 document.getElementById(td+sol+con).innerHTML=cText+' '+imgGuardar;}
if(n==1){guardarCambCantPed(sol, con, clave, serie, cant, n);}
if(n==3){guardarCambCantPed(sol, con, clave, serie, cant, n);}
}
//activa cuadro de texto para agregar piezas
function guardarCambCantPed(sol, con, clave, serie, cant, n){//alert(sol+' '+con+' '+clave+' '+serie+' '+cant+' '+n+' | '+'guardarCambCantPed');

if(n==2){if(cant=='' || cant==0){alert('El campo no puede estar vacio o en cero'); return false;}}

var imgEditar="<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='imgAgregarCantPed"+sol+con+"' onclick='imgAgregarCantPed("+sol+", "+con+", "+clave+", \""+serie+"\", \""+cant+"\", "+n+");' style='cursor: pointer;'/>";

   $.ajax({
   url: 'php/guardarCambCantPed.php',
   type: 'POST',
   async: true,
   data: 'cantx='+cant+'&solx='+sol+'&conx='+con+'&clavex='+clave+'&seriex='+serie+'&nx='+n+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
	   if(result==2){var td='tdCamVerPed'; 
		   document.getElementById(''+td+''+sol+con).innerHTML='';
		   document.getElementById(''+td+''+sol+con).innerHTML=cant+' '+imgEditar;}
   },
   error: Error
   });
}
//Busca Pedido
function buscaListaPedido(valor){//alert(valor);

	if(valor.length <= 3) return;
	
	$.ajax({
    url: 'php/buscaListaPedido.php',
    type: 'POST',
   async: false,
   data: 'valorx='+valor,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
	   document.getElementById('listaPedidosDiv').innerHTML = result;
   },
   error: Error
   });
}
//muestra Cambiar Contrasena
function cContrasena(){
$.ajax({
   url: '../Vistas/C Contrasena/modificarContrasena.php',
   type: 'POST',
   async: true,
   data: 'usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   		ocultaDivs('PRODUCCION > Cambiar Contrase&ntilde;a', 'cContrasenaDiv');
		document.getElementById("cContrasenaDiv").innerHTML = result;
   },
   error: Error
   });
   document.getElementById('dir').innerHTML='PRODUCCION > Cambiar Contrase&ntilde;a';
}
//LIMPIAR CONTRASENA
function cambiaLimpiaContrasena(actual, nuevac, confn){//alert(actual+" "+ nuevac+" "+ confn);

$.ajax({
		url: '../Vistas/C Contrasena/cContrasena.php',
		type: 'POST',
		async: true,
		data: 'actualx='+actual+'&nuevacx='+nuevac+'&confnx='+confn+'&usuarioIDx='+usuarioID,
		dataType: "text",
		success: function Respuesta(result){//alert(result);
			if(result==1){alert("Su contrase\u00f1a ha sido cambiada correctamente");
						  document.getElementById('contrasena').value='';
						  document.getElementById('ncontrasena').value='';
						  document.getElementById('confcontrasena').value='';
				}else{alert("datos incorrectos");}
			},
error: Error
});								 
}
//muestra el pedido seleccionado
function mostrarPedidoSinFolio(pedido,estatus){
	if(document.getElementById(pedido+'Div')){mostrar(pedido);}
else{
	if(tope <= maxPestanas){
   $.ajax({
   url: 'php/mostrarPedidoSinFolio.php',
   type: 'POST',
   async: true,
   data: 'pedidox='+pedido+'&estatusx='+estatus,
   dataType: "text",
   success: function Respuesta(result){
	   
   var div='<div id="'+pedido+'Div"></div>';
   if(seleccionada!=''){document.getElementById(seleccionada+'Div').style.display= "none";}
   insertarPestana(pedido, 'Solicitud '+ pedido); //alert (tope);
   document.getElementById('contenido').innerHTML += div;
   document.getElementById(pedido+'Div').style.display= "block";
   document.getElementById(pedido+'Div').innerHTML = result;
   },
   error: Error
   });}else{alert("ya no se pueden insertar mas pestanas");}// termina if (tope <= maxPestanas)
   }//termina if(document.getElementById(fol+'Div')){mostrar(fol);
}
//muestra Folio desde Reporte de Folios
function pestanaFolio(fol){//alert('entre'+' '+fol);
if(document.getElementById(fol+'_FolioDiv')){mostrar(fol+'_Folio');}
	else{
		if(tope <= maxPestanas){
$.ajax({
   url: '../Vistas/Reporte Folios/muestraFolioDesdeReporteCC.php',
   type: 'POST',
   async: true,
   data: 'folx='+fol,
   dataType: "text",
   success: function Respuesta(result){
   var div='<div id="'+fol+'_FolioDiv"></div>';
   if(seleccionada!=''){document.getElementById(seleccionada+'Div').style.display= "none";}
   insertarPestana(fol+'_Folio', 'Folio '+fol);
   document.getElementById('contenido').innerHTML += div;
   document.getElementById(""+fol+"_FolioDiv").innerHTML = result;
   },
   error: Error
   });}else{alert("ya no se pueden insertar mas pestañas");}
  }
}
//guarda observaciones del pedido
function guardaObsPedido(obs, sol){//alert(obs);
if(obs=='' || obs==' '){alert('No hay observaciones que guardar'); return false;}
$.ajax({
   url: 'php/guardaObsPedido.php',
   type: 'POST',
   async: true,
   data: 'obsx='+obs+'&solx='+sol+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){
   		document.getElementById('spanObs'+sol).innerHTML=result;
		var elem =document.getElementById('txtObs'+sol);
    	elem.scrollTop = elem.scrollHeight;
		document.getElementById('obs'+sol).innerHTML='';
   },
   error: Error
   });
}
//cambia el color del pedido
function cambiaColorPedido(){
}
//muestra lista de pedidos
function solPedidos(){//alert('hi');
	if(document.getElementById('solPedidosDiv').innerHTML==''){
		$.ajax({
			url: 'php/solPedidos.php',
			type: 'POST',
			async: true,
			data: '',
			dataType: "text",
			success: function Respuesta(result){//alert(result);
					document.getElementById('solPedidosDiv').innerHTML=result;
				abrirLista();
			},
			error: Error
		});
	}
	ocultaDivs('PRODUCCION > Solicitudes de Pedidos', 'solPedidosDiv');
}

//muestra formulario para reporte de maquinas
function reporteMaq(){//alert(val);
	if(document.getElementById('reporteMaquinasDiv').innerHTML==''){
		$.ajax({
			url: 'php/reporteMaq.php',
			type: 'POST',
			async: true,
			data: '',
			success: function resp(result){//alert(result);
				document.getElementById('reporteMaquinasDiv').innerHTML=result;
				ocultaDiv(111);ocultaDiv(222);
			},
			error: Error
		}); 
	}
	ocultaDivs('PRODUCCION > Historial de Maquinas', 'reporteMaquinasDiv');
}
//Busqueda de Reporte de Maquinas
function busquedaReporteMaqAT(txtFHRCalendario111, txtFHRCalendario222, txtSerieAT, selectUbicacionAT, selectRegionAT, selectSalaAT){//alert(txtFHRCalendario111+' | '+txtFHRCalendario222+' | '+txtSerieAT+' | '+selectUbicacionAT+' | '+selectRegionAT+' | '+selectSalaAT);

   $.ajax({
   url: 'php/busquedaReporteMaqAT.php',
   type: 'POST',
   async: true,
   data: 'txtFHRCalendario111x='+txtFHRCalendario111+'&txtFHRCalendario222x='+txtFHRCalendario222+'&txtSerieATx='+txtSerieAT+'&selectUbicacionATx='+selectUbicacionAT+'&selectRegionATx='+selectRegionAT+'&selectSalaATx='+selectSalaAT,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   		document.getElementById('tablaATDiv').innerHTML=result;
   		document.getElementById('tablaATDiv').style.height='500px';
   },
   error: Error
   });//}
}
//trae combos del reporte de maquinas
function traeCombosReporteMaq(valor){//alert(valor);
	$.ajax({
	url: 'php/traeCombosReporteMaq.php',
	type: 'POST',
	async: true,
	data: 'valorx='+valor,
	dataType: "text",
	success: function Respuesta(result){//alert(result);
		document.getElementById('spanCombosAT').innerHTML=result;
		if(valor=='sala'){document.getElementById('spanBotonAT').innerHTML="<input type='submit' value='Buscar' onClick='busquedaReporteMaqAT(txtFHRCalendario111.value, txtFHRCalendario222.value, txtSerieAT.value, selectUbicacionAT.value, selectRegionAT.value, selectSalaAT.value);'>";}
		if(valor=='bodega'){document.getElementById('spanBotonAT').innerHTML="<input type='submit' value='Buscar' onClick='busquedaReporteMaqBodegaAT(txtFHRCalendario111.value, txtFHRCalendario222.value, txtSerieAT.value, selectUbicacionAT.value, selectBodegaAT.value);'>";}
	},
	error: Error
	});
}
//trae salas de la region seleccionada
function traeSalasReg(reg){//alert('dar entrada');
	$.ajax({
	url: 'php/traeSalasReg.php',
	type: 'POST',
	async: true,
	data: 'regx='+reg,
	dataType: "text",
	success: function Respuesta(result){
		document.getElementById('spanSalaAT').innerHTML=result;
	},
	error: Error
	});
}
//Busqueda de Reporte de Maquinas cuando es bodega
  function busquedaReporteMaqBodegaAT(txtFHRCalendario111, txtFHRCalendario222, txtSerieAT, selectUbicacionAT, selectBodegaAT){//alert(txtFHRCalendario111+' | '+txtFHRCalendario222+' | '+txtSerieAT+' | '+selectUbicacionAT+' | '+selectBodegaAT);

   $.ajax({
   url: 'php/busquedaReporteMaqBodegaAT.php',
   type: 'POST',
   async: true,
   data: 'txtFHRCalendario111x='+txtFHRCalendario111+'&txtFHRCalendario222x='+txtFHRCalendario222+'&txtSerieATx='+txtSerieAT+'&selectUbicacionATx='+selectUbicacionAT+'&selectBodegaATx='+selectBodegaAT,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   		document.getElementById('tablaATDiv').innerHTML=result;
   		document.getElementById('tablaATDiv').style.height='500px';
   },
   error: Error
   });//}
}
function movMaquinas(){
	ocultaDivs('PRODUCCION > Movimiento Maquinas', 'maquinasDiv');
}
function traeBusqueda(valor,n){if(n==1){
	
	if(valor=="Bodega")
		document.getElementById('spanexportarExcel').style.display='block';
	else
		document.getElementById('spanexportarExcel').style.display='none';
		
	document.getElementById('divpedimentos').style.display='none';
	document.getElementById('div3Pedimentos').style.display='none';
	
	document.getElementById('divcontratos').style.display='none';
	document.getElementById('div3Contratos').style.display='none';
	
	if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinas').innerHTML = '';document.getElementById('divBuscaSeries').innerHTML = '';} else{var name=document.getElementById('buscarMaq1').name;var arr = name.split('-');
		document.getElementById('selectUbicacion').value=arr[0]; if(arr[0]=='Bodega'){ document.getElementById('selectBodega').value=arr[1];
		document.getElementById('selectRack').value=arr[2]; document.getElementById('selectNivel').value=arr[3];}
		if(arr[0]=='Sala'){document.getElementById('selectRegion').value=arr[1]; document.getElementById('selectSala').value=arr[2];} return -1;} }
else{document.getElementById('divMuestraMaquinas').innerHTML = '';  document.getElementById('divBuscaSeries').innerHTML = '';}
}
if(n==2){if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinasDes').innerHTML = '';} else{var name=document.getElementById('buscarMaq2').name;var arr = name.split('-');
		document.getElementById('selectUbicacionDes').value=arr[0]; if(arr[0]=='Bodega'){ document.getElementById('selectBodegaDes').value=arr[1];
		document.getElementById('selectRackDes').value=arr[2]; document.getElementById('selectNivelDes').value=arr[3];}
		if(arr[0]=='Sala'){document.getElementById('selectRegionDes').value=arr[1]; document.getElementById('selectSalaDes').value=arr[2];} return -1;} }
else{/*document.getElementById('divMuestraMaquinasDes').innerHTML = '';*/}
}
//if(n==2){document.getElementById('divMuestraMaquinasDes').innerHTML = '';}
var tipo=document.getElementById('selectUbicacionDes').value;
   $.ajax({
   url: 'php/traeBusqueda.php',
   type: 'POST',
   async: true,
   data: 'valorx='+valor+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){if(n==1){document.getElementById('busquedaMaq').innerHTML = result;
   if(valor=='Nuevas'){ocultaDiv(123);document.getElementById('spanSeries').style.display= "none";}else{document.getElementById('spanSeries').style.display= "block";}}
   if(n==2 && tipo=='Bodega'){document.getElementById('botonPDF').innerHTML='&nbsp;&nbsp;<input id="tablaPDF" type="button" value="tablaPDF" onClick="tablaPDF();">';}else{document.getElementById('botonPDF').innerHTML='';}
   if(n==2){if(valor=='Sala'){var arr=result.split('||');document.getElementById('busquedaMaqDes').innerHTML = arr[0];document.getElementById('spanOfficeIDdes').innerHTML = arr[1];}else{document.getElementById('busquedaMaqDes').innerHTML = result;} if(tipo=='Sala'){document.getElementById('numMaq').innerHTML='&nbsp;&nbsp;&nbsp;<select id="numMaqSalas" onChange="creaCeldasRack(this.value, 2);"><option value="5">5</option><option value="10">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option><option value="30">30</option></select>'; creaCeldasRack(5, 2); var sala=document.getElementById('selectSalaDes').value;var region=document.getElementById('selectRegionDes').value;   document.getElementById('buscarMaq2').name="Sala-"+region+"-"+sala; }else{document.getElementById('numMaq').innerHTML = '';document.getElementById('spanOfficeIDdes').innerHTML = '';document.getElementById('divMuestraMaquinasDes').innerHTML = ''; }}
   },
   error: Error
   });
}
function traedatosMaq(valor,dato,bod){var n=1;//alert(valor+" "+dato+" "+bod);
document.getElementById('divpedimentos').style.display='none';
document.getElementById('div3Pedimentos').style.display='none';

document.getElementById('divcontratos').style.display='none';
	document.getElementById('div3Contratos').style.display='none';

if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinas').innerHTML = '';} else{var name=document.getElementById('buscarMaq1').name;var arr = name.split('-');
		document.getElementById('selectUbicacion').value=arr[0]; if(arr[0]=='Bodega'){ document.getElementById('selectBodega').value=arr[1];
		document.getElementById('selectRack').value=arr[2]; document.getElementById('selectNivel').value=arr[3];}
		if(arr[0]=='Sala'){document.getElementById('selectRegion').value=arr[1]; document.getElementById('selectSala').value=arr[2];} return -1;} }
else{document.getElementById('divMuestraMaquinas').innerHTML = '';}

document.getElementById('divMuestraMaquinas').innerHTML = '';
	$.ajax({
    url: 'php/traedatosMaq.php',
    type: 'POST',
   async: true,
   data: 'valorx='+valor+'&datox='+dato+'&bodx='+bod,
   dataType: "text",
   success: function Respuesta(result){if(dato==1){document.getElementById('spanRack').innerHTML = result;}
   if(dato==2){document.getElementById('spanNivel').innerHTML = result;}
   if(dato==3){document.getElementById('spanSala2').innerHTML = result;}
   },
   error: Error
   });
}
function traedatosMaq2(valor,dato,bod){var reg=''; var sa='';//document.getElementById('divMuestraMaquinasDes').innerHTML = '';
if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinasDes').innerHTML = '';} else{var name=document.getElementById('buscarMaq2').name;var arr = name.split('-');
		document.getElementById('selectUbicacionDes').value=arr[0]; if(arr[0]=='Bodega'){ document.getElementById('selectBodegaDes').value=arr[1];
		document.getElementById('selectRackDes').value=arr[2]; document.getElementById('selectNivelDes').value=arr[3];}
		if(arr[0]=='Sala'){document.getElementById('selectRegionDes').value=arr[1]; document.getElementById('selectSalaDes').value=arr[2];} return -1;} }
else{/*document.getElementById('divMuestraMaquinasDes').innerHTML = '';*/}

if(dato==6){if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinasDes').innerHTML = '';
	reg=document.getElementById('selectRegionDes').value;
sa=document.getElementById('selectSalaDes').value; document.getElementById('buscarMaq2').name = 'Sala-'+reg+'-'+sa;} else{var name=document.getElementById('buscarMaq2').name;var arr = name.split('-');
		document.getElementById('selectUbicacionDes').value=arr[0]; if(arr[0]=='Bodega'){ document.getElementById('selectBodega').value=arr[1];
		document.getElementById('selectRack').value=arr[2]; document.getElementById('selectNivel').value=arr[3];}
		if(arr[0]=='Sala'){document.getElementById('selectRegionDes').value=arr[1]; document.getElementById('selectSalaDes').value=arr[2];} return -1;} }
else{  reg=document.getElementById('selectRegionDes').value;
sa=document.getElementById('selectSalaDes').value; document.getElementById('buscarMaq2').name = 'Sala-'+reg+'-'+sa;
document.getElementById('buscarMaq2').title = 'Sala,'+reg+','+sa;}}
	$.ajax({
    url: 'php/traedatosMaq.php',
    type: 'POST',
   async: true,
   data: 'valorx='+valor+'&datox='+dato+'&bodx='+bod,
   dataType: "text",
   success: function Respuesta(result){if(dato==4){document.getElementById('spanRackDes').innerHTML = result;}
   if(dato==5){document.getElementById('spanNivelDes').innerHTML = result;}
   if(dato==6){var arr=result.split('||');document.getElementById('spanSalaDes').innerHTML = arr[0];document.getElementById('spanOfficeIDdes').innerHTML = arr[1];}
   },
   error: Error
   });
}
function traeSeriesMM(valor,n){//alert(valor+'|'+n);
	if(valor=='' || valor==' '){document.getElementById('divBuscaSeries').innerHTML = ''; document.getElementById('divBuscaSeries').style.height='0px'; return -1;
	}else{
	var ubi=document.getElementById('selectUbicacion').value; //alert(ubi); return false;
	
	/*if(ubi=='%'){var cadena='ubix='+ubi+'&valorx='+valor; }*/
	
	if(ubi=='Bodega'){var bodega=document.getElementById('selectBodega').value; var rack=document.getElementById('selectRack').value; var nivel=document.getElementById('selectNivel').value; var cadena='ubix='+ubi+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&valorx='+valor; /*alert(cadena);*/}
	
	if(ubi=='Sala'){var salaid=document.getElementById('selectSala').value; if(n==3){var cadena='ubix='+ubi+'&salaidx='+salaid+'&valorx='+'%';}else{var cadena='ubix='+ubi+'&salaidx='+salaid+'&valorx='+valor;} /*alert(cadena);*/}

   $.ajax({
   url: '../Vistas/Mov de Maquinas/traeSeriesMM.php',
   type: 'POST',
   async: true,
   data: cadena,
   dataType: "text",
   success: function Respuesta(result){/*alert('|'+result+'|');*/if(document.getElementById('divMuestraMaquinas').innerHTML!=''){/*alert('lleno');*/document.getElementById('divMuestraMaquinas').innerHTML='';}
   document.getElementById('divBuscaSeries').innerHTML = result; document.getElementById('divBuscaSeries').style.overflow='auto'; document.getElementById('divBuscaSeries').style.height='300px'; inicio(); desabilita(); 
   },
   error: Error
   });
	}
}
function buscaMaquinas(n){var d=''; var salaid=''; 
var ubi=document.getElementById('selectUbicacion').value;
if(n==1 && ubi=='Sala'){salaid=document.getElementById('selectSala').value; /*alert(salaid);*/ traeSeriesMM(salaid,3);
}else{
	if(n==1){if(document.getElementById('divBuscaSeries').innerHTML!=''){document.getElementById('divBuscaSeries').innerHTML='';document.getElementById('inputSerie').value='';document.getElementById('divBuscaSeries').style.height='0px';}
	var ubi=document.getElementById('selectUbicacion').value;d='buscarMaq1';}
    else{var ubi=document.getElementById('selectUbicacionDes').value;d='buscarMaq2';}
	
	if(ubi=='Bodega'){if(n==1){var bodega=document.getElementById('selectBodega').value;
	var rack=document.getElementById('selectRack').value; var nivel=document.getElementById('selectNivel').value;}
	else{var bodega=document.getElementById('selectBodegaDes').value;
	var rack=document.getElementById('selectRackDes').value; var nivel=document.getElementById('selectNivelDes').value;}
	
	document.getElementById(d).name="Bodega-"+bodega+"-"+rack+"-"+nivel; /*alert(bodega+" "+rack+" "+nivel);*/
	$.ajax({
    url: 'php/muestraTablaMaquinas.php',
    type: 'POST',
   async: true,
   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){if(n==1){document.getElementById('divMuestraMaquinas').innerHTML = result;inicio();   maquinasSinContratos(bodega,rack,nivel);  }
   else{document.getElementById('divMuestraMaquinasDes').innerHTML = result;inicio();}  },
   error: Error
   });
}

if(ubi=='OS'){var ordenid=document.getElementById('selectOS').value; //if(destino=='OS'){var os=document.getElementById('selectBodega').value;
	$.ajax({
    url: 'php/maquinasOS.php',
    type: 'POST',
   async: true,
   data: 'ordenidx='+ordenid+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){var dato=result.split('|*|');
	document.getElementById('spanDivOS').innerHTML = dato[1];
	document.getElementById('divMuestraMaquinasDes').innerHTML = dato[0]; inicio();
   },
   error: Error
   });
		}//}
if(ubi=='contrato'){//alert(ordenid+" "+bodega+" "+rack+" "+nivel+" ---"+n);
if(n==1){var contratoid=document.getElementById('selectContratosIni').value; //if(destino=='OS'){var os=document.getElementById('selectBodega').value;
}
if(n==2){var contratoid=document.getElementById('selectContratos').value; }

	$.ajax({
    url: 'php/maquinasContratoOS.php',
    type: 'POST',
   async: true,
   data: 'contratoidx='+contratoid+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){var dato=result.split('|*|');
	
	if(n==1){document.getElementById('divMuestraMaquinas').innerHTML = dato[0];inicio();}
	if(n==2){document.getElementById('spanDivContratos').innerHTML = dato[1];
		document.getElementById('divMuestraMaquinasDes').innerHTML = dato[0]; inicio();}
	//select * from cusuario
   },
   error: Error
   });
//}//fin if n==2
if(n==1){
//var contratoid=document.getElementById('selectContratosIni').value; alert(contratoid);
	/*$.ajax({
    url: 'php/maquinasContratoOS.php',
    type: 'POST',
   async: true,
   data: 'contratoidx='+contratoid+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){var dato=result.split('|*|');
	document.getElementById('spanDivContratos').innerHTML = dato[1];
	document.getElementById('divMuestraMaquinasDes').innerHTML = dato[0]; inicio();
   },
   error: Error
   });*/
}//fin if n==1
		}
 if(ubi=='Sala'){var destino=document.getElementById('selectSalaDes').value; if(destino=='Bodega'){var sala=document.getElementById('selectsala').value;  /*var region=document.getElementById('selectRegion').value;
 document.getElementById(d).name="Sala-"+region+"-"+sala;*/
	$.ajax({
    url: 'php/muestraTablaMaquinas.php',
    type: 'POST',
   async: true,
   data: 'salax='+sala+'&rackx='+rack+'&nivelx='+nivel,
   dataType: "text",
   success: function Respuesta(result){document.getElementById('divBuscaSeries').innerHTML = result;
   },
   error: Error
   });
	}else{document.getElementById('divMuestraMaquinasDes').innerHTML = '';}}}
	
	if(n==1 && ubi=='Bodega')
	{
		document.getElementById('spanexportarExcel').style.display='block';
		var bodega=document.getElementById('selectBodega').value;
		 document.getElementById('spanexportarExcel').innerHTML = '<img src="imgs/export_to_excel.gif" id="imgExportar" style="cursor:pointer"  onClick="ExportarExcelPedimento(\''+bodega+'\',\''+rack+'\',\''+nivel+'\')">';
		 
		$.ajax({
		url: '../Vistas/Mov de Maquinas/traePedimentos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&opcionx='+n,
	   dataType: "text",
	   success: function Respuesta(result){
		   document.getElementById('divpedimentos').style.display='block';
	   	   document.getElementById('divpedimentos').innerHTML = result;
	   },
	   error: Error
	   });
	   
	   $.ajax({
		url: '../Vistas/Mov de Maquinas/trae3Pedimentos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&opcionx='+n,
	   dataType: "text",
	   success: function Respuesta(result){//alert(result); 
		   document.getElementById('div3Pedimentos').style.display='block';
	   	   document.getElementById('div3Pedimentos').innerHTML = result;
	   },
	   error: Error
	   });
	   
	   
	    //Muestra combo de contratos para marcar maquinas con contrato asignado
	   
	   $.ajax({
		url: '../Vistas/Mov de Maquinas/traeContratos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&opcionx='+n,
	   dataType: "text",
	   success: function Respuesta(result){
		   document.getElementById('divcontratos').style.display='block';
	   	   document.getElementById('divcontratos').innerHTML = result;
	   },
	   error: Error
	   });
	}
}
/*function cargaArc() {//alert("entra");
	var tagjs = document.createElement("script");
	tagjs.setAttribute("type", "text/javascript");
	tagjs.setAttribute("src", "php/script.js");
	document.getElementsByTagName("head")[0].appendChild(tagjs);
}*/
//function seleccionaSerie(){}
//crea un movimiento por cada movimiento de maquina
function creaMovimiento(serie,maquina, posicion){//alert(serie+' | '+maquina+' | '+posicion);
var tipo=document.getElementById('selectUbicacion').value;//alert(tipo);
var destino=document.getElementById('selectUbicacionDes').value;
if(tipo=='Sala'){
	if(destino=='Sala'){var salaidO=document.getElementById('selectSala').value; var salaidD=document.getElementById('selectSalaDes').value;
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&salaidOx='+salaidO+'&salaidDx='+salaidD;
		
	if(destino=='OS'){var ordenid=document.getElementById('selectOS').value;//alert(ordenid);
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&ordenidx='+ordenid;
	}
	}else{
var bodega=document.getElementById('selectBodegaDes').value;
var rack=document.getElementById('selectRackDes').value; var nivel=document.getElementById('selectNivelDes').value;
var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&destinox='+destino;}

var conv=document.getElementById('tablaMovimientos').title;
var con=parseInt(conv); var con2=con+1;
var table = document.getElementById('tablaMovimientos'); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;

var check='';
var cell, text;
//alert(bodega+' |' +rack+' |' +nivel+' | '+posicion);
  $.ajax({
  url: 'php/creaMovimientoSala.php',
  type: 'POST',
  async: true,
  data: cadena,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
  		var dato=result.split('||');
		if(tipo=='Sala' && destino=='Sala'){var pos=posicion.split('-'); //alert('entre');
		check='<input type="checkbox" name="'+dato[5]+'--'+maquina+'--'+dato[4]+'--'+dato[0]+'--'+dato[2]+'--'+dato[3]+'" checked />';//alert(check);
		btnCancela='<img src="imgs/cancela.png" title="Cancelar" name="'+dato[5]+'--'+maquina+'--'+'sala'+pos[1]+'--'+dato[0]+'" onclick="cancela3(this.name,this);">';}
		
		else{check='<input type="checkbox" name="'+dato[5]+'--'+maquina+'--'+dato[4]+'--'+dato[0]+'--'+dato[2]+'--'+dato[3]+'" checked />';
		btnCancela='<img src="imgs/cancela.png" title="Cancelar" name="'+dato[5]+'--'+maquina+'--'+dato[4]+'--'+dato[0]+'" onclick="cancela3(this.name,this);">';}
        
        celSerie = row.insertCell(-1);  text1 = dato[0];  celSerie.innerHTML=text1;
        celOrigen = row.insertCell(-1);  text2 = dato[1];  celOrigen.innerHTML=text2;
		//celOrigen.style.background='#CCC';
        celDestino = row.insertCell(-1);  text3 = dato[3];  celDestino.innerHTML=text3;
        celCheck = row.insertCell(-1);  text4 = check;  celCheck.innerHTML=text4;
		celCancela = row.insertCell(-1); text5 = btnCancela;  celCancela.innerHTML=text5;
        document.getElementById('tablaMovimientos').title=con2;
  },
  error: Error
  });
}if(tipo=='Bodega'){var n=1;

	if(destino=='OS'){var ordenid=document.getElementById('selectOS').value;//alert(ordenid);
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&ordenidx='+ordenid;
	}
	else{
		if(destino=='contrato'){var contratoid=document.getElementById('selectContratos').value;//alert(ordenid);
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&contratoidx='+contratoid;
	}else{
	if(destino=='Sala'){var salaid=document.getElementById('selectSalaDes').value;
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&salaidx='+salaid;
	}else{
	var bodega=document.getElementById('selectBodegaDes').value;
	var rack=document.getElementById('selectRackDes').value; var nivel=document.getElementById('selectNivelDes').value;
	var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n+'&destinox='+destino;}
	}
	}//else destino= contrato
	var conv=document.getElementById('tablaMovimientos').title;
	var con=parseInt(conv); var con2=con+1;
	var table = document.getElementById('tablaMovimientos'); 
	var row = table.insertRow(-1);
	row.id='rowEnt'+con;
	var cell, text;

	  $.ajax({
	  url: 'php/creaMovimiento.php',
	  type: 'POST',
	  async: true,
	  data: cadena,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
                  var cadenas=result.split('|s|');
				  var cad1=cadenas[0];
				  var cad2=cadenas[1];
				  var origen=cad1.split('||');  //origen[0];
				  var destino=cad2.split('||');  //destino[0];
                  
                 celSerie = row.insertCell(-1);  text1 = serie;  celSerie.innerHTML=text1;
                 celOrigen = row.insertCell(-1);  text2 = origen[1];  celOrigen.innerHTML=text2;
                 celDestino = row.insertCell(-1);  text3 = destino[1];  celDestino.innerHTML=text3;
				 var solicitudOS = document.getElementById(destino[0]).title; //alert(solicitudOS);
               celCheck = row.insertCell(-1);  text4 = '<input type="checkbox" checked title="'+serie+'" name="'+maquina+'--bodega-'+origen[0]+'--bodega-'+destino[0]+'--'+solicitudOS+'">';  celCheck.innerHTML=text4;
			   celCancela = row.insertCell(-1); text5 = '<img src="imgs/cancela.png" title="Cancelar" name="'+maquina+'--'+origen[0]+'--'+destino[0]+'--'+serie+'" onclick="cancela(this.name,this);">';  celCancela.innerHTML=text5;
                 document.getElementById('tablaMovimientos').title=con2;},
  error: Error
  });}
   /////////////////////////Contratos/////////////////
  if(tipo=='contrato'){var n=1;

	if(destino=='OS'){var ordenid=document.getElementById('selectOS').value;//alert(ordenid);
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&ordenidx='+ordenid;
	}
	else{
		if(destino=='contrato'){var contratoid=document.getElementById('selectContratos').value;//alert(ordenid);
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&contratoidx='+contratoid;
	}else{
	if(destino=='Sala'){var salaid=document.getElementById('selectSalaDes').value;
		var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&destinox='+destino+'&salaidx='+salaid;
	}else{
	var bodega=document.getElementById('selectBodegaDes').value;
	var rack=document.getElementById('selectRackDes').value; var nivel=document.getElementById('selectNivelDes').value;
	var cadena='maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n+'&destinox='+destino;}
	}
	}//else destino= contrato
	var conv=document.getElementById('tablaMovimientos').title;
	var con=parseInt(conv); var con2=con+1;
	var table = document.getElementById('tablaMovimientos'); 
	var row = table.insertRow(-1);
	row.id='rowEnt'+con;
	var cell, text;

	  $.ajax({
	  url: 'php/creaMovimiento.php',
	  type: 'POST',
	  async: true,
	  data: cadena,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
                  var cadenas=result.split('|s|');
				  var cad1=cadenas[0];
				  var cad2=cadenas[1];
				  var origen=cad1.split('||');  //origen[0];
				  var destino=cad2.split('||');  //destino[0];
                  
                 celSerie = row.insertCell(-1);  text1 = serie;  celSerie.innerHTML=text1;
                 celOrigen = row.insertCell(-1);  text2 = origen[1];  celOrigen.innerHTML=text2;
                 celDestino = row.insertCell(-1);  text3 = destino[1];  celDestino.innerHTML=text3;
				 var solicitudOS = document.getElementById(destino[0]).title; //alert(solicitudOS);
               celCheck = row.insertCell(-1);  text4 = '<input type="checkbox" checked title="'+serie+'" name="'+maquina+'--bodega-'+origen[0]+'--bodega-'+destino[0]+'--'+solicitudOS+'">';  celCheck.innerHTML=text4;
			   celCancela = row.insertCell(-1); text5 = '<img src="imgs/cancela.png" title="Cancelar" name="'+maquina+'--'+origen[0]+'--'+destino[0]+'--'+serie+'" onclick="cancela(this.name,this);">';  celCancela.innerHTML=text5;
                 document.getElementById('tablaMovimientos').title=con2;},
  error: Error
  });}
  ////////////////////////Fin Contratos/////////////
  if(tipo=='Nuevas'){var n=2;//alert(serie+' | '+maquina+' | '+posicion);
  var bodega=document.getElementById('selectBodegaDes').value;
var rack=document.getElementById('selectRackDes').value; var nivel=document.getElementById('selectNivelDes').value;
var conv=document.getElementById('tablaMovimientos').title;
var con=parseInt(conv); var con2=con+1;
var table = document.getElementById('tablaMovimientos'); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;
var cell, text;
  $.ajax({
  url: 'php/creaMovimiento.php',
  type: 'POST',
  async: true,
  data: 'maquinax='+maquina+'&seriex='+serie+'&posicionx='+posicion+'&bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&nx='+n,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
                  var cadenas=result.split('|s|');
				  var cad1=cadenas[0];
				  var cad2=cadenas[1];
				  var origen=cad1.split('||');  //origen[0];
				  var destino=cad2.split('||');  //destino[0];
                 celSerie = row.insertCell(-1);  text1 = serie;  celSerie.innerHTML=text1;
                 celOrigen = row.insertCell(-1);  text2 = origen[1];  celOrigen.innerHTML=text2;
                 celDestino = row.insertCell(-1);  text3 = destino[1];  celDestino.innerHTML=text3;
               celCheck = row.insertCell(-1);  text4 = '<input type="checkbox" checked title="'+serie+'" name="'+maquina+'--bodega-'+origen[0]+'--bodega-'+destino[0]+'">';  celCheck.innerHTML=text4;
			   celCancela = row.insertCell(-1); text5 = '<img src="imgs/cancela.png" title="Cancelar" name="'+maquina+'--'+origen[0]+'--'+destino[0]+'--'+serie+'" onclick="cancela2(this.name,this);">';  celCancela.innerHTML=text5;
                 document.getElementById('tablaMovimientos').title=con2;},
  error: Error
  });
}
revPedimento(serie,maquina);
}
function revPedimento(serie,maquina){//alert(maquina);
  $.ajax({
  url: 'php/revPedimento.php',
  type: 'POST',
  async: true,
  data: 'maquinax='+maquina,
  dataType: "text",
  success: function respuesta(result){//alert(result);
	  if(result=='SinP'){alert('La serie '+serie+' No tiene Pedimento');}
	  },
  error: Error
 });
}
function guardarMovimientos(){//alert(telefono);
var tipo=document.getElementById('selectUbicacion').value;
var destino=document.getElementById('selectUbicacionDes').value;
//alert(tipo+" -- "+destino);
if(tipo=='Sala'){
	var listaMov = ''; var listaDes = '';
	var	form = document.forms["form_mcheckbox"];
	for (i=0;i<form.elements.length;i++){
    	if(form.elements[i].type == "checkbox" && form.elements[i].checked==1){listaMov=(form.elements[i].name+',').concat(listaMov); /*alert(listaMov);*/}
		else{listaDes=(form.elements[i].name+',').concat(listaDes);}
	}
	if(listaMov!='' || listaDes!=''){//alert('llena');
	$.ajax({
  	url: '../Vistas/Mov de Maquinas/realizaMovimientos.php',
 	type: 'POST',
  	async: true,
  	data: 'listaMovx='+listaMov+'&listaDesx='+listaDes+'&destinox='+destino+'&usuarioIDx='+usuarioID,
  	dataType: "text",
  	success: function Respuesta(result){
		var ta=' <form id="form_mcheckbox" name="form_mcheckbox" action="" method="post"><table id="tablaMovimientos" title="0">           <caption>Movimientos de Maquinas</caption>       <thead>               <tr><th width="100px">SERIE</th><th width="220px">ORIGEN</th><th width="220px">DESTINO</th><th></th></tr></thead>           <tbody>       </tbody>       <div align="right"><input id="inputCadenaMov" type="button" value="Guardar" onClick="guardarMovimientos();"></div>   </table></form>';
		buscaMaquinas(2);
		document.getElementById('movimientosMaq').innerHTML = ta;
		document.getElementById('divBuscaSeries').innerHTML = '';
		document.getElementById('divBuscaSeries').style.height = '0px';
		document.getElementById('inputSerie').value = '';
		alert('Movimientos realizados');
  	},
  	error: Error
 	});}else{alert('No se ha realizado movimientos'); return false;}
}else{var n=1; 
if(tipo=='Nuevas'){n=2;}
var listaMsg = ''; var listaDes = '';

var	form = document.forms["form_mcheckbox"];
if(form!=undefined){//alert('hi');
//if(document.getElementById('copiaUsuario').checked==1){copia=1; }
for (i=0;i<form.elements.length;i++){
    if(form.elements[i].type == "checkbox" && form.elements[i].checked==1){listaMsg=(form.elements[i].name+',,').concat(listaMsg);/*alert(listaMsg);*/}
	else{listaDes=(form.elements[i].name+',').concat(listaDes);}
    }
if(destino=='Sala'){var salaid=document.getElementById('selectSalaDes').value; var cadena='listaMsgx='+listaMsg+'&usuarioIDx='+usuarioID+'&nx='+n+'&destinox='+destino+'&salaidx='+salaid;}else{var cadena='listaMsgx='+listaMsg+'&listaDesx='+listaDes+'&usuarioIDx='+usuarioID+'&nx='+n+'&destinox='+destino;} 
if(destino=='contrato'){var contratoid=document.getElementById('selectContratos').value;
var motivo=document.getElementById('selectMotivoMaqCont').value;
cadena=cadena+'&contratoidx='+contratoid+'&motivox='+motivo;}
	}else{alert('No Existen Movimientos'); return false;}
	var ta=' <form id="form_mcheckbox" name="form_mcheckbox" action="" method="post"><table id="tablaMovimientos" title="0">           <caption>Movimientos de Maquinas</caption>       <thead>               <tr><th width="100px">SERIE</th><th width="220px">ORIGEN</th><th width="220px">DESTINO</th><th></th></tr></thead>           <tbody>       </tbody>       <div align="right"><input id="inputCadenaMov" type="button" value="Guardar" onClick="guardarMovimientos();"></div>   </table></form>';
//alert(cadena);
$.ajax({
  url: '../Vistas/Mov de Maquinas/guardaMovimientos.php',
  type: 'POST',
  async: true,
  data: cadena,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
	  if(destino!='Sala'){if(n==1){buscaMaquinas(1);}buscaMaquinas(2);document.getElementById('movimientosMaq').innerHTML = ta;
	  if(destino=='contrato'){if(result=='ocupado'){alert("La maquina ya se encuentra asignada a un contrato"); return -1;} /*enviaCorreoContrato(cadena);*/  }
	  }//destino!=sala
	  else{document.getElementById('movimientosMaq').innerHTML = ta; buscaMaquinas(1); creaCeldasRack(5, 2);}
	  if(n==2){var divs = document.getElementById("maquinasNuevas").getElementsByTagName("div"); if(divs.length==0){document.getElementById('ingresarMaqs').disabled=false;}} alert('Movimientos realizados');},
  error: Error
 });}

if(destino=='OS'){
var motivo=document.getElementById('selectMotivoMaq').value;//alert(motivo);
var ordenid=document.getElementById('selectOS').value; var cadena='listaMsgx='+listaMsg+'&usuarioIDx='+usuarioID+'&nx='+n+'&destinox='+destino+'&ordenidx='+ordenid+'&motivox='+motivo;//}
//else{var cadena='listaMsgx='+listaMsg+'&listaDesx='+listaDes+'&usuarioIDx='+usuarioID+'&nx='+n+'&destinox='+destino;} 

	//}else{alert('No Existen Movimientos'); return false;}
	var ta=' <form id="form_mcheckbox" name="form_mcheckbox" action="" method="post"><table id="tablaMovimientos" title="0">           <caption>Movimientos de Maquinas</caption>       <thead>               <tr><th width="100px">SERIE</th><th width="220px">ORIGEN</th><th width="220px">DESTINO</th><th></th></tr></thead>           <tbody>       </tbody>       <div align="right"><input id="inputCadenaMov" type="button" value="Guardar" onClick="guardarMovimientos();"></div>   </table></form>';
//alert(cadena);
$.ajax({
  url: '../Vistas/Mov de Maquinas/guardaMovimientos.php',
  type: 'POST',
  async: true,
  data: cadena,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
  var arr = result.split('||');//alert(arr[1]);
  	if(arr[1]==1){alert("La maquina se encuentra asignada a la OS "+ arr[2]); return -1;}
	if(arr[1]==2){alert("Debe de existir un Contrato para asignar series"); return -1;}
  	if(arr[1]==0){alert("Se deben asignar series del CONTRATO correcto. El correcto es "+arr[2]); return -1;}
	if(result=='muebleDiferente'){alert("El MODELO es diferente al solicitado, elige el Modelo correcto"); return -1;}
	  if(destino!='Sala'){if(n==1){buscaMaquinas(1);}buscaMaquinas(2);document.getElementById('movimientosMaq').innerHTML = ta;}
	  else{document.getElementById('movimientosMaq').innerHTML = ta; buscaMaquinas(1); creaCeldasRack(5, 2);}
	  if(n==2){var divs = document.getElementById("maquinasNuevas").getElementsByTagName("div"); if(divs.length==0){document.getElementById('ingresarMaqs').disabled=false;}} /*alert('Movimientos realizados');*/enviaCorreoOS(cadena);},
  error: Error
 });}
 
}

function enviaCorreoContrato(cadena){//alert(cadena+" "+n);
//se comenta por que ya no hay destinatarios a quien enviar el correo
/*var contratoid=document.getElementById('selectContratos').value;
var motivo=document.getElementById('selectMotivoMaqCont').value;
var n=1;
cadena=cadena+'&contratoidx='+contratoid+'&motivox='+motivo+'&nx='+n;
  $.ajax({
  url: 'php/envCorreoContrato.php',
  type: 'POST',
  async: true,
  data: cadena,
  dataType: "text",
  success: function respuesta(result){//alert(result);
	  },
  error: Error
 });*/
}
function enviaCorreoOS(cadena){//alert(cadena+" "+n);
var ordenid=document.getElementById('selectOS').value;
var motivo=document.getElementById('selectMotivoMaq').value;
var n=2;
cadena=cadena+'&ordenidx='+ordenid+'&motivox='+motivo+'&nx='+n;
  $.ajax({
  url: 'php/envCorreoContrato.php',
  type: 'POST',
  async: true,
  data: cadena,
  dataType: "text",
  success: function respuesta(result){//alert(result);
	  },
  error: Error
 });
}

function cancela(valor,imagen){var datos=valor.split('--');//alert(valor);
var color="rgb(128, 192, 255)";
var bool=false;

if(document.getElementById(datos[0]).style.backgroundColor==color)
{
	bool=true;
}

var div="<div id="+datos[0]+" class='drag orange climit1_2' title='"+datos[3]+"' >"+datos[3]+"</div>";
if(document.getElementById(datos[1])){document.getElementById(datos[1]).innerHTML = div;}
document.getElementById(datos[2]).innerHTML = '';  document.getElementById(datos[2]).className='';
transito(datos[0]);inicio();
remove(imagen); desabilita();
if(bool)
	document.getElementById(datos[0]).style.backgroundColor="#80c0ff";

}
function cancela2(valor,imagen){var datos=valor.split('--');//alert(valor);
var div="<div id="+datos[0]+" class='drag orange climit1_2' title='"+datos[3]+"' >"+datos[3]+"</div>";
document.getElementById('Div'+datos[0]).innerHTML = div;
document.getElementById(''+datos[2]).innerHTML = '';  document.getElementById(''+datos[2]).className='';
inicio();
remove(imagen); desabilita();

if(bool)
	document.getElementById(datos[0]).style.backgroundColor="#80c0ff";



}
function cancela3(valor,imagen){/*alert(valor+' | '+imagen);*/var datos=valor.split('--');//alert(datos[1]);
var div="<div id="+datos[0]+" class='drag orange climit1_2' title='"+datos[3]+"' >"+datos[3]+"</div>";
if(document.getElementById('td'+datos[1])){document.getElementById('td'+datos[1]).innerHTML = div;}
document.getElementById(datos[2]).innerHTML = '';  document.getElementById(datos[2]).className='';
transito(datos[0]); inicio();
remove(imagen); desabilita();
}
function remove(t){//alert('remove');
	  var td = t.parentNode;
	  var tr = td.parentNode;
	  var table = tr.parentNode;
	  table.removeChild(tr);var con= document.getElementById('tablaMovimientos').title;
	  var con2=con-1;
   document.getElementById('tablaMovimientos').title=con2;
}
//cambia el estatus del transito de una maquina
function transito(maquinaid){
$.ajax({
  url: 'php/transito.php',
  type: 'POST',
  async: true,
  data: 'maquinaidx='+maquinaid,
  dataType: "text",
  success: function Respuesta(result){},
  error: Error
});
}
function desabilita(){/*alert('deshabilita');*/var listaMsg = ''; var copia=0; var ids='';
var	form = document.forms["form_mcheckbox"];
if(form!=undefined){
for (i=0;i<form.elements.length;i++){
    if(form.elements[i].type == "checkbox"){ids=form.elements[i].name.split('--');/*alert(ids[0]);*/desabilita2(ids[0]);}
}}
}
function ingresarMaq(){
var pedimento=document.getElementById('inputPedimento').value;
var fechaPed=document.getElementById('txtFHRCalendario123').value;
var costo=document.getElementById('inputCosto').value;//alert(fechaPed+'|'+costo);
var factura=document.getElementById('inputFactura').value;  
var certificado=document.getElementById('inputCertificado').value;
var cantidad=document.getElementById('inputCantidad').value;
var prefijo=document.getElementById('inputPrefijo').value; 
var sufijo=document.getElementById('inputSufijo').value; 
var modelo=document.getElementById('selectModelo').value;
var mueble=document.getElementById('selectMueble').value;
var fabricante=document.getElementById('selectFabricante').value;
if(!/^([0-9])*[.]?[0-9]*$/.test(costo)){alert("El valor del campo costo debe ser numerico"); return false;}
if(!/^([0-9])*[.]?[0-9]*$/.test(cantidad)){alert("El valor del campo cantidad debe ser numerico"); return false;}
if(!/^([0-9])*[.]?[0-9]*$/.test(prefijo)){alert("El valor del campo prefijo debe ser numerico"); return false;}
if(!/^([0-9])*[.]?[0-9]*$/.test(sufijo)){alert("El valor del campo sufijo debe ser numerico"); return false;}
if(modelo=='D2BLACK1' && cantidad>42){alert("No se puede ingresar mas de 42 maquinas modelo D2BLACK1"); return false;}
if(modelo=='D2BLUEW1' && cantidad>55){alert("No se puede ingresar mas de 55 maquinas modelo D2BLUEW1"); return false;}
$.ajax({
  url: 'php/ingresaMaquinas.php',
  type: 'POST',
  async: true,
  data: 'pedx='+pedimento+'&fechaPedx='+fechaPed+'&costox='+costo+'&facturax='+factura+'&certificadox='+certificado+'&canx='+cantidad+'&prefijox='+prefijo+'&sufijox='+sufijo+'&modelox='+modelo+'&mueblex='+mueble+'&fabx='+fabricante,
  dataType: "text",
  success: function Respuesta(result){document.getElementById('divMuestraMaquinas').innerHTML = result;
  									  document.getElementById('ingresarMaqs').disabled=true;},
  error: Error
});
}
function guardaSerieMN(valor,maq){//alert(valor+" "+maq);
var arr=maq.split('--');
$.ajax({
  url: 'php/guardaSerieMN.php',
  type: 'POST',
  async: true,
  data: 'valorx='+valor+'&maqx='+maq,
  dataType: "text",
  success: function Respuesta(result){document.getElementById('inputMN'+arr[0]).style.color='#666';
    document.getElementById('inputMN'+arr[0]).style.border='none'; document.getElementById('inputMN'+arr[0]).readOnly=true;
	document.getElementById('inputMN'+arr[0]).blur(); },//readonly
  error: Error
 });
}
function editarSer(id){document.getElementById(id).style.color='#000'; document.getElementById(id).style.border='1px';
document.getElementById(id).readOnly=false;}
function traeTablaMaqNuevas(ped,fac){//alert(ped,fac);
$.ajax({
  url: 'php/traeTablaMaqNuevas.php',
  type: 'POST',
  async: true,
  data: 'pedx='+ped+'&facx='+fac,
  dataType: "text",
  success: function Respuesta(result){document.getElementById('divMuestraMaquinas').innerHTML = result;inicio();},//readonly
  error: Error
 });
}
//crea creaCeldasRack
function creaCeldasRack(celdas,num){//alert(celdas+' | '+num);
	$.ajax({
	url: 'php/creaCeldasRack.php',
	type: 'POST',
	async: true,
	data: 'celdasx='+celdas+'&numx='+num,
	dataType: "text",
	success: function Respuesta(result){
		document.getElementById('divMuestraMaquinasDes').innerHTML=result;
		inicio();
	},
	error: Error
	});
}
function cambiaNivel(n){
if(n==1){
	document.getElementById('divpedimentos').style.display='none';
	document.getElementById('div3Pedimentos').style.display='none';
	
	if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinas').innerHTML = '';} else{var name=document.getElementById('buscarMaq1').name;var arr = name.split('-');
		document.getElementById('selectUbicacion').value=arr[0];  document.getElementById('selectBodega').value=arr[1];
		document.getElementById('selectRack').value=arr[2]; document.getElementById('selectNivel').value=arr[3]; return -1;} }
else{document.getElementById('divMuestraMaquinas').innerHTML = '';}
}
if(n==2){if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinas').innerHTML = '';} else{var name=document.getElementById('buscarMaq2').name;var arr = name.split('-');
		document.getElementById('selectUbicacionDes').value=arr[0];  document.getElementById('selectBodegaDes').value=arr[1];
		document.getElementById('selectRackDes').value=arr[2]; document.getElementById('selectNivelDes').value=arr[3]; return -1;} }
else{document.getElementById('divMuestraMaquinasDes').innerHTML = '';}
}
}
function cambiaSala(n){if(n==1){if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinas').innerHTML = '';} else{var name=document.getElementById('buscarMaq1').name;var arr = name.split('-');
		document.getElementById('selectUbicacion').value=arr[0];  document.getElementById('selectRegion').value=arr[1];
		document.getElementById('selectSala').value=arr[2]; return -1;} }
else{document.getElementById('divMuestraMaquinas').innerHTML = '';}
}
}
//trae OfficeID de la sal seleccionada
function traeOfficeID(valor){/*alert(valor);*/ var reg=''; var sa='';
	if(document.getElementById('tablaMovimientos').title!='0'){
	if(confirm("Existen movimientos sin guardar, al cambiar de posicion se perderan, \u00BFdesea guardarlos?")){guardarMovimientos();document.getElementById('divMuestraMaquinasDes').innerHTML = '';
	reg=document.getElementById('selectRegionDes').value;
sa=document.getElementById('selectSalaDes').value; document.getElementById('buscarMaq2').name = 'Sala-'+reg+'-'+sa;} else{var name=document.getElementById('buscarMaq2').name;var arr = name.split('-');
		document.getElementById('selectUbicacionDes').value=arr[0]; 
		if(arr[0]=='Sala'){document.getElementById('selectRegionDes').value=arr[1]; document.getElementById('selectSalaDes').value=arr[2];} return -1;} }
else{document.getElementById('divMuestraMaquinasDes').innerHTML = '';  reg=document.getElementById('selectRegionDes').value;
sa=document.getElementById('selectSalaDes').value; document.getElementById('buscarMaq2').name = 'Sala-'+reg+'-'+sa;
document.getElementById('buscarMaq2').title = 'Sala,'+reg+','+sa;}
   $.ajax({
   url: 'php/traeOfficeID.php',
   type: 'POST',
   async: true,
   data: 'valorx='+valor,
   dataType: "text",
   success: function Respuesta(result){
		document.getElementById('spanOfficeIDdes').innerHTML=result;
		creaCeldasRack(5, 2);
   },
   error: Error
   });
}
function actualizar(usuarioid){//alert(usuarioid);
$.ajax({
	url: 'php/actualizaModulo.php',
	type: 'POST',
	async: true,
	data: 'usuarioidx='+usuarioid,
	dataType: "text",
	success: function Respuesta(result){location.reload(true)},
	error: Error
	});
}
//exportar rack a pdf
function tablaPDF(){//alert('entre');
if(document.getElementById('selectUbicacionDes').value=='Bodega'){
var bodega=document.getElementById('selectBodegaDes').value;
var rack=document.getElementById('selectRackDes').value;
var nivel=document.getElementById('selectNivelDes').value; //alert(bodega+'|'+rack+'|'+nivel);

window.open("php/dompdf/tabla.php?bodegax="+bodega+"&rackx="+rack+"&nivelx="+nivel,"Distribucion","width=500,height=500,top=50,left=50,scrollbars=YES");
}else{alert('Seleccione una Bodega');}
}
//muestra formulario para reporte de maquinas
function reporteDeMaquinas(){
	if(document.getElementById('reporteDeMaquinasDiv').innerHTML==''){//alert('hi');
		$.ajax({
			url: 'php/reporteDeMaquinas.php',
			type: 'POST',
			async: true,
			data: '',
			success: function resp(result){//alert(result);
				document.getElementById('reporteDeMaquinasDiv').innerHTML=result;
			},
			error: Error
		}); 
	}
	ocultaDivs('PRODUCCION > Reporte de Maquinas', 'reporteDeMaquinasDiv');
}
function traeDatosRM(valor){
	if(valor=='Bodega'){document.getElementById('spanExportarPDF').innerHTML='<input type="image" src="imgs/pdf.png" title="Exportar PDF"  style="cursor:pointer" onclick="exportarRepPDF();" />'; 
	document.getElementById('spanExportarExcel').innerHTML='<input type="image" src="imgs/export_to_excel.gif" title="Exportar a Excel"  style="cursor:pointer" onclick="exportarRepExcel();" />';}else{document.getElementById('spanExportarPDF').innerHTML='';}
	
if(valor=='Bodega'){document.getElementById('spanDatosSala').style.display='none';
document.getElementById('spanDatosBod').style.display='inline'; 
document.getElementById('spanExportarExcel').innerHTML='<input type="image" src="imgs/export_to_excel.gif" title="Exportar a Excel"  style="cursor:pointer" onclick="exportarMaquinasExcel();" />';}else{document.getElementById('spanExportarExcel').innerHTML='';}

if(valor=='Sala'){document.getElementById('spanDatosSala').style.display='inline';
document.getElementById('spanDatosBod').style.display='none';
document.getElementById('spanExportarExcel').innerHTML='<input type="image" src="imgs/export_to_excel.gif" title="Exportar a Excel"  style="cursor:pointer" onclick="exportarMaquinasExcel();" />';}else{document.getElementById('spanExportarExcel').innerHTML='';}

if(valor=='%' || valor=='Transito'){if(document.getElementById('spanDatosSala')){document.getElementById('spanDatosSala').style.display='none';}
if(document.getElementById('spanDatosBod')){document.getElementById('spanDatosBod').style.display='none';}}
}
function traedatosMaqRep(valor,dato,bod){//alert(valor+" "+dato+" "+bod);
	$.ajax({
    url: 'php/traedatosMaq2.php',
    type: 'POST',
   async: true,
   data: 'valorx='+valor+'&datox='+dato+'&bodx='+bod,
   dataType: "text",
   success: function Respuesta(result){if(dato==1){document.getElementById('spanRackRepMaqs').innerHTML = result;}
   if(dato==2){document.getElementById('spanNivelRepMaqs').innerHTML = result;}
   if(dato==3){document.getElementById('spanSala').innerHTML = result;}
   },
   error: Error
   });
}
function buscaMaquinas2(){var ser=document.getElementById('inputSerieMaq').value;
document.getElementById('BotonBRM').disabled=true;
var ubi=document.getElementById('selectUbicacionMaq').value;

document.getElementById('spanExportarExcel').innerHTML='<input type="image" src="imgs/export_to_excel.gif" title="Exportar a Excel"  style="cursor:pointer" onclick="exportarMaquinasExcel();" />';//}else{document.getElementById('spanExportarExcel').innerHTML='';}

if(ubi=='Sala' || ubi=='%' || ubi=='Transito'){var sal=document.getElementById('selectSalaMaq').value; var reg=document.getElementById('selectRegionMaq').value;
var ped=document.getElementById('inputPedimentoMaq').value;      var fac=document.getElementById('inputFacturaMaq').value;//alert(ubi+'|'+sal+'|'+ped+'|'+fac);
$.ajax({
  url: 'php/buscaMaquinas.php',
  type: 'POST',
  async: true,
  data: 'seriex='+ser+'&ubix='+ubi+'&salax='+sal+'&regionx='+reg+'&pedx='+ped+'&facx='+fac,
  success: function resp(result){document.getElementById('BotonBRM').disabled=false;
  var arr=result.split('|@|');//alert(arr[0]+'|'+arr[1]);
  document.getElementById('busquedaMaqRepMaqs').innerHTML=arr[0];
  document.getElementById('spanNumMaq').innerHTML=arr[1];
   var image="<img src='imgs/export_to_excel.gif' style='float:right; cursor:pointer;' alt='exporta a excel' title='Exportar a Excel' class='botonExcel' onclick='exportarExcelMaquinas();' />";
  },
  error: Error
 });}
 
 if(ubi=='Bodega'){var bod=document.getElementById('selectBodegaRepMaqs').value;
var rack=document.getElementById('selectRackRepMaqs').value;      var nivel=document.getElementById('selectNivelRepMaqs').value;
var ped=document.getElementById('inputPedimentoMaq').value;      var fac=document.getElementById('inputFacturaMaq').value;
$.ajax({
  url: 'php/buscaMaquinas.php',
  type: 'POST',
  async: true,
  data: 'seriex='+ser+'&ubix='+ubi+'&bodegax='+bod+'&rackx='+rack+'&nivelx='+nivel+'&pedx='+ped+'&facx='+fac,
  success: function resp(result){document.getElementById('BotonBRM').disabled=false;
  var arr=result.split('|@|');//alert(arr[0]+'|'+arr[1]);
  document.getElementById('busquedaMaqRepMaqs').innerHTML=arr[0];
  document.getElementById('spanNumMaq').innerHTML=arr[1];
  var image="<img src='imgs/export_to_excel.gif' style='float:right; cursor:pointer;' alt='exporta a excel' title='Exportar a Excel' class='botonExcel' onclick='exportarExcelMaquinas();' />";},
  error: Error
 });}
 
  if(ubi=='A DESTRUIR' || ubi=='varias'){
$.ajax({
  url: 'php/buscaMaquinas.php',
  type: 'POST',
  async: true,
  data: 'seriex='+ser+'&ubix='+ubi,
  success: function resp(result){document.getElementById('BotonBRM').disabled=false;
  var arr=result.split('|@|');//alert(arr[0]+'|'+arr[1]);
  document.getElementById('busquedaMaqRepMaqs').innerHTML=arr[0];
  document.getElementById('spanNumMaq').innerHTML=arr[1];},
  error: Error
 });}
 
 if(ubi=='%'){document.getElementById('busquedaMaqRepMaqs').innerHTML='';document.getElementById('spanNumMaq').innerHTML='';}
 }
//exporta reporte de bodegas a pdf
function exportarRepPDF(){//alert('entre');
var bodega=document.getElementById('selectBodegaRepMaqs').value;
var rack=document.getElementById('selectRackRepMaqs').value;
var nivel=document.getElementById('selectNivelRepMaqs').value;  
window.open("php/reportePDF.php?bodegax="+bodega+"&rackx="+rack+"&nivelx="+nivel,"Distribucion","width=900,height=600,top=50,left=50,scrollbars=YES");
}

function exportarMaquinasExcel(){//alert('entre');
var ubi=document.getElementById('selectUbicacionMaq').value;
var ser=document.getElementById('inputSerieMaq').value;
var sal=document.getElementById('selectSalaMaq').value; 
var reg=document.getElementById('selectRegionMaq').value;
var ped=document.getElementById('inputPedimentoMaq').value;      
var fac=document.getElementById('inputFacturaMaq').value;
var bodega=document.getElementById('selectBodegaRepMaqs').value;
var rack=document.getElementById('selectRackRepMaqs').value;
var nivel=document.getElementById('selectNivelRepMaqs').value;  
window.open("php/reporteMaquinasExcel.php?salax="+sal+"&regionx="+reg+"&pedx="+ped+"&facx="+fac+"&seriex="+ser+"&ubix="+ubi+"&bodegax="+bodega+"&rackx="+rack+"&nivelx="+nivel,"EnSala","width=900,height=600,top=50,left=50,scrollbars=YES");
}//'seriex='+ser+'&ubix='+ubi+'&salax='+sal+'&regionx='+reg+'&pedx='+ped+'&facx='+fac
//muestra las entradas recibidas en produccion para dar entrada
function entradasPro(){
//if(document.getElementById('entradasProDiv').innerHTML==''){//alert('hi');
	$.ajax({
	url: 'php/entradasPro.php',
	type: 'POST',
	async: true,
	data: '',
	success: function resp(result){//alert(result);
		document.getElementById('entradasProDiv').innerHTML=result;
	},
	error: Error
	}); 
//}
	ocultaDivs('PRODUCCION > Entradas Producci&oacute;n', 'entradasProDiv');
}
//acepta o cancela entradas
function movimientosEntradasPro(num,tr,entrada,ref){//alert(num+' | '+tr+' | '+entrada+' | '+ref); //return false;
	$.ajax({
    url: 'php/movimientosEntradasPro.php',
    type: 'POST',
	async: false,
	data: 'numx='+num+'&trx='+tr+'&entradax='+entrada+'&refx='+ref+'&usuarioIDx='+usuarioID,
	dataType: "text",
	success: function Respuesta(result){//alert(result);
		document.getElementById('entradasProDiv').innerHTML=result;
	},
	error: Error
	});
}
//muestra el inventario existente en produccion
function inventarioPro(){
//if(document.getElementById('inventarioProDiv').innerHTML==''){//alert('hi');
	$.ajax({
	url: 'php/inventarioPro.php',
	type: 'POST',
	async: true,
	data: '',
	success: function resp(result){//alert(result);
		document.getElementById('inventarioProDiv').innerHTML=result;
	},
	error: Error
	}); 
//}
	ocultaDivs('PRODUCCION > Inventario Producci&oacute;n', 'inventarioProDiv');
	 
}
//acepta o cancela entradas
function movimientosSalidasPro(num,tr,entrada,ref,obs,serie){//alert(num+' | '+tr+' | '+entrada+' | '+ref+' | '+obs+' | '+serie); //return false;
	$.ajax({
    url: 'php/movimientosSalidasPro.php',
    type: 'POST',
	async: false,
	data: 'numx='+num+'&trx='+tr+'&entradax='+entrada+'&refx='+ref+'&obsx='+obs+'&seriex='+serie+'&usuarioIDx='+usuarioID,
	dataType: "text",
	success: function Respuesta(result){//alert(result);
		document.getElementById('inventarioProDiv').innerHTML=result;
	},
	error: Error
	});
}
function listaOrden(area){ areaG=area;
if(document.getElementById('busquedaListaInput')){
	valor = document.getElementById('busquedaListaInput').value;
	if(document.getElementById('busquedaListaInput').value==''){
			document.getElementById('busquedaListaInput').value='Buscar';
			document.getElementById('busquedaListaInput').style.color='#9E9E9E';
			document.getElementById('busquedaListaInput').blur();
		}
	}	
	ocultaDivs('PRODUCCION > Orden Servicio', 'ordenServicioDiv');
	listaOrdenOS(area,valor);
	if(intervalo){
        clearInterval(intervalo); //alert("stop");
    }
	intervalo = setInterval('listaOrdenOS(areaG,valor)',300000);
}
function pantallaSubirArchivoOP(folio){//alert(folio);
//var NumFolio=arr[0];
window.open("../Vistas/uploader/indexOS.html?folio="+folio+"&usuarioIDx="+usuarioID,"VerImagenes","width=850,height=700,scrollbars=YES")
}
function actualizaDivFotos(folio){//alert(folio);
$.ajax({
  url: 'php/actualizaArchivosOS.php',
  type: 'POST',
  async: true,
  data: 'foliox='+folio,
  dataType: "text",
  success: function Respuesta(result){
  document.getElementById("archivosOSdiv").innerHTML = result;
//   document.getElementById("agregaObsLay"+reporte).style.border='solid 1px';
  },
  error: Error
});
}
function reporteOSPR(){
	ocultaDivs('PRODUCCION > Orden de Servicio > Reportes', 'divReporteOS');
	if(document.getElementById('divReporteOS').innerHTML!=''){return -1;}
	$.ajax({
	   url: '../Vistas/reporteOrdenes/reporteOS.php',
	   type: 'POST',
	   async: true,
	   data: '',
	   dataType: "text",
	   success: function Respuesta(result){
	   document.getElementById("divReporteOS").innerHTML = result;
	   ocultaDiv(200);
	   ocultaDiv(201);
	   },
	   error: Error
	 });
}

function BuscaPedimentos(bodega,rack,nivel,pedimento)
{	   
	   $.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneiddivTablaMaquina.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&pedimentox='+pedimento,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var x;
		   for(x=0;x<num;x=x+1)
		   {
			   if(document.getElementById(arr[x]))
			   	 document.getElementById(arr[x]).style.backgroundColor="#fff";	
		   }   
	   },
	   error: Error
	   });
	   
		$.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneUbicacionId.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&pedimentox='+pedimento,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var x;
		   for(x=0;x<num;x=x+1)
		   {
			   if(document.getElementById(arr[x]))
			   	 document.getElementById(arr[x]).style.backgroundColor="#80c0ff";	
		   }   
	   },
	   error: Error
	   });
	   
}

///Funciones para mostrar maquinas del contrato
function BuscaContratos(bodega,rack,nivel,contrato)
{	   //alert(bodega);
	   $.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneiddivTablaMaquinaContratos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&contratox='+contrato,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var x;
		   for(x=0;x<num;x=x+1)
		   {
			   if(document.getElementById(arr[x]))
			   	 document.getElementById(arr[x]).style.backgroundColor="#fff";	
		   }   
	   },
	   error: Error
	   });
	   
		$.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneUbicacionIdContratos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&contratox='+contrato,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var x;
		   for(x=0;x<num;x=x+1)
		   {
			   if(document.getElementById(arr[x]))
			   	 document.getElementById(arr[x]).style.backgroundColor="#844040";	
		   }   
	   },
	   error: Error
	   });
	   
}

///////Funciones para poner en verde maquinas libres de contratos///////////////
function maquinasSinContratos(bodega,rack,nivel){//alert(bodega+"-"+rack+"-"+nivel);
	   $.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneiddivTablaMaquinaSinContratos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var y;
		   for(y=0;y<num;y=y+1)
		   {
			   if(document.getElementById(arr[y])){
			   	 document.getElementById(arr[y]).style.backgroundColor="#fff";	}
		   }   
	   },
	   error: Error
	   });
	   
		$.ajax({
		url: '../Vistas/Mov de Maquinas/obtieneUbicacionIdSinContratos.php',
		type: 'POST',
	   async: true,
	   data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel,
	   dataType: "text",
	   success: function Respuesta(result)
	   {//alert(result);
		   var arr = result.split(','); 
		   var num=arr.length;
		   var y;
		   for(y=0;y<num;y=y+1)
		   {
			   if(document.getElementById(arr[y])){
			   	 document.getElementById(arr[y]).style.backgroundColor="#47d147";	}
		   }   
	   },
	   error: Error
	   });
	   
}

function ExportarExcelPedimento(bodega,rack,nivel)
{
	window.open("../Vistas/reporteOrdenes/ExcelMaquinaPedimento.php?bodegax="+bodega+"&rackx="+rack+"&nivelx="+nivel)	
}

function irMenuAnterior(){ var paisID='1';
   $.ajax({
   url: '../irMenuAnterior.php',
   type: 'POST',
   async: true,
   data: 'usuarioIDx='+usuarioID+'&paisIDx='+paisID,
   dataType: "text",
   success: function Respuesta(result){//alert(usuarioID+"--"+paisID+"--"+result);
   if(result=='1'){location.href='../menuBanderas.php';}
   if(result=='2'){location.href='../menuModulos2.php?paisIDx='+paisID;}
   },
   error: Error
 });
}
function pedidoNuevo2(){
	ocultaDivs('PRODUCCION > Solicitud de Material', 'pedidoNuevoDiv');
	var paisID=1;
	$.ajax({
	    url: 'php/pedidoNuevoPro.php',
	    type: 'POST',
	   	async: true,
	   	data: 'paisIDx='+paisID,
	   	dataType: "text",
	   	success: function Respuesta(result){
			// var ele; //var con;
			/*var div='<div id="pedidoNuevoDiv" style="overflow:auto; border:#A8D3FF solid 2px";></div>';*/
			//if(document.getElementById(seleccionada+'Div')){document.getElementById(seleccionada+'Div').style.display= "none";}
			/*document.getElementById('contenido').innerHTML += div;*///con=document.getElementById('contenido');
			//con=document.getElementById('contenido');
			//ele = document.createElement('div');
			//ele.id = 'pedidoNuevoDiv';
			//con.appendChild(ele);
			//document.getElementById('pedidoNuevoDiv').innerHTML = result
			document.getElementById('pedidoNuevoDiv').innerHTML=result;
			//insertarPestana('pedidoNuevo','Nuevo Pedido');
	  	},
	   	error: Error
   });
}
//}
function traeSalasPN(region){var fol='0'; var n=3;
	$.ajax({
    url: '../CC/php/traeSalas.php',
    type: 'POST',
   async: true,
   data: 'folx='+fol+'&regionx='+region+'&nx='+n,
   dataType: "text",
   success: function Respuesta(result){var arr = result.split(',,');
   document.getElementById('spanSalaPN').innerHTML = arr[0];document.getElementById('spanTecnicoPN').innerHTML = arr[1];
  },
   error: Error
   });
}
function ocultarCamposSala(valor){
if(valor!='Sala'){
	document.getElementById('spanCamposDepartamento').style.display= 'block';
	$.ajax({
   url: '../CC/php/traeSolicitantePedidos.php',
   type: 'POST',
   async: true,
   data: 'valorx='+valor,
   dataType: "text",
   success: function Respuesta(result){
   document.getElementById("spanCamposDepartamento").innerHTML = result;
   },
   error: Error
 });
	document.getElementById('spanCamposSala').style.visibility='hidden';
	}
else{document.getElementById('spanCamposSala').style.visibility='visible';
document.getElementById('spanCamposDepartamento').style.display= 'none';
/*spanCamposDepartamento*/}
}
function ventanaCatalogoPiezasPro(fol/*ref,dep,nom,c*/){
	var idioma=1;//alert(fol);
window.open("php/catalogoPiezasPro.php?folx="+fol+'&idiomax='+idioma+" ","CANCELACION","width=900,height=800,top=50,left=50,scrollbars=YES,status=YES, resizable=YES");
}
function busquedaCatalogoPiezasPro(selectFamiliaCP, codigoCP, nombreCP, selectMaquinaCP, fol){//alert(selectFamiliaCP+' '+codigoCP+' '+nombreCP+' '+selectMaquinaCP+' '+fol);

   $.ajax({ 
   url: '../php/busquedaCatalogoPiezasPro.php',
   type: 'POST',
   async: true,
   data: 'selectFamiliaCPx='+selectFamiliaCP+'&codigoCPx='+codigoCP+'&nombreCPx='+nombreCP+'&selectMaquinaCPx='+selectMaquinaCP+'&folx='+fol,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   var arr = result.split(',,');
   //document.getElementById('resultadoCP').style.height='440px';
   document.getElementById('resultadoCP').innerHTML='';
   //document.getElementById('resultadoCP').style.overflow='auto';
   //document.getElementById('resultadoCP').style.height='440px';
   document.getElementById('cabeceraCP').innerHTML=arr[1];
   document.getElementById('resultadoCP').innerHTML=arr[2];
   },
   error: Error
   });
}

function traeDesRefaccion(campo,fol){//alert(campo.name);
 var valor=campo.value;

if(valor.length==6){//alert(valor);
$.ajax({
 url: '../CC/php/traeDesRefaccion.php',
 type: 'POST',
 async: true,
 data: 'valorx='+valor,
 dataType: "text",
 success: function Respuesta(result){var arr = result.split('*');
 document.getElementById('descRef'+fol+campo.name).value = arr[0];if(arr[0]=='La Clave no existe'){
 document.getElementById(campo.id).style.backgroundColor='#EFD3DE'; }else{document.getElementById(campo.id).style.backgroundColor='#FFF';}
 if(arr[1]==16){document.getElementById('cantidadPedido'+fol+campo.name).value=1; document.getElementById('cantidadPedido'+fol+campo.name).readOnly=true;document.getElementById('seriePedido'+fol+campo.name).focus();}else{document.getElementById('cantidadPedido'+fol+campo.name).readOnly=false;} },
 error: Error
 });}
 else{document.getElementById('descRef'+fol+campo.name).value = '';}
}function puenteCP(clave, estatus, fol,ref){//alert(clave+' '+estatus+' '+fol);
	if(estatus==124){ validaPiezaObsoleta(clave); return -1;}
	window.opener.agregarPieza(clave, estatus, fol,ref);
	alert('Pieza '+clave+' agregada');
}
function validaPiezaObsoleta(clave){//alert(clave);
   $.ajax({
   url: '../../CC/php/validaPiezaObsoleta.php',
   type: 'POST',
   async: true,
   data: 'clavex='+clave,
   dataType: "text",
   success: function Respuesta(result){alert(result);
   },
   error: Error
   });
}
function agregarPieza(clave, estatus, fol,ref){//alert(clave+' '+estatus+' '+fol);
var conv=document.getElementById('contadorInput'+fol).name;//alert(conv);
var cont=conv-1;//alert(cont);
if(document.getElementById('clavePedido'+fol+cont) && document.getElementById('clavePedido'+fol+cont).value==''){//alert('existo');
	
	if(estatus=='16'){//alert('soy 16');
	document.getElementById('clavePedido'+fol+cont).value=clave;
	document.getElementById('descRef'+fol+cont).value=ref;
	document.getElementById('cantidadPedido'+fol+cont).value=1;
	document.getElementById('cantidadPedido'+fol+cont).readOnly='true';}
	if(estatus!='16'){//alert('soy 15');
	document.getElementById('clavePedido'+fol+cont).value=clave;document.getElementById('descRef'+fol+cont).value=ref;}
}else{//alert('ya entre');
var con=parseInt(conv); var con2=con+1; var d9; //alert(con);
var d1 ='<input size="5" id="clavePedido'+fol+conv+'" value='+clave+' maxlength="6" onKeyUp="traeDesRefaccion(this,\''+fol+'\');" name="'+conv+'" />'; 
var d6='<input size="6" id="licenciaPedido'+fol+conv+'" maxlength="10" name="'+fol+''+conv+'" onKeyUp="buscaLicenciaSF(this.value,this.name);"/><div class="divBuscaFallas" id="divBuscaLicenciasSF'+fol+''+conv+'" /></div>';
if(estatus=='16'){var d2="<input size='1' id='cantidadPedido"+fol+conv+"' value='1' readOnly='readonly'/>";}else{
var d2="<input size='1' id='cantidadPedido"+fol+conv+"' />";}   
var d7='<input size="6" id="versionPedido'+fol+conv+'" />';
var d3="<input size='6' id='seriePedido"+fol+conv+"' />"; 
var d8='<input size="6" id="ipPedido'+fol+conv+'" />';
var d4="<select id='cajaPedido"+fol+conv+"'><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option><option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option><option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
//var d9=document.getElementById('JuegoPedidoTD1').innerHTML;/*'<input size="6" id="clave2" maxlength="6"/>';*/
var d5="<select id='denominacionPedido"+fol+conv+"'><option value=''></option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option><option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";
var d10='<input size="30" id="motivoPedido'+fol+conv+'" />';
var d11='<textarea id="descRef'+fol+''+conv+'" cols="20" rows="2" readonly>'+ref+'</textarea>';
var d12='<textarea id="diagnosticoPedido'+fol+''+conv+'" cols="20" rows="2"></textarea>';
var table = document.getElementById('tablaNuevoPedido'+fol); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;
var cell, text;
$.ajax({
  url: '../CC/php/traeJuegos.php',
  type: 'POST',
  async: true,
  data: 'numx='+conv+'&folx='+fol,
  dataType: "text",
  success: function Respuesta(result){d9=result
        celClave = row.insertCell(-1);
  celClave.style.background='#F5F5F5'; celClave.style.border='#ccc solid 1px'; celClave.align='center';
  textv = con;  celClave.innerHTML=textv;
  celCla = row.insertCell(-1);  text1 = d1;  celCla.innerHTML=text1;
  celDeR = row.insertCell(-1);  text11 = d11;  celDeR.innerHTML=text11; 
  celCan = row.insertCell(-1);  text2 = d2;  celCan.innerHTML=text2;
  celSer = row.insertCell(-1);  text3 = d3;  celSer.innerHTML=text3;
  celCaj = row.insertCell(-1);  text4 = d4;  celCaj.innerHTML=text4;
  celDen = row.insertCell(-1);  text5 = d5;  celDen.innerHTML=text5;
  celLic = row.insertCell(-1);  text6 = d6;  celLic.innerHTML=text6;
  celVer = row.insertCell(-1);  text7 = d7;  celVer.innerHTML=text7;
  celIp = row.insertCell(-1);  text8 = d8;  celIp.innerHTML=text8;
  celJue = row.insertCell(-1);  /*text9 = d9;*/  celJue.innerHTML=d9;
  celMot = row.insertCell(-1);  text10 = d10;  celMot.innerHTML=text10;
  celMot = row.insertCell(-1);  text12 = d12;  celMot.innerHTML=text12;
  document.getElementById('contadorInput'+fol).name=con2;},
  error: Error
 });}
}
function agregarFila(fol){var conv=document.getElementById('contadorInput'+fol).name;
var con=parseInt(conv); var con2=con+1; var d9;
var d1 ='<input size="5" id="clavePedido'+fol+''+conv+'" maxlength="6" onKeyUp="traeDesRefaccion(this,\''+fol+'\');" name="'+conv+'" />'; d6='<input size="6" id="licenciaPedido'+fol+''+conv+'" maxlength="10" name="'+fol+''+conv+'" onKeyUp="buscaLicenciaSF(this.value,this.name);"/><div class="divBuscaFallas" id="divBuscaLicenciasSF'+fol+''+conv+'" ></div>';
var d2="<input size='1' id='cantidadPedido"+fol+""+conv+"' />";   d7='<input size="6" id="versionPedido'+fol+''+conv+'"/>';
var d3="<input size='6' id='seriePedido"+fol+""+conv+"' />";    d8='<input size="6" id="ipPedido'+fol+''+conv+'"/>';
var d4="<select id='cajaPedido"+fol+""+conv+"'><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='ATR'>ATR</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='SAC'>SAC</option><option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option><option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option><option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
//var d9=document.getElementById('JuegoPedidoTD1').innerHTML;/*'<input size="6" id="clave2" maxlength="6"/>';*/
var d5="<select id='denominacionPedido"+fol+""+conv+"'><option value=''></option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option><option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";
var d10='<input size="30" id="motivoPedido'+fol+''+conv+'" />';
var d12='<textarea id="diagnosticoPedido'+fol+''+conv+'" cols="20" rows="2"></textarea>';
var d11='<textarea id="descRef'+fol+''+conv+'" cols="20" rows="2" readonly></textarea>';
var table = document.getElementById('tablaNuevoPedido'+fol); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;
//row.style.background=fondo;
var cell, text;
$.ajax({
  url: '../CC/php/traeJuegos.php',
  type: 'POST',
  async: true,
  data: 'numx='+conv+'&folx='+fol,
  dataType: "text",
  success: function Respuesta(result){d9=result
        celClave = row.insertCell(-1);
  celClave.style.background='#F5F5F5'; celClave.style.border='#ccc solid 1px'; celClave.align='center';
  textv = con;  celClave.innerHTML=textv;
  celCla = row.insertCell(-1);  text1 = d1;  celCla.innerHTML=text1;
  celDeR = row.insertCell(-1);  text11 = d11;  celDeR.innerHTML=text11;
  celCan = row.insertCell(-1);  text2 = d2;  celCan.innerHTML=text2;
  celSer = row.insertCell(-1);  text3 = d3;  celSer.innerHTML=text3;
  celCaj = row.insertCell(-1);  text4 = d4;  celCaj.innerHTML=text4;
  celDen = row.insertCell(-1);  text5 = d5;  celDen.innerHTML=text5;
  celLic = row.insertCell(-1);  text6 = d6;  celLic.innerHTML=text6;
  celVer = row.insertCell(-1);  text7 = d7;  celVer.innerHTML=text7;
  celIp = row.insertCell(-1);  text8 = d8;  celIp.innerHTML=text8;
  celJue = row.insertCell(-1);  /*text9 = d9;*/  celJue.innerHTML=d9;
  celMot = row.insertCell(-1);  text10 = d10;  celMot.innerHTML=text10;
  celMot = row.insertCell(-1);  text12 = d12;  celMot.innerHTML=text12;
  document.getElementById('contadorInput'+fol).name=con2;
  document.getElementById('clavePedido'+fol+conv).focus(); if(fol!='0'){buscaDatosLicFol(2,fol);}
  },
  error: Error
 });
}
function enviaSupervisor(c,sol,fol){var area='0'; var sala; var tecnico; //alert(fol+"-----");

	var conv=document.getElementById('contadorInput'+fol).name;
var con=parseInt(conv); var con2=con-1; var c1; var c2; var c3; var c4; var c5; var c6; var c7; var c8; var c9; var c10; var c11; var d='';
var arr = new Array(); var j=0;var refac; var serie; var pedido; var ref; var ser; var pedido2;

for(var x=c;x<conv;x++){
	if(document.getElementById('clavePedido'+fol+x).value!='' && document.getElementById('clavePedido'+fol+x).value.length==6 && document.getElementById('clavePedido'+fol+x).style.backgroundColor!='#efd3de'){
refac=document.getElementById('clavePedido'+fol+x).value;
serie=document.getElementById('seriePedido'+fol+x).value;
pedido=refac + serie;
for(var y=x+1;y<conv;y++){
ref=document.getElementById('clavePedido'+fol+y).value;
ser=document.getElementById('seriePedido'+fol+y).value;
pedido2=ref + ser;
if(pedido==pedido2){
alert("En la fila "+(x)+" y la fila "+(y)+" tienen la misma clave y serie");
return -1;}}}//fin de if clave!='' && lenngth==6
}//fin primer for

for(var i=c;i<conv;i++){ //alert(i);
if(document.getElementById('clavePedido'+fol+i).value!='' && document.getElementById('clavePedido'+fol+i).value.length==6 && document.getElementById('clavePedido'+fol+i).style.backgroundColor!='#efd3de'){ 
c1=document.getElementById('clavePedido'+fol+i).value; c2=document.getElementById('cantidadPedido'+fol+i).value;
c3=document.getElementById('seriePedido'+fol+i).value; c4=document.getElementById('cajaPedido'+fol+i).value;
c5=document.getElementById('denominacionPedido'+fol+i).value; c6=document.getElementById('licenciaPedido'+fol+i).value;
c7=document.getElementById('versionPedido'+fol+i).value; c8=document.getElementById('ipPedido'+fol+i).value;
c9=document.getElementById('juegoPedido'+fol+i).value; c10=document.getElementById('motivoPedido'+fol+i).value;
c11=document.getElementById('diagnosticoPedido'+fol+i).value;
if(!/^([0-9])*$/.test(c2) || c2==''){alert('El campo Cantidad debe ser numerico'); return -1;}
d=d+c1+'||'+c2+'||'+c3+'||'+c4+'||'+c5+'||'+c6+'||'+c7+'||'+c8+'||'+c9+'||'+c10+'||'+c11+'.%.';
j++;}
  	}if(d==''){alert("No pueden estar vacios los campos");return -1;}
if(document.getElementById('texaObservacionesNP'+fol)){
		var texa=document.getElementById('texaObservacionesNP'+fol).value;var valor=1;
		}else{var texa=document.getElementById('texaObservaciones'+sol+fol).value;var valor=2;}
if(fol==0){  if(document.getElementById('selectDepartamento').value=='Sala'){alert("Eligue un Area"); return false;
				if(sala=='' || tecnico==''){alert("El campo Sala o Tecnico estan vacio");return false;}
             }
			 else{area=document.getElementById('selectDepartamento').value; sala=0; tecnico=document.getElementById('nombreSolicitanteM').value;
				 }

}
else{sala=0; tecnico=0;}
var proyecto=document.getElementById('selProyecto').value;
	$.ajax({
	url: '../Vistas/Sol Material/ingresaPedido.php',
   type: 'POST',
   async: true,
   data: 'arreglox='+d+'&jx='+j+'&folx='+fol+'&solx='+sol+'&texax='+texa+'&valorx='+valor+'&salax='+sala+'&tecnicox='+tecnico+'&usuarioIDx='+usuarioID+'&areax='+area+'&paisIDx='+paisID+'&idiomax='+idioma+'&proyectox='+proyecto,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
  if(result=='Repetido'){alert("No se pueden ingresar piezas con la misma serie");}
  else{var arr = result.split('||');
        if(arr[0]=='.-.'){document.getElementById('PedidoDiv'+fol).innerHTML=arr[1];}
        else{
	         if(fol==0){alert("Numero de Solicitud: "+result);document.getElementById('pedidoNuevoDiv').innerHTML =''; if(arr[1]==1){ enviarCorrePiezas(arr[2]);} }
			 else{document.getElementById('spanNuevoPedido'+fol).innerHTML =arr[0];
			     if(arr[1]==1){enviarCorrePiezas(arr[2]);}
	             document.getElementById('spanEnviaSup'+fol).innerHTML =arr[1];   document.getElementById('pedidoNuevoDiv').innerHTML ='';
	         }
       }
  }
},
   error: Error
      });
}
/*function enviarCorrePiezas(pedido){//alert(pedido);
$.ajax({
		url: '../Vistas/ordenServicio/enviaCorreoPiezas.php',
		type: 'POST',
		async: true,
		data: 'pedidox='+pedido,
		dataType: "text",
		success: function Respuesta(result){//alert(result);
		},
error: Error
});								 
}*/
function reporteInventario(){
	if(document.getElementById('menuInventario').innerHTML == ''){
		$.ajax({
		   url: '../Vistas/Reporte Inventario/menuInventario.php',
		   type: 'POST',
		   async: true,
		   data: '',
		   dataType: "text",
		   success: function Respuesta(result){
		   document.getElementById("menuInventario").innerHTML = result;
		   },
		   error: Error
		});
	}
	ocultaDivs('PRODUCCION > Cat&aacute;logo Piezas', 'inventarioDiv');
 
}
function buscaInv(cod,fam,nom,area){//alert();
 $.ajax({
  url: '../Vistas/Reporte Inventario/filtraInventario.php',
  type: 'POST',
  async: true,
  beforeSend:function(){
		$("#modal_cargando").toggle();
	},
  data: 'codigox='+cod+'&familiax='+fam+'&nombrex='+nom+'&area='+area+'',
  dataType: "text",
  success: function Respuesta(result){
	  	$("#modal_cargando").toggle();
	  document.getElementById('busquedaInventario').innerHTML = result;
//document.getElementById('filtraInv').style.display="block";
},
  error: Error
});
}

function busquedaInventario(codigo,nombre,familia){//alert(nombre);

   $.ajax({
   url: '../Stock/busquedaInventario.php',
   type: 'POST',
   async: true,
   data: 'codigox='+codigo+'&nombrex='+nombre+'&familiax='+familia,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   document.getElementById('resultadoInventario').innerHTML = result;
   },
   error: Error
   });
}
function ModificarSolRef(numOrden){
	var departamento='8';//alert(numOrden+"----"+departamento);
	window.open("../Vistas/ordenServicio/ModificarSolRef.php?numOrdenx="+numOrden+"&departamentox="+departamento+"&usuarioIDx="+usuarioID,"Cancelacion","scrollbars=YES")
}
/*function mirarRefaccion(clave){//alert(clave);
window.open("../STOCK/verImagenesPiezas.php?clavex="+clave,"PIEZAS","width=600,height=500,rows='24',cols='80',scrollbars=YES")
}*/

function mirarRefaccion(refaccionid)
{
	//$(".muestra_imagen").toggle();
	$.ajax({
		url: '../Stock/listaImagenesRefaccion.php',
		type: 'POST',
		data: {'refaccion_id':refaccionid},
		beforeSend: function(){
	
		},
		success: function (rs){
			var res=JSON.parse(rs);
			console.log(res);
		
			if(res.success)	
			{
			 var html='';
			 $.each( res.data, function( k, v ) {


							html+='<div class="vista-imagen"><a href="javascript:;" class="ver-imagen" onclick="abrir_imagen('+v['imagenRefaccionid']+');">'+
							'<img src="'+v['url_img']+'"  id="img_'+v['imagenRefaccionid']+'">'+
						'</a>'+
						'<a href="javascript:;"class="link-ver-imagen"  onclick="abrir_imagen('+v['imagenRefaccionid']+','+v['refaccionidfk']+');">'+
						'Ver imagen <i class="fa fa-search"></i></a></div>';
			});

			$('#modal_imagenes > .contenido').css('height','50%');
      $('.title-modal').html('<strong>Imagenes cargadas</strong>');
			$('.contenido-modal').html(html);
			
			}			
			else		
			{
				$('#modal_imagenes > .contenido').css('height','10%');
        $('.title-modal').html('');
				$('.contenido-modal').html('<p style="text-align: center;	font-weight: bold;color: #ff0000ba;">NO SE HAN CARGADO IMAGENES </p>');
			}
			$('#modal_imagenes').css('display','block');//MUESTRA LA VENTANA MODAL

	},
		error: Error
	});	
	
}
function cerrar_modal_img() {
	$(' #modal_imagenes').css('display','none');
}
function abrir_imagen(img_refaccion)
{
	$(".muestra_imagen").toggle();
	var url_img=$("#img_"+img_refaccion).attr('src');
	//console.log ($("#img_"+img_refaccion));
 $(".muestra_imagen").html('<img src="'+url_img+'" style="cursor:pointer;width: 45%;"></img>');
}

function traeParteListaOS(ordenid,n){
   $.ajax({
    url: 'php/MaquinasOSPartes.php',
    type: 'POST',
   async: true,
   data: 'ordenidx='+ordenid+'&n2x='+n,
   dataType: "text",
   success: function Respuesta(result){var dato=result.split('|*|');
	//document.getElementById('spanDivOS').innerHTML = dato[1];
	document.getElementById('divMuestraMaquinasDes').innerHTML = dato[0]; inicio();
   },
   error: Error
   });
}
function traeParteListaCont(contratoid,n){
   $.ajax({
    url: 'php/MaquinasContPartes.php',
    type: 'POST',
   async: true,
   data: 'contratoidx='+contratoid+'&n2x='+n,
   dataType: "text",
   success: function Respuesta(result){var dato=result.split('|*|');
	//document.getElementById('spanDivOS').innerHTML = dato[1];
	document.getElementById('divMuestraMaquinasDes').innerHTML = dato[0]; inicio();
   },
   error: Error
   });
}
function modMaquinas(){
  	$.ajax({
		url: 'php/nuevoMaquinasBodega.php',
		type: 'POST',
		async: true,
		data: 'paisIDx='+paisID,
		success: function respuesta(result){
			ocultaDivs('PRODUCCION > Maquinas en Bodega', 'divMaquinasBodegas');
		    document.getElementById('divMaquinasBodegas').innerHTML=result;
		},
		error: Error
 	});
}
function traedatosBod(valor){//alert(valor);
  $.ajax({
  url: 'php/cambiaDatosBodega.php',
  type: 'POST',
  async: true,
  data: 'valorx='+valor,
  success: function respuesta(result){
	   document.getElementById('cambiaRack').innerHTML=result;
	   },
  error: Error
 });
}
function busquedaMaquinas(bodega,rack,nivel){//alert(bodega+" "+rack+" "+nivel);
var paisID=1;
  $.ajax({
  url: 'php/buscaMaquinasBodega.php',
  type: 'POST',
  async: true,
  data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&paisIDx='+paisID,
  success: function respuesta(result){//alert(result);
	   document.getElementById('mostrarMaquinasenBodegaDiv').innerHTML=result;
	   },
  error: Error
 });
}
//Seleccionar Todos los Checkbox
function seleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")	
         document.f1.elements[i].checked=1 
} 
//Deseleccionar Todos los Checkbox
function deseleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")	
         document.f1.elements[i].checked=0 
}
function cambiaEstatus(estatus,motivo,bodega,rack,nivel){//alert(estatus+" "+motivo);
var listaSer = ''; var copia=0;

var	form = document.forms["f1"];
//if(form==undefined){alert('No hay tecnico seleccionado'); return -1;}
if(form!=undefined){//alert('hi');
if(document.getElementById('copiaSeries').checked==1){copia=1; }
for (i=0;i<form.elements.length;i++){
    if(form.elements[i].type == "checkbox" && form.elements[i].checked==1){listaSer=(form.elements[i].name+',').concat(listaSer);
		/*alert(listaMsg);*/};
    }/*return false;*///document.getElementById('cambiaEstatus').innerHTML=result;
	}//else{alert('No hay seria seleccionada'); return false;}
	
	 $.ajax({
  url: 'php/cambiaEstatus.php',
  type: 'POST',
  async: true,
  data: 'estatusx='+estatus+'&motivox='+motivo+'&listaSerx='+listaSer,
  success: function respuesta(result){//alert(result);
  var arr=result.split('||');
	if(arr[1]==1){alert('La serie '+arr[2]+' esta asignada al CONTRATO '+arr[3]); busquedaMaquinas(bodega,rack,nivel); return -1;}
	  if(arr[1]==3){alert('No hay seria seleccionada'); return -1;}else{
	   if(arr[1]=='2'){alert('Se cambio el estatus correctamente.'); busquedaMaquinas(bodega,rack,nivel);}
	   else{alert('Error al cambiar el estatus'); return -1;}}
	   
	   },
  error: Error
 });
}
function busquedaMaquinasExcel(selectBodegaMaq, selectRackMaq, selectNivelMaq){//alert(selectBodegaMaq+" "+selectRackMaq+" "+selectNivelMaq);
window.open("php/reporteMaquinasBodegaExcel.php?selectBodegaMaqx="+selectBodegaMaq+"&selectRackMaqx="+selectRackMaq+"&selectNivelMaqx="+selectNivelMaq,"REPORTE","width=800,height=700,top=50,left=50,scrollbars=YES")
}
function ModificarSolRefPro(pedido){
	var departamento='8';//alert(pedido+"----"+departamento);
	window.open("php/ModificarSolRefPro.php?pedidox="+pedido+"&departamentox="+departamento+"&usuarioIDx="+usuarioID,"Cancelacion","scrollbars=YES")
}
function mostrarReportePedido(){
  $.ajax({
  url: '../Vistas/Reporte Pedidos/nuevoReportePedidos.php',
  type: 'POST',
  async: true,
  data: '',
  success: function respuesta(result){//alert(result);//location.href='../index.html';
  	ocultaDivs('PRODUCCION > Entradas > Con Folio de Retorno SISCO', 'reportePedidosATdiv');
   	document.getElementById('reportePedidosATdiv').innerHTML=result;
    ocultaDiv(33); ocultaDiv(44);
  },
  error: Error
 });	
}

 function busquedaReportePedidosRPAT(txtFHRCalendario33, txtFHRCalendario44, txt1FolioRP, txt2FolioRP, txtPedidoRP, selectEstatusRP, selectSubcentro, comboRegionRP, selectSalaRP, selectTecnicoRP, selectOperadoresRP,comboDepartamento){//alert(txtFHRCalendario33+' '+txtFHRCalendario44+' '+txt1FolioRP+' '+txt2FolioRP+' '+selectEstatusRP+' '+selectSubcentro+' '+comboRegionRP+' '+selectSalaRP+' '+selectTecnicoRP+' '+selectOperadoresRP+' '+comboDepartamento);
//alert(txtFHRCalendario33+' '+txtFHRCalendario44+' '+txt1FolioRP);
var txtFolioRP='';
if(txt1FolioRP!='' && txt1FolioRP!=' '){txtFolioRP=txt1FolioRP+'-'+txt2FolioRP;}
   $.ajax({
   url: '../Vistas/Reporte Pedidos/busquedaReportePedidos.php',
   type: 'POST',
   async: true,
   data: 'txtFHRCalendario33x='+txtFHRCalendario33+'&txtFHRCalendario44x='+txtFHRCalendario44+'&txtFolioRPx='+txtFolioRP+'&txtPedidoRPx='+txtPedidoRP+'&selectEstatusRPx='+selectEstatusRP+'&selectSubcentrox='+selectSubcentro+'&comboRegionRPx='+comboRegionRP+'&selectSalaRPx='+selectSalaRP+'&selectTecnicoRPx='+selectTecnicoRP+'&selectOperadoresRPx='+selectOperadoresRP+'&comboDepartamentox='+comboDepartamento,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   var arr = result.split('||');
   document.getElementById('resultadoRP').style.height='360px';
   document.getElementById('resultadoRP').innerHTML=arr[0];
   
   var form="<form action='../Vistas/Reporte Pedidos/ficheroExcelRP.php' method='post' id='FormularioExportacionRP'><textarea id='datos_a_enviarRP' name='datos_a_enviarRP' style='visibility:hidden' rows='1'></textarea><img src='imgs/export_to_excel.gif' style='float:right; cursor:pointer;' alt='exporta a excel' title='Exportar a Excel' class='botonExcel' onclick='exportarRF2Excel(\"RP\");'></form>";
   document.getElementById('totalRowsRP').innerHTML=form;
   },
   error: Error
   });//}
}
function detalleRepPed(folio, pedido){//alert(pedido);
window.open("../Vistas/Reporte Pedidos/detalleRepPed.php?pedidox="+pedido+"&foliox="+folio,"Detalle","width=1100,height=400,top=50,left=50,scrollbars=YES");
}
function devolucion(){
	ocultaDivs('PRODUCCION > Devolucion', 'devolucionesMdiv');
}
function crearDevolucion(area){ 
	$.ajax({
    url: '../vistas/devolucionesMat/crearDevolucion.php',
    type: 'POST',
   async: true,
   data: 'areax='+area+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){ document.getElementById('spanIngresaPiDe').innerHTML = result;
   },
   error: Error
   });
}
function ingresarPiezaDev(cod,can,serie,dev,area){
	var numeroSerie = serie.length; 
	if((cod=='601015'|| cod=='601019'|| cod=='601020'|| cod=='601023'|| cod=='601025'|| cod=='601026'|| cod=='601027'|| cod=='601028'|| cod=='601030'|| cod=='601035'|| cod=='601036'|| cod=='601040'|| cod=='601045'|| cod=='601046'|| cod=='601047'|| cod=='601048'|| cod=='601049'|| cod=='900035'|| cod=='350005'|| cod=='350006'|| cod=='350010'|| cod=='350015'|| cod=='350020'|| cod=='350025'|| cod=='350026'|| cod=='350027'|| cod=='350030'|| cod=='201110'|| cod=='201115'|| cod=='201116'|| cod=='201120'|| cod=='201121'|| cod=='201122'|| cod=='201123'|| cod=='201125'|| cod=='201126'|| cod=='201130'|| cod=='201131'|| cod=='201135'|| cod=='201140'|| cod=='602015'|| cod=='602016'|| cod=='602017'|| cod=='602018'|| cod=='602019'|| cod=='602020'|| cod=='602021'|| cod=='602022'|| cod=='602024'|| cod=='602026'|| cod=='602060'|| cod=='602065'|| cod=='602070'|| cod=='602075'|| cod=='602080'|| cod=='901020'|| cod=='304031'|| cod=='304032'|| cod=='304033'|| cod=='304045'|| cod=='304046'|| cod=='304048'|| cod=='556010'|| cod=='557030'|| cod=='557031'|| cod=='601018'|| cod=='602005'|| cod=='602006'|| cod=='602007'|| cod=='602008'|| cod=='602009'|| cod=='602010'|| cod=='602011'|| cod=='602012'|| cod=='602013'|| cod=='901032'|| cod=='601052'|| cod=='601055'|| cod=='653468'|| cod=='653469'|| cod=='100124'|| cod=='100251'|| cod=='100252'|| cod=='350035'|| cod=='350040'|| cod=='350041'|| cod=='350042'|| cod=='350044'|| cod=='350045'|| cod=='350047'|| cod=='350048'|| cod=='350049'|| cod=='100141'|| cod=='100142'|| cod=='100143'|| cod=='100144'|| cod=='100148'|| cod=='554020'|| cod=='700029'|| cod=='700085'|| cod=='700364'|| cod=='905049'|| cod=='905067'|| cod=='905078'|| cod=='905089'|| cod=='400034'|| cod=='400035'|| cod=='400040'|| cod=='400045'|| cod=='400050') && (numeroSerie<6)){
	
	/*if(cod==('350041' || '601015'||'601019'||'601020'||'601023'||'601025'||'601026'||'601027'||'601028'||'601030'||'601035'||'601036'||'601040'||'601045'||'601046'||'601047'||'601048'||'601049'||'900035'||'350005'||'350006'||'350010'||'350015'||'350020'||'350025'||'350026'||'350027'||'350030'||'201110'||'201115'||'201116'||'201120'||'201121'||'201122'||'201123'||'201125'||'201126'||'201130'||'201131'||'201135'||'201140'||'602015'||'602016'||'602017'||'602018'||'602019'||'602020'||'602021'||'602022'||'602024'||'602026'||'602060'||'602065'||'602070'||'602075'||'602080'||'901020'||'304031'||'304032'||'304033'||'304045'||'304046'||'304048'||'556010'||'557030'||'557031'||'601018'||'602005'||'602006'||'602007'||'602008'||'602009'||'602010'||'602011'||'602012'||'602013'||'901032'||'601052'||'601055'||'653468'||'653469'||'100124'||'100251'||'100252'||'350035'||'350040'||'350041'||'350042'||'350044'||'350045'||'350047'||'350048'||'350049'||'100141'||'100142'||'100143'||'100144'||'100148'||'554020'||'700029'||'700085'||'700364'||'905049'||'905067'||'905078'||'905089'||'400034'||'400035'||'400040'||'400045'||'400050') && (serie=='' || serie==' ')){*/
	alert('La serie del codigo '+cod+' es incorrecta, favor de revisar.'); return -1;}
	if(cod==''){alert('El campo CODIGO no puede estar vacio.'); return -1;}
	if(can==''){alert('El campo CANTIDAD no de ir vacio.'); return -1;}
	if(isNaN(can)){
						   alert("Se requiere una CANTIDAD numerica."); return -1;}
    document.getElementById("SerDevolucionMat").value="";
	$.ajax({
    url: '../vistas/devolucionesMat/ingresarPiezaDev.php',
    type: 'POST',
   async: true,
   data: 'codx='+cod+'&canx='+can+'&seriex='+serie+'&devx='+dev+'&areax='+area,
   dataType: "text",
   success: function Respuesta(result){if(result=='NOExiste'){alert("No existe el codigo "+cod);}
   else{document.getElementById('divTablaDev').innerHTML = result;}
   },
   error: Error
   });
}
function enviaDevMat(dev,observaciones,area,salaid){
	//if(salaid==0 || salaid==''){alert('Selecciona una Sala'); return -1;}
	$.ajax({
    url: '../vistas/devolucionesMat/enviaDevMat.php',
    type: 'POST',
   async: true,
   data: 'devx='+dev+'&observacionesx='+observaciones+'&areax='+area+'&salaidx='+salaid,
   dataType: "text",
   success: function Respuesta(result){ document.getElementById('spanIngresaPiDe').innerHTML = "";
   },
   error: Error
   });
}
function validaCodigo(valor){
	$.ajax({
    url: '../vistas/devolucionesMat/validaCodigo.php',
    type: 'POST',
   async: true,
   data: 'valorx='+valor,
   dataType: "text",
   success: function Respuesta(result){if(result=='1'){ document.getElementById("CanDevolucionMat").value="1";
   document.getElementById("CanDevolucionMat").disabled=true;}
   if(result=='2'){ document.getElementById("CanDevolucionMat").value="";
   document.getElementById("CanDevolucionMat").disabled=false;}
   },
   error: Error
   });
}
function poneSalaDevolucion(valor){//alert(valor);
	$.ajax({
  url: 'php/poneSalasDevolucion.php',
  type: 'POST',
  async: true,
  data: 'valorx='+valor,
  success: function Respuesta(result){//alert(result);
	  document.getElementById('salaAingresarPro').innerHTML=result;
	  },
  error: Error
 });
}
function CrearCB(){
	$.ajax({
		url: '../STOCK/CrearcodBarra.php',
		type: 'POST',
		async: true,
		data: '',
		dataType: "text",
		success: function Respuesta(result){
			document.getElementById('crearCB').innerHTML = result;
		// buscaInv("","TODAS","")
		},
	  error: Error
  	});
	ocultaDivs('PRODUCCION > Generar Codigo de Barras', 'crearCB');
}//Fin llamaInventario



function crearCodigoBarra(codigo){	//alert(codigo+'-'+lote+'-'+noimp+'-'+contador);
var url="../STOCK/GenerarCodigoBarra.php";
	if (codigo == ''){alert("Ingrese el codigo a imprimir");}
	else{			
		window.open("../STOCK/GenerarCodigoBarra.php?codigox="+codigo,"REPORTE","width=700,height=550,top=50,left=50,scrollbars=YES,status=YES,resizable=YES")}
}
function ReporteDevolucionMat(){var area='Produccion';
	if(document.getElementById('ReporteDevolucionesdiv').innerHTML == ''){
		$.ajax({
		   url: '../Vistas/Reporte Devoluciones/reporteDevoluciones.php',
		   type: 'POST',
		   async: true,
		   data: 'areax='+area,
		   dataType: "text",
		   success: function Respuesta(result){
		   	document.getElementById("ReporteDevolucionesdiv").innerHTML = result;
		   },
		   error: Error
		});
	}
	ocultaDivs('PRODUCCION > Reporte Devoluciones', 'ReporteDevolucionesdiv');
}
function busquedaDevolucionMat(Fini,Ffin,dev,area,clave,tecnico){
	$.ajax({
   url: '../Vistas/Reporte Devoluciones/busquedaDevolucionMat.php',
   type: 'POST',
   async: true,
   data: 'Finix='+Fini+'&Ffinx='+Ffin+'&devx='+dev+'&areax='+area+'&clavex='+clave+'&tecnicox='+tecnico,
   dataType: "text",
   success: function Respuesta(result){ var arr = result.split('||');
   document.getElementById("resDevolucionR").innerHTML = arr[0];
   document.getElementById("totalRowsDevR").innerHTML = "Total: "+arr[1];
   },
   error: Error
   });
}
function traeTecnico(region){//alert(region);
  $.ajax({
  url: '../AREA TECNICA/php/traeTecnicoDev.php',
  type: 'POST',
  async: true,
  data: 'regionx='+region,
  success: function respuesta(result){//alert(result);
	   document.getElementById("spanTraeTecnico").innerHTML = result;
	   },
  error: Error
 });
}
function busquedaDevolucionMatPieza(Fini,Ffin,dev,area,clave,tecnico){//alert(area);
	$.ajax({
   url: '../Vistas/Reporte Devoluciones/busquedaDevolucionMatPiezas.php',
   type: 'POST',
   async: true,
   data: 'Finix='+Fini+'&Ffinx='+Ffin+'&devx='+dev+'&areax='+area+'&clavex='+clave+'&tecnicox='+tecnico,
   dataType: "text",
   success: function Respuesta(result){ var arr = result.split('||');
   document.getElementById("resDevolucionR").innerHTML = arr[0];
   document.getElementById("totalRowsDevR").innerHTML = "Total: "+arr[1];
   },
   error: Error
   });
}

function detalledevMat(devolucion){
	window.open("../Vistas/Reporte Devoluciones/detalleDevMat.php?devolucionx="+devolucion+"&usuarioIDx="+usuarioID,"Detalle","width=1100,height=500,top=0,left=50,scrollbars=YES");
}
function reporteCNuevos(){
	$.ajax({
	   url: '../GTE_CUENTA/php/reporteContratos.php',
	   type: 'POST',
	   async: true,
	   data: '',
	   dataType: "text",
	   success: function Respuesta(result){
		   document.getElementById("divReporteContratos").innerHTML = result;
		   ocultaDiv(272);
		   ocultaDiv(273);
	   },
	   error: Error
	});
	ocultaDivs('PRODUCCION > Reportes > Reporte Contratos', 'divReporteContratos');
}
function busquedaReporteContratos(contratoID,txtFHRCalendario272,txtFHRCalendario273,salaid,selectUsuarioCN){
	//alert(contratoID+" - "+txtFHRCalendario272+" - "+txtFHRCalendario273+" - "+salaid+" - "+selectUsuarioCN);
	$.ajax({
   url: '../GTE_CUENTA/php/busquedaReporteContrato.php',
   type: 'POST',
   async: true,
   data: 'contratoIDx='+contratoID+'&txtFHRCalendario272x='+txtFHRCalendario272+'&txtFHRCalendario273x='+txtFHRCalendario273+'&salaidx='+salaid+'&selectUsuarioCNx='+selectUsuarioCN,
   dataType: "text",
   success: function Respuesta(result){
	   //var arr = result.split('||');
   document.getElementById("contenidoContrato").style.width='700px';
   document.getElementById("contenidoContrato").innerHTML=result
//   document.getElementById('totalFichas').innerHTML='Total de Filas: '+arr[1];
   },
   error: Error
 });
}
function MostrarMaqContrato(id){//alert(id);
	$.ajax({
   url: 'php/mostrarMaqContratoPro.php',
   type: 'POST',
   async: true,
   data: 'idx='+id,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   document.getElementById("tablaMaqContrato").style.width='200px';
   document.getElementById("tablaMaqContrato").innerHTML=result
   },
   error: Error
 });
}
function excelContratosMaq(contratoid){//alert(contratoid);
window.open("../GTE_CUENTA/php/excelContratoMaq.php?contratoidx="+contratoid,"CATALOGO","width=800,height=700,top=50,left=50,scrollbars=YES")
}
function quitaMaqContrato(contratoid,maquinaid){//alert(contratoid+"-"+maquinaid);
	
	$.ajax({
	 url: 'php/quitarMaqContrato.php',
	 type: 'POST',
	 async: true,
	 data: 'contratoidx='+contratoid+'&maquinaidx='+maquinaid,
	 success: function respuesta(result){//alert(result);
		 var arr = result.split('||');
		 if(arr[1]==1){alert('La maquina ya fue asignada a la OS '+ arr[2]); return -1;}
		 else{ MostrarMaqContrato(contratoid);}
				//quitaMaqContrato(contratoid,maquinaid); 
				},
	 error: Error
	});

}
function excelContratosMaq(contratoid){//alert(contratoid);
window.open("../GTE_CUENTA/php/excelContratoMaq.php?contratoidx="+contratoid,"CATALOGO","width=800,height=700,top=50,left=50,scrollbars=YES")
}
function reporteExcelContratos(contratoID,txtFHRCalendario272,txtFHRCalendario273,salaid,selectUsuarioCN){//alert(contratoID);
window.open("../GTE_CUENTA/php/excelContrato.php?contratoIDx="+contratoID+"&txtFHRCalendario272x="+txtFHRCalendario272+"&txtFHRCalendario273x="+txtFHRCalendario273+"&salaidx="+salaid+"&selectUsuarioCNx="+selectUsuarioCN,"CATALOGO","width=800,height=700,top=50,left=50,scrollbars=YES")
}
function cancelaPiezaDev(dev,ref,serie){//alert(dev+" - "+ref+" - "+serie);
$.ajax({
   url: '../Vistas/devolucionesMat/cancelaPiezaDev.php',
   type: 'POST',
   async: true,
   data: 'devx='+dev+'&refx='+ref+'&seriex='+serie,
   dataType: "text",
   success: function Respuesta(result){ 
   document.getElementById('divTablaDev').innerHTML = result;
   },
   error: Error
   });
}
function cancelarDev(devolucionid,Finix,Ffinx){//alert(devolucionid+"-"+Finix+"-"+Ffinx);
	$.ajax({
   url: 'php/cancelarDev.php',
   type: 'POST',
   async: true,
   data: 'devolucionidx='+devolucionid+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){alert(result);
   var dev=0;
   var area='Produccion';
   var clave='';
   if(result==''){alert('Se cancela Devolucion'); busquedaDevolucionMat(Finix,Ffinx,dev,area,clave)}
   else{alert('Error al cancelar');}
   },
   error: Error
 });
}
function buscaPlacas(){
  $.ajax({
  url: 'php/nuevoReportePlacas.php',
  type: 'POST',
  async: true,
  data: 'paisIDx='+paisID,
  success: function respuesta(result){
  	ocultaDivs('PRODUCCION > Maquinas y Placas', 'divMaquinasPlacas');
	document.getElementById('divMaquinasPlacas').innerHTML=result;
	},
  error: Error
 });
}

function busquedaMaquinasyPlacas(bodega,rack,nivel,numeroPlaca,n){//alert(bodega+" "+rack+" "+nivel+"-"+numeroPlaca);
var paisID=1;
  $.ajax({
  url: 'php/buscaMaquinasyPlacas.php',
  type: 'POST',
  async: true,
  data: 'bodegax='+bodega+'&rackx='+rack+'&nivelx='+nivel+'&numeroPlacax='+numeroPlaca+'&paisIDx='+paisID+'&nx='+n,
  success: function respuesta(result){//alert(result);
	   document.getElementById('mostrarMaquinasyPlacasDiv').innerHTML=result;
	   },
  error: Error
 });
}
function guardaPlaca(maquinaid,valor){//alert(maquinaid+"-"+valor);
var paisID=1;
  $.ajax({
  url: 'php/guardaPlaca.php',
  type: 'POST',
  async: true,
  data: 'maquinaidx='+maquinaid+'&valorx='+valor+'&usuarioIDx='+usuarioID,
  success: function respuesta(result){//alert(result);
	   if(result==''){alert('Datos Guardados');}
	   else{alert('Error al guardar');}
	   },
  error: Error
 });
}
function reportePlacas(){
  $.ajax({
  url: 'php/nuevoReportedePlacas.php',
  type: 'POST',
  async: true,
  data: 'paisIDx='+paisID,
  success: function respuesta(result){
  	ocultaDivs('PRODUCCION > Reporte de Placas', 'divReportedePlacas');
	document.getElementById('divReportedePlacas').innerHTML=result;
  },
  error: Error
 });
}
function traeDatosPlacas(valor,n){//alert(valor+" "+n);
	var campo = 'spanSalasPlacas';
if(n==2){if(valor=='%'){document.getElementById('spanSalasPlacas').innerHTML ="<select id='salaOS' style='font-size:10px'><option value='%'>TODAS</option></select>"; return -1;}}
  $.ajax({
  url: '../Vistas/reporteOrdenes/traeDatos.php',
  type: 'POST',
  async: true,
  data: 'valorx='+valor+'&nx='+n,
  dataType: "text",
  success: function Respuesta(result){document.getElementById(campo).innerHTML = result;},
  error: Error
  });
}
function buscaTipoPlacas(txtSerie,selectTipo,selectBodega,selectRegion,selectSala){//alert(txtSerie+"-"+selectTipo+"-"+selectBodega+"-"+selectRegion+"-"+selectSala);
  $.ajax({
  url: 'php/buscaPlacas.php',
  type: 'POST',
  async: true,
  data: 'txtSeriex='+txtSerie+'&selectTipox='+selectTipo+'&selectBodegax='+selectBodega+'&selectRegionx='+selectRegion+'&selectSalax='+selectSala,
  success: function respuesta(result){//alert(result);
  	var arr = result.split('||');
    document.getElementById("reportePlacas").style.height='400px';
    document.getElementById("reportePlacas").innerHTML=arr[0];
	   },
  error: Error
 });
}
function busquedaPlacasExcel(txtSerie,selectTipo,selectBodega,selectRegion,salaOS){
	window.open("php/buscaPlacasExcel.php?txtSeriex="+txtSerie+"&selectTipox="+selectTipo+"&selectBodegax="+selectBodega+"&selectRegionx="+selectRegion+"&salaOSx="+salaOS,"Detalle","width=1100,height=500,top=0,left=50,scrollbars=YES");
}
function imprimeCodQR(id,serie,modelo,mueble,ordenid){//alert(modelo);
	if(confirm("Imprimir codigos QR?")){
	if(modelo!="Bryke2" && modelo!="Blackplus1" && modelo!="FUSIONSL1" && modelo!="FUSIONUP1" && modelo!="D2BLACK1" && modelo!="D2BLACK3" && modelo!="D2BLUEW1" && modelo!="SZ8002" && modelo!="ZF4000" && modelo!="CD 001 PLUS" && modelo!="FUSION-AL1" && modelo!="FUSION-IL1" && modelo!="LUX1" && modelo!="Brk1" && modelo!="ALTIUS"  && modelo!="ILLUSION" && modelo!="ALLURE" && modelo!="FUSION"){alert("Solo modelos Bryke2, Blackplus1, FUSIONSL1, FUSIONUP1, SZ8002, ZF4000, Altius y Fusion"); return -1; }
	window.open("../ImpresionEtiquetas/php/impresionCodigosQR.php?idx="+id+"&seriex="+serie+"&modelox="+modelo+"&mueblex="+mueble+"&ordenidx="+ordenid+"&usuarioIDx="+usuarioID,"SALIDA","width=1000,height=600,top=50,left=50,scrollbars=YES");
//	window.open("../ImpresionEtiquetas/php/impresionCodQR.php?idx="+id+"&seriex="+serie+"&modelox="+modelo+"&mueblex="+mueble+"&usuarioIDx="+usuarioID,"SALIDA","width=1000,height=600,top=50,left=50,scrollbars=YES");
	}
}
//muestra lista de maquinas incompletas
function maqIncomp(){//alert('hi');
	if(document.getElementById('maqIncompletasDiv').innerHTML==''){
		$.ajax({
		   url: 'php/listaMaqIncomp.php',
		   type: 'POST',
		   async: true,
		   data: '',
		   dataType: "text",
		   success: function Respuesta(result){//alert(result);
		   		document.getElementById('maqIncompletasDiv').innerHTML=result;
				abrirListaMaqIncomp();
		   },
		   error: Error
	   });
	}
	ocultaDivs('PRODUCCION > Solicitudes de Pedidos', 'maqIncompletasDiv');
}
function abrirListaMaqIncomp(){
    $.ajax({
    url: 'php/listaMaquinas.php',
    type: 'POST',
   async: true,
   data: '',
   dataType: "text",
   success: function Respuesta(result){
   document.getElementById('listaMaquinasIncompDiv').innerHTML = result;
   document.getElementById('listaMaquinasIncompDiv').style.width ='190px';
   if(document.getElementById('buscaListaMaquinasIncom')!=''){document.getElementById('buscaListaMaquinasIncom').value='';}
  },
   error: Error
   });
}
function nuevoMaquinaIncomp(){//alert(fol);
	if(confirm ('Deseas Abrir un nuevo Folio?')){
     $.ajax({
    url: 'php/nuevoMaquinaIncompleta.php',
    type: 'POST',
   async: true,
   data: 'usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){var arr = result.split(',,');
   var ele; var con;
   if(document.getElementById(seleccionada+'Div')){document.getElementById(seleccionada+'Div').style.display= "none";}
   /*document.getElementById('contenido').innerHTML += div;*/con=document.getElementById('contenido');
   ele = document.createElement('div');
   ele.id = arr[1]+'Div';
   con.appendChild(ele);
   document.getElementById(arr[1]+'Div').style.display= "block";
   document.getElementById(arr[1]+'Div').innerHTML = arr[0];
   insertarPestana(arr[1], 'Folio '+ arr[1]);
   
   },
   error: Error
   });
   document.getElementById('dir').innerHTML='PRODUCCION > Folio Produccion';
	}
	}

function mostrarMaquinaIncomp(folioID){//alert(folio+' '+estatus);
if(document.getElementById(folioID+'Div')){mostrar(folioID);}
else{
	if(tope <= maxPestanas){
   $.ajax({
   url: 'php/mostrarMaquinaIncompleta.php',
   type: 'POST',
   async: true,
   data: 'folioIDx='+folioID+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
	   
   var div='<div id="'+folioID+'Div"></div>';//var ele; var con;
   if(seleccionada!=''){document.getElementById(seleccionada+'Div').style.display= "none";}
   insertarPestana(folioID, 'Folio '+ folioID); 
   document.getElementById('contenido').innerHTML += div; 
   document.getElementById(folioID+'Div').style.display= "block";
   document.getElementById(folioID+'Div').innerHTML = result;
  },
   error: Error
   });}else{alert("ya no se pueden insertar mas pestanas");}// termina if (tope <= maxPestanas)
   }
	
   }
function guardaDatos(folioID,comentario,serieMaq){//alert(folioID+"-"+comentario+"-"+serieMaq);
	//if(completo == true){var estatusMaq='completo';}else{var estatusMaq='incompleto';}
 $.ajax({
  url: 'php/guardaDatosMaqIncomp.php',
  type: 'POST',
  async: true,
  data: 'folioIDx='+folioID+'&comentariox='+comentario+'&serieMaqx='+serieMaq+'&usuarioIDx='+usuarioID,
  success: function resp(result){//alert(result);
  if(result=='sinSerie'){alert('La serie '+serieMaq+' No Existe o No esta en Bodega'); return -1;}
  if(result==''){alert('Datos Guardados Correctamente');}
	 traeComentariosPro(folioID);
		
  },
  error: Error
 });
}
function traeComentariosPro(folioID){//alert(folio);
	$.ajax({
    url: 'php/traeCometarioProd.php',
    type: 'POST',
   async: true,
   data: 'NumFoliox='+folioID,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
	   document.getElementById('historial'+folioID).value = result;
	   var elem =document.getElementById('historial'+folioID);
    elem.scrollTop = elem.scrollHeight;
   document.getElementById('comentario'+folioID).value = '';},
   error: Error
   });
}
function terminaFol(folioID){//alert(folioID);
if(confirm ('Desea Cerrar el Folio?')){
	$.ajax({
    url: 'php/terminaFolioProd.php',
    type: 'POST',
   async: true,
   data: 'NumFoliox='+folioID+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){	  
   if(result==''){alert('Folio Cerrado Correctamente');
   document.getElementById(folioID+'Div').innerHTML = '';
   abrirListaMaqIncomp();cerrarPedido(folioID);}
   },
   error: Error
   });
}
}
function agregarFilaRep(fol){var conv=document.getElementById('contadorInput'+fol).name;
var con=parseInt(conv); var con2=con+1; var d9;
var d1 ='<input size="15" id="clavePedido'+fol+''+conv+'" maxlength="6" onKeyUp="traeDescrRefaccion(this,\''+fol+'\');" name="'+conv+'" />'; 
//d6='<input size="6" id="licenciaPedido'+fol+''+conv+'" maxlength="10" name="'+fol+''+conv+'" onKeyUp="buscaLicenciaSF(this.value,this.name);"/><div class="divBuscaFallas" id="divBuscaLicenciasSF'+fol+''+conv+'" ></div>';
var d2="<input size='15' id='cantidadPedido"+fol+""+conv+"' />";   //d7='<input size="6" id="versionPedido'+fol+''+conv+'"/>';
//var d3="<input size='6' id='seriePedido"+fol+""+conv+"' />";    d8='<input size="6" id="ipPedido'+fol+''+conv+'"/>';
//var d4="<select id='cajaPedido"+fol+""+conv+"'><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='ATR'>ATR</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='SAC'>SAC</option><option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option><option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option><option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
//var d9=document.getElementById('JuegoPedidoTD1').innerHTML;/*'<input size="6" id="clave2" maxlength="6"/>';*/
//var d5="<select id='denominacionPedido"+fol+""+conv+"'><option value=''></option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option><option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";
//var d10='<input size="30" id="motivoPedido'+fol+''+conv+'" />';
//var d12='<textarea id="diagnosticoPedido'+fol+''+conv+'" cols="20" rows="2"></textarea>';
var d11='<textarea id="descRef'+fol+''+conv+'" cols="50" rows="2" readonly></textarea>';
var table = document.getElementById('tablaNuevoPedido'+fol); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;
//row.style.background=fondo;
var cell, text;
$.ajax({
  url: '../CC/php/traeJuegos.php',
  type: 'POST',
  async: true,
  data: 'numx='+conv+'&folx='+fol,
  dataType: "text",
  success: function Respuesta(result){d9=result
        celClave = row.insertCell(-1);
  celClave.style.background='#F5F5F5'; celClave.style.border='#ccc solid 1px'; celClave.align='center';
  textv = con;  celClave.innerHTML=textv;
  celCla = row.insertCell(-1);  celCla.align='center'; text1 = d1;  celCla.innerHTML=text1;
  celDeR = row.insertCell(-1);  celDeR.align='center'; text11 = d11;  celDeR.innerHTML=text11;
  celCan = row.insertCell(-1);  celCan.align='center'; text2 = d2;  celCan.innerHTML=text2;
  /*celSer = row.insertCell(-1);  text3 = d3;  celSer.innerHTML=text3;
  celCaj = row.insertCell(-1);  text4 = d4;  celCaj.innerHTML=text4;
  celDen = row.insertCell(-1);  text5 = d5;  celDen.innerHTML=text5;
  celLic = row.insertCell(-1);  text6 = d6;  celLic.innerHTML=text6;
  celVer = row.insertCell(-1);  text7 = d7;  celVer.innerHTML=text7;
  celIp = row.insertCell(-1);  text8 = d8;  celIp.innerHTML=text8;
  celJue = row.insertCell(-1);  /*text9 = d9;  celJue.innerHTML=d9;
  celMot = row.insertCell(-1);  text10 = d10;  celMot.innerHTML=text10;
  celMot = row.insertCell(-1);  text12 = d12;  celMot.innerHTML=text12;*/
  document.getElementById('contadorInput'+fol).name=con2;
  document.getElementById('clavePedido'+fol+conv).focus(); if(fol!='0'){buscaDatosLicFol(2,fol);}
  },
  error: Error
 });
}
function traeDescrRefaccion(campo,fol){//alert(campo.name);
 var valor=campo.value;

if(valor.length==6){//alert(valor);
$.ajax({
 url: '../CC/php/traeDesRefaccion.php',
 type: 'POST',
 async: true,
 data: 'valorx='+valor,
 dataType: "text",
 success: function Respuesta(result){var arr = result.split('*');
 document.getElementById('descRef'+fol+campo.name).value = arr[0];if(arr[0]=='La Clave no existe'){
 document.getElementById(campo.id).style.backgroundColor='#EFD3DE'; }else{document.getElementById(campo.id).style.backgroundColor='#FFF';}
 if(arr[1]==16){document.getElementById('cantidadPedido'+fol+campo.name).value=1; document.getElementById('cantidadPedido'+fol+campo.name).readOnly=true;document.getElementById('seriePedido'+fol+campo.name).focus();}else{document.getElementById('cantidadPedido'+fol+campo.name).readOnly=false;} },
 error: Error
 });}
 else{document.getElementById('descRef'+fol+campo.name).value = '';}
}function puenteLap(clave, estatus, fol,ref){//alert(clave+' '+estatus+' '+fol);
	if(estatus==124){ validaPiezaObsoleta(clave); return -1;}
	window.opener.agregarPieza(clave, estatus, fol,ref);
	alert('Pieza '+clave+' agregada');
}
function ventanaCatalogoPiezasRep(fol/*ref,dep,nom,c*/){
	var idioma=1;//alert(fol);
window.open("php/catalogoPiezasRep.php?folx="+fol+'&idiomax='+idioma+" ","CANCELACION","width=900,height=800,top=50,left=50,scrollbars=YES,status=YES, resizable=YES");
}
function puenteRep(clave, estatus, fol,ref){//alert(clave+' '+estatus+' '+fol);
	if(estatus==124){ validaPiezaObsoleta(clave); return -1;}
	window.opener.agregarPiezaRep(clave, estatus, fol,ref);
	alert('Pieza '+clave+' agregada');
}
function validaPiezaObsoleta(clave){//alert(clave);
   $.ajax({
   url: '../../CC/php/validaPiezaObsoleta.php',
   type: 'POST',
   async: true,
   data: 'clavex='+clave,
   dataType: "text",
   success: function Respuesta(result){alert(result);
   },
   error: Error
   });
}
function busquedaCatalogoPiezasRep(selectFamiliaCP, codigoCP, nombreCP, selectMaquinaCP, fol){//alert(selectFamiliaCP+' '+codigoCP+' '+nombreCP+' '+selectMaquinaCP+' '+fol);

   $.ajax({ 
   url: '../php/busquedaCatalogoPiezasRep.php',
   type: 'POST',
   async: true,
   data: 'selectFamiliaCPx='+selectFamiliaCP+'&codigoCPx='+codigoCP+'&nombreCPx='+nombreCP+'&selectMaquinaCPx='+selectMaquinaCP+'&folx='+fol,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   var arr = result.split(',,');
   //document.getElementById('resultadoCP').style.height='440px';
   document.getElementById('resultadoCP').innerHTML='';
   //document.getElementById('resultadoCP').style.overflow='auto';
   //document.getElementById('resultadoCP').style.height='440px';
   document.getElementById('cabeceraCP').innerHTML=arr[1];
   document.getElementById('resultadoCP').innerHTML=arr[2];
   },
   error: Error
   });
}
function agregarPiezaRep(clave, estatus, fol,ref){//alert(clave+' '+estatus+' '+fol);
var conv=document.getElementById('contadorInput'+fol).name;//alert(conv);
var cont=conv-1;//alert(cont);
if(document.getElementById('clavePedido'+fol+cont) && document.getElementById('clavePedido'+fol+cont).value==''){//alert('existo');
	
	if(estatus=='16'){//alert('soy 16');
	document.getElementById('clavePedido'+fol+cont).value=clave;
	document.getElementById('descRef'+fol+cont).value=ref;
	document.getElementById('cantidadPedido'+fol+cont).value=1;
	document.getElementById('cantidadPedido'+fol+cont).readOnly='true';}
	if(estatus!='16'){//alert('soy 15');
	document.getElementById('clavePedido'+fol+cont).value=clave;document.getElementById('descRef'+fol+cont).value=ref;}
}else{//alert('ya entre');
var con=parseInt(conv); var con2=con+1; var d9; //alert(con);
var d1 ='<input size="15" id="clavePedido'+fol+conv+'" value='+clave+' maxlength="6" onKeyUp="traeDescrRefaccion(this,\''+fol+'\');" name="'+conv+'" />'; 
//var d6='<input size="6" id="licenciaPedido'+fol+conv+'" maxlength="10" name="'+fol+''+conv+'" onKeyUp="buscaLicenciaSF(this.value,this.name);"/><div class="divBuscaFallas" id="divBuscaLicenciasSF'+fol+''+conv+'" /></div>';
if(estatus=='16'){var d2="<input size='15' id='cantidadPedido"+fol+conv+"' value='1' readOnly='readonly'/>";}else{
var d2="<input size='15' id='cantidadPedido"+fol+conv+"' />";}   
//var d7='<input size="6" id="versionPedido'+fol+conv+'" />';
//var d3="<input size='6' id='seriePedido"+fol+conv+"' />"; 
//var d8='<input size="6" id="ipPedido'+fol+conv+'" />';
//var d4="<select id='cajaPedido"+fol+conv+"'><option value=''></option><option value='Axes'>Axes</option><option value='Ace System'>Ace System</option><option value='Caja Zitro'>Caja Zitro</option><option value='Colimex'>Colimex</option><option value='GGS'>GGS</option><option value='I View'>I View</option><option value='Sielcon'>Sielcon</option><option value='Twin'>Twin</option><option value='Alesis'>Alesis</option><option value='Electrochance'>Electrochance</option><option value='Genesis'>Genesis</option><option value='Wingos'>Wingos</option><option value='Kristal'>Kristal</option><option value='Nexus'>Nexus</option><option value='Smac'>Smac</option><option value='Win System'>Win System</option><option value='Wixes'>Wixes</option><select>";
////var d9=document.getElementById('JuegoPedidoTD1').innerHTML;/*'<input size="6" id="clave2" maxlength="6"/>';*/
//var d5="<select id='denominacionPedido"+fol+conv+"'><option value=''></option><option value='(1)-2-5-10'>(1)-2-5-10</option><option value='50c-(1)-2-5-10'>50c-(1)-2-5-10</option><option value='(50c)-1-2-5-10'>(50c)-1-2-5-10</option><option value='(10c)-20c-50c-1-2'>(10c)-20c-50c-1-2</option></select>";
//var d10='<input size="30" id="motivoPedido'+fol+conv+'" />';
var d11='<textarea id="descRef'+fol+''+conv+'" cols="45" rows="2" readonly>'+ref+'</textarea>';
//var d12='<textarea id="diagnosticoPedido'+fol+''+conv+'" cols="20" rows="2"></textarea>';
var table = document.getElementById('tablaNuevoPedido'+fol); 
var row = table.insertRow(-1);
row.id='rowEnt'+con;
var cell, text;
$.ajax({
  url: '../CC/php/traeJuegos.php',
  type: 'POST',
  async: true,
  data: 'numx='+conv+'&folx='+fol,
  dataType: "text",
  success: function Respuesta(result){d9=result
        celClave = row.insertCell(-1);
  celClave.style.background='#F5F5F5'; celClave.style.border='#ccc solid 1px'; celClave.align='center';
  textv = con;  celClave.innerHTML=textv;
  celCla = row.insertCell(-1);  text1 = d1;  celCla.innerHTML=text1;
  celDeR = row.insertCell(-1);  text11 = d11;  celDeR.innerHTML=text11; 
  celCan = row.insertCell(-1);  text2 = d2;  celCan.innerHTML=text2;
 /* celSer = row.insertCell(-1);  text3 = d3;  celSer.innerHTML=text3;
  celCaj = row.insertCell(-1);  text4 = d4;  celCaj.innerHTML=text4;
  celDen = row.insertCell(-1);  text5 = d5;  celDen.innerHTML=text5;
  celLic = row.insertCell(-1);  text6 = d6;  celLic.innerHTML=text6;
  celVer = row.insertCell(-1);  text7 = d7;  celVer.innerHTML=text7;
  celIp = row.insertCell(-1);  text8 = d8;  celIp.innerHTML=text8;
  celJue = row.insertCell(-1);  /*text9 = d9;  celJue.innerHTML=d9;
  celMot = row.insertCell(-1);  text10 = d10;  celMot.innerHTML=text10;
  celMot = row.insertCell(-1);  text12 = d12;  celMot.innerHTML=text12;*/
  document.getElementById('contadorInput'+fol).name=con2;},
  error: Error
 });}
}
function enviaSupervisorRep(c,sol,fol){var area='0'; var sala; var tecnico; //alert("sol"+'-'+sol);

var conv=document.getElementById('contadorInput'+fol).name;
var con=parseInt(conv); var con2=con-1; var c1; var c2; var c3; var c4; var c5; var c6; var c7; var c8; var c9; var c10; var c11; var d='';
var arr = new Array(); var j=0;var refac; var serie; var pedido; var ref; var ser; var pedido2;

/*for(var x=c;x<conv;x++){
	if(document.getElementById('clavePedido'+fol+x).value!='' && document.getElementById('clavePedido'+fol+x).value.length==6 && document.getElementById('clavePedido'+fol+x).style.backgroundColor!='#efd3de'){
refac=document.getElementById('clavePedido'+fol+x).value;
serie=document.getElementById('seriePedido'+fol+x).value;
pedido=refac + serie;
for(var y=x+1;y<conv;y++){
ref=document.getElementById('clavePedido'+fol+y).value;
ser=document.getElementById('seriePedido'+fol+y).value;
pedido2=ref + ser;
if(pedido==pedido2){
alert("En la fila "+(x)+" y la fila "+(y)+" tienen la misma clave y serie");
return -1;}}}//fin de if clave!='' && lenngth==6
}//fin primer for*/

for(var i=c;i<conv;i++){ //alert(i);
if(document.getElementById('clavePedido'+fol+i).value!='' && document.getElementById('clavePedido'+fol+i).value.length==6 && document.getElementById('clavePedido'+fol+i).style.backgroundColor!='#efd3de'){ 
c1=document.getElementById('clavePedido'+fol+i).value; c2=document.getElementById('cantidadPedido'+fol+i).value;
//c3=document.getElementById('seriePedido'+fol+i).value; c4=document.getElementById('cajaPedido'+fol+i).value;
//c5=document.getElementById('denominacionPedido'+fol+i).value; c6=document.getElementById('licenciaPedido'+fol+i).value;
//c7=document.getElementById('versionPedido'+fol+i).value; c8=document.getElementById('ipPedido'+fol+i).value;
//c9=document.getElementById('juegoPedido'+fol+i).value; c10=document.getElementById('motivoPedido'+fol+i).value;
//c11=document.getElementById('diagnosticoPedido'+fol+i).value;
if(!/^([0-9])*$/.test(c2) || c2==' '){alert('El campo Cantidad debe ser numerico'); return -1;}
//d=d+c1+'||'+c2+'||'+c3+'||'+c4+'||'+c5+'||'+c6+'||'+c7+'||'+c8+'||'+c9+'||'+c10+'||'+c11+'.%.';
d=d+c1+'||'+c2+'.%.';
j++;}
  	}if(d==''){alert("No pueden estar vacios los campos");return -1;}
if(document.getElementById('texaObservacionesNP'+fol)){
		var texa=document.getElementById('texaObservacionesNP'+fol).value;var valor=1;
		}else{var texa=document.getElementById('texaObservaciones'+sol+fol).value;var valor=2;}
if(fol!=0){  if(document.getElementById('selectDepartamento').value=='Sala'){alert("Eligue un Area"); return false;
				if(sala=='' || tecnico==''){alert("El campo Sala o Tecnico estan vacio");return false;}
             }
			 else{area=document.getElementById('selectDepartamento').value; sala=0; tecnico=document.getElementById('nombreSolicitanteM').value;
				 }

}
//alert(d+'-'+j+'-'+fol+'-'+sol+'-'+texa+'-'+valor+'-'+sala+'-'+tecnico+'-'+usuarioID+'-'+area+'-'+paisID+'-'+idioma);

	$.ajax({
   url: 'php/ingresaPedidoRep.php',
   type: 'POST',
   async: true,
   data: 'arreglox='+d+'&jx='+j+'&folx='+fol+'&solx='+sol+'&texax='+texa+'&valorx='+valor+'&salax='+sala+'&tecnicox='+tecnico+'&usuarioIDx='+usuarioID+'&areax='+area+'&paisIDx='+paisID+'&idiomax='+idioma,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
if(result=='Repetido'){alert("No se pueden ingresar piezas con la misma serie");}else{var arr = result.split('||');if(arr[0]=='.-.'){document.getElementById('PedidoDiv'+fol).innerHTML=arr[1];}
   else{if(fol==0){alert("Numero de Solicitud: "+result);document.getElementById('divSolMateriales').innerHTML =''}else{document.getElementById('spanNuevoPedido'+fol).innerHTML =arr[0];document.getElementById('spanEnviaSup'+fol).innerHTML =arr[1];   document.getElementById('divSolMateriales').innerHTML ='';}}}
   },
   error: Error
      });
}
/*------------------------ INICIO relacion componente------------------*/
function RelSerieComDos(){
	$.ajax({
	  url: '../STOCK/nuevoBuscaQRCom.php',
	  type: 'POST',
	  async: true,
	  data: 'valorx='+valor,
	  dataType: "text",
	  success: function Respuesta(result){
		  document.getElementById('divRelacionComSerieDos').innerHTML = result;
	  },
	  error: Error
  	});
	ocultaDivs('PRODUCCION > Relacionar Serie a Componente', 'divRelacionComSerieDos, #maqIncompletasDiv');
}
function AntesBuscarQRComDos(key,valor){//alert(key+" - "+valor);
if(key.keyCode==13){  if(valor!=""){ traeDatosComDos(valor);}
	}
}
function traeDatosComDos(valor){//alert(valor);
	$.ajax({
	  url: '../STOCK/traeDatosComDos.php',
	  type: 'POST',
	  async: true,
	  data: 'valorx='+valor,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
		  document.getElementById('contenidoBuscaQR').innerHTML = result;
	 ;},
	  error: Error
  });
}
function guardaSerieComNuevo(key,valorid,serieCodigo,n){//alert(key+"-"+valorid+"-"+serieCodigo+"-"+n);
if(key.keyCode==13){//alert(valorid+"-"+serieCodigo+"-"+n);
	$.ajax({
	  url: '../STOCK/guardaDatosComponentes.php',
	  type: 'POST',
	  async: true,
	  data: 'valoridx='+valorid+'&serieCodigox='+serieCodigo+'&nx='+n,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
	  if(result=='cero'){alert('A este QR no le puedes cambiar el No SERIE'); return -1;}
		  if(result=='' || result==' '){alert('Datos Guardados Correctamente');}
		  else{alert('Error al Guardar');}
	 ;},
	  error: Error
  	});
	}
}
function agregaCom(key,codigoqr,valorid,n){//alert(key+"-"+valorid+"-"+serieCodigo+"-"+n);
if(key.keyCode==13){//alert(codigoqr+"-"+valorid+"-"+n);
	$.ajax({
	  url: '../STOCK/guardaComponenteRelacionado.php',
	  type: 'POST',
	  async: true,
	  data: 'valoridx='+valorid+'&codigoqrx='+codigoqr+'&nx='+n,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
	  if(result=='codNoExiste'){alert('El Codigo QR '+codigoqr+' No Existe!'); 
	  if(n==1){document.getElementById('inputCompUno').value = '';}
	  if(n==2){document.getElementById('inputCompDos').value = '';}
	  if(n==3){document.getElementById('inputCompTres').value = '';}
	  if(n==4){document.getElementById('inputCompCuatro').value = '';}
	  if(n==5){document.getElementById('inputCompCinco').value = '';}
	  if(n==6){document.getElementById('inputCompSeis').value = '';}
		   return -1;}
	  if(result=='asignado'){alert('El Codigo QR '+codigoqr+' Esta Relacionado a otro Componente!'); 
	  if(n==1){document.getElementById('inputCompUno').value = '';}
	  if(n==2){document.getElementById('inputCompDos').value = '';}
	  if(n==3){document.getElementById('inputCompTres').value = '';}
	  if(n==4){document.getElementById('inputCompCuatro').value = '';}
	  if(n==5){document.getElementById('inputCompCinco').value = '';}
	  if(n==6){document.getElementById('inputCompSeis').value = '';}
		   return -1;}
		  if(result=='' || result==' '){}
		  else{alert('Error al Guardar');}
	 ;},
	  error: Error
  	});
	}
}
function agregaSerieCom(key,serieQR,codigoqr,valorid,n,qrPrincipal){//alert(key+"-"+valorid+"-"+serieCodigo+"-"+n);
if(key.keyCode==13){//alert(serieQR+"-"+codigoqr+"-"+valorid+"-"+n);
	$.ajax({
	  url: '../STOCK/guardaSerieComponente.php',
	  type: 'POST',
	  async: true,
	  data: 'serieQRx='+serieQR+'&codigoqrx='+codigoqr+'&valoridx='+valorid+'&nx='+n+'&qrPrincipalx='+qrPrincipal,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
	  //if(result=='serieUsada'){alert('La serie '+serieQR+' Ya esta asiganada a otro componente'); return -1;}
	  if(result=='sinQR'){alert('Primero Ingresa el QR de la Pieza'); 
	  if(n==1){document.getElementById('inputRelSerieCompUno').value = '';}
	  if(n==2){document.getElementById('inputRelSerieCompDos').value = '';}
	  if(n==3){document.getElementById('inputRelSerieCompTres').value = '';}
	  if(n==4){document.getElementById('inputRelSerieCompCuatro').value = '';}
	  if(n==5){document.getElementById('inputRelSerieCompCinco').value = '';}
	  if(n==6){document.getElementById('inputRelSerieCompSeis').value = '';}
	  if(n==7){document.getElementById('inputRelSerieCompSiete').value = '';}
	  return -1;}
		  if(result=='' || result==' '){alert('Datos Guardados Correctamente'); traeDatosComDos(qrPrincipal);}
		  else{alert('Error al Guardar');}
	 ;},
	  error: Error
  	});
	}
}
function limpiaDivRelacionarDos(){
	document.getElementById('contenidoBuscaQR').innerHTML = '';
	document.getElementById('inputCoQRComDos').value = '';
}
function verRelacionados(inputCoQRComDos){//alert(inputCoQRComDos);
//if(key.keyCode==13){alert(valorid+"-"+serieCodigo+"-"+n);
	$.ajax({
	  url: '../STOCK/mostrarCodigosQR.php',
	  type: 'POST',
	  async: true,
	  data: 'codQRx='+inputCoQRComDos,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
	  document.getElementById('contenidoBuscaQR').innerHTML = result;
		  //if(result=='' || result==' '){alert('Datos Guardados Correctamente');}
		  //else{alert('Error al Guardar');}
	 ;},
	  error: Error
  	});
	//}
}
function desasociaQR(idCodaQuitar,codigoQRPrin){//alert(idCodaQuitar+"-"+codigoQRPrin);
	$.ajax({
	  url: '../STOCK/quitaRelacionQR.php',
	  type: 'POST',
	  async: true,
	  data: 'idCodaQuitarx='+idCodaQuitar+'&codigoQRPrinx='+codigoQRPrin,
	  dataType: "text",
	  success: function Respuesta(result){//alert(result);
	  document.getElementById('contenidoBuscaQR').innerHTML = result;
		  if(result=='' || result==' '){verRelacionados(codigoQRPrin);}
		  else{alert('Error al Guardar');}
	 ;},
	  error: Error
  	});
	//}
}
/*----------------------- FIN relación componente---------------------------*/
/*----------------------- INICIO relacion de componentes ----------------------*/
function RComponente(){
	ocultaDivs('PRODUCCION > Relacion componentes', 'divReporteComponete');

	$.ajax({
	  url: '../ImpresionEtiquetas/php/reporteRelComponente.php',
	  type: 'POST',
	  async: true,
	  data: '',
	  dataType: "text",
	  success: function Respuesta(result){
	  	document.getElementById('divReporteComponete').innerHTML = result;
	  	//document.getElementById('spanRegionSala').style.display="none";
	  },
	  error: Error
  });
}
function traeSalas(valor){
	var n=1;
	$.ajax({
	  url: '../ImpresionEtiquetas/php/traeSalas.php',
	  type: 'POST',
	  async: true,
	  data: 'valorx='+valor+'&nx='+n,
	  dataType: "text",
	  success: function Respuesta(result){document.getElementById('spanComboSalas').innerHTML = result;
	 ;},
	  error: Error
  });
}
function busquedaRepRelComponente(sala,serie,componente){
	$.ajax({
	  url: '../ImpresionEtiquetas/php/busquedaRepRelComponente.php',
	  type: 'POST',
	  async: true,
	  data: 'salax='+sala+'&seriex='+serie+'&componentex='+componente,
	  dataType: "text",
	  success: function Respuesta(result){document.getElementById('resultadoFRetorno').innerHTML = result;
	 ;},
	  error: Error
  });
}
function antesBuscarMaqCom(key,valor){//alert(key+" - "+valor+" - "+maquinaid);
if(key.keyCode==13){  if(valor!=""){ buscarMaqCom(valor);}
}
}
function buscarMaqCom(valor){
	$.ajax({
	  url: '../ImpresionEtiquetas/php/buscaInvRMC2.php',
	  type: 'POST',
	  async: true,
	  data: 'valorx='+valor,
	  dataType: "text",
	  success: function Respuesta(result){document.getElementById('divInvRMC').innerHTML = result;

		 //document.getElementById('inputCodComponenteRM').value="";
	 },
	  error: Error
  });
}
/*----------------------- FIN relación de componentes -------------------------*/
/*----------------------- INICIO imp de componentes sin relaxionar-------------------------*/
function impCompSinRel(){
	$.ajax({
	  url: 'php/inputImpresionMaq.php',
	  type: 'POST',
	  async: true,
	  data: 'valorx='+valor,
	  dataType: "text",
	  success: function Respuesta(result){
	  	document.getElementById('divImpCompMaq').innerHTML = result;
		 //document.getElementById('inputCodComponenteRM').value="";
	  },
	  error: Error
  	});
	ocultaDivs('PRODUCCION > Impresion de componentes de máquina', 'divImpCompMaq');
}
function impComMaqSinVincular(serie){
		//if(modelo!="Bryke2" && modelo!="Blackplus1" && modelo!="FUSIONSL1" && modelo!="FUSIONUP1" && modelo!="D2BLACK1" && modelo!="D2BLACK3" && modelo!="D2BLUEW1" && modelo!="SZ8002" && modelo!="ZF4000" && modelo!="CD 001 PLUS" && modelo!="FUSION-AL1" && modelo!="FUSION-IL1" && modelo!="LUX1" && modelo!="Brk1" && modelo!="ALTIUS"  && modelo!="ILLUSION" && modelo!="ALLURE" && modelo!="FUSION"){alert("Solo modelos Bryke2, Blackplus1, FUSIONSL1, FUSIONUP1, SZ8002, ZF4000, Altius y Fusion"); return -1; }
	window.open("../ImpresionEtiquetas/php/impresionCodigosQR.php?serieMaqx="+serie+"&usuarioIDx="+usuarioID,"SALIDA","width=1000,height=600,top=50,left=50,scrollbars=YES");
//	
	//	window.open("../ImpresionEtiquetas/php/impresionComMaqSinVincular.php?serieMaqx="+serie+"&usuarioIDx="+usuarioID,"SALIDA","width=1000,height=600,top=50,left=50,scrollbars=YES");
}
/*----------------------- FIN imp de componentes sin relaxionar-------------------------*/
//////////////////////////////////////////conversion de maquinas
function conversionMaq(){
	ocultaDivs('PRODUCCION > Conversion de Maquinas', 'divConversionMaq');	
}
function traeDatosLicenciaConv(n,licencia){//alert(n);
	$.ajax({ 
   url: 'php/datosMaqConversion.php',
   type: 'POST',
   async: true,
   data: 'licenciax='+licencia+'&nx='+n,
   //data: 'licenciax='+licencia+'&codigoCPx='+codigoCP+'&nombreCPx='+nombreCP+'&selectMaquinaCPx='+selectMaquinaCP+'&folx='+fol,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   /*if(result=="datoNoValido"){alert("Dato no valido.");}
   else{
	   if(result=="NoBlackwave"){alert("Las maquinas deben ser Blackwave.");}
	   else{document.getElementById('divDatosConversion').innerHTML=result;}
   }*/
   
   if(result!="datoNoValido" && result!="NoBlackwave"){document.getElementById('divDatosConversion').innerHTML=result;}
   else{
	   if(result=="datoNoValido"){alert("Dato no valido.");}
       if(result=="NoBlackwave"){alert("Las maquinas deben ser Blackwave.");}
   }
   },
   error: Error
   });
}
//data: 'licenciax='+licencia+'&codigoCPx='+codigoCP+'&nombreCPx='+nombreCP+'&selectMaquinaCPx='+selectMaquinaCP+'&folx='+fol,
function tablaConversion(dato,cadena){var n=2;
	$.ajax({ 
   url: 'php/datosMaqConversion.php',
   type: 'POST',
   async: true,
   data: 'datox='+dato+'&nx='+n+'&cadenax='+cadena,
   dataType: "text",
   success: function Respuesta(result){
   document.getElementById('divTablaConversion').innerHTML=result;
   },
   error: Error
   });
}
 function tablaConversionOS(dato,os){var n=4;
	 $.ajax({ 
   url: 'php/datosMaqConversion.php',
   type: 'POST',
   async: true,
   data: 'datox='+dato+'&nx='+n+'&osx='+os,
   dataType: "text",
   success: function Respuesta(result){
   document.getElementById('divTablaConversion').innerHTML=result;
   },
   error: Error
   });
 }
function convertirMaquina(n,tipo,cadena){
	$.ajax({ 
   url: 'php/datosMaqConversion.php',
   type: 'POST',
   async: true,
   data: 'datox='+tipo+'&nx='+n+'&cadenax='+cadena+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){alert(result); if(result==''){alert("Se modificaron los datos correctamente."); document.getElementById('divDatosConversion').innerHTML='';}else{alert("Existe un problema, no se modificaron los datos.");}
   },
   error: Error
   });
}
function convertirMaquinaOS(n,tipo,cadena){alert("entra a 2 OS "+n);
	$.ajax({ 
   url: 'php/datosMaqConversion.php',
   type: 'POST',
   async: true,
   data: 'datox='+tipo+'&nx='+n+'&cadenax='+cadena+'&usuarioIDx='+usuarioID,
   dataType: "text",
   success: function Respuesta(result){alert(result); document.getElementById('divDatosConversion').innerHTML=result; /*if(result==''){alert("Se modificaron los datos correctamente."); document.getElementById('divDatosConversion').innerHTML='';}else{alert("Existe un problema, no se modificaron los datos.");}*/
   },
   error: Error
   });
}

function ocultaDivs($titulo, $mostrar){
	console.log("ocultaDivs:" + $titulo + ", mostrar " + $mostrar);
	$('.contDiv').hide();
	console.log("div ocultos")
	$('#' + $mostrar).show();
	$('#dir').html($titulo);	 
}
/////////////////////////////////////////fin conversion de maquinas
/*function CodigoBarras(){
	  $.ajax({
	  url: '../STOCK/codBarra.php',
	  type: 'POST',
	  async: true,
	  data: '',
	  dataType: "text",
	  success: function Respuesta(result){document.getElementById('GenCB').innerHTML = result;
	 // buscaInv("","TODAS","")
	 ;},
	  error: Error
  });
	document.getElementById('GenCB').style.display="block";
	document.getElementById('filtraInvCod').style.display="block";
	document.getElementById('reporteMaquinasDiv').style.display='none';
		document.getElementById('cContrasenaDiv').style.display='none';
		document.getElementById('maqIncompletasDiv').style.display='none';
		document.getElementById('solPedidosDiv').style.display='none';
		document.getElementById('reporteDeMaquinasDiv').style.display='none';
		document.getElementById('entradasProDiv').style.display='none';
		document.getElementById('inventarioProDiv').style.display='none';
		document.getElementById('ordenServicioDiv').style.display='none';
		document.getElementById('divReporteOS').style.display='none';
		document.getElementById('pedidoNuevoDiv').style.display='none';
		document.getElementById('inventarioDiv').style.display="none";
		document.getElementById('divMaquinasBodegas').style.display="none";
		document.getElementById("reportePedidosATdiv").style.display='none';
		document.getElementById('devolucionesMdiv').style.display='none';
		document.getElementById('crearCB').style.display='none';
		document.getElementById('ReporteDevolucionesdiv').style.display="none";
		document.getElementById('divReporteContratos').style.display='none';
		document.getElementById('divMaquinasPlacas').style.display="none";
		document.getElementById('divReportedePlacas').style.display="none";
		document.getElementById('dir').innerHTML='PRODUCCION > Generar Codigo QR';
}
function buscaInv(cod,fam,nom){//alert("busva inv"+' - '+ cod+' - '+ fam+' - '+ nom);
 $.ajax({
  url: '../STOCK/filtraInventarioCod.php',
  type: 'POST',
  async: true,
  data: 'codigox='+cod+'&familiax='+fam+'&nombrex='+nom+'',
  dataType: "text",
  success: function Respuesta(result){//alert(result);
document.getElementById('filtraInvCod').innerHTML = result;

//document.getElementById('CBFolioRet').style.display="block";
document.getElementById('filtraInvCod').style.display="block";
document.getElementById('buscaFRet').style.display="none";
document.getElementById('filtraInvCodEnt').style.display="none";
document.getElementById('filtraInvCodGranel').style.display="none";

},
  error: Error
});
}
function abreImpresionQR(codigo,lote,noimp,contador,subcentro,serieOpcional){	//alert(codigo+'-'+lote+'-'+noimp+'-'+contador);
var url="Impresion.php";
//if (lote == ''){alert("Ingrese el numero de Lote");}
//else{
	if (noimp == ''){alert("Ingrese el numero de Impresiones");}
	else{			
		//window.open("ImpresionQR.php?codigox="+codigo+'&lotex='+lote+'&noimpx='+noimp,"REPORTE","width=700,height=550,top=50,left=50,scrollbars=YES,status=YES,resizable=YES")
		window.open("../ImpresionEtiquetas/php/imprimeQRComponente.php?codigox="+codigo+'&noimpx='+noimp+'&subcentrox='+subcentro+'&serieOpcionalx='+serieOpcional,"REPORTE","width=700,height=550,top=50,left=50,scrollbars=YES,status=YES,resizable=YES")
		}
		
		
		//document.getElementById('lote'+contador).value=result;
		//alert("imprimio")
	//}
	//buscaInv("","TODAS","");
}*/