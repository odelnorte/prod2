// JavaScript Document
function cancelaPedidoOS(n,pedido,usuarioID){//alert(n+" "+pedido+" "+usuarioID);
var valor=''; var Obs=''; var txt=''
txt=document.getElementById('input'+pedido).value;
Obs=document.getElementById('texaObservaciones'+pedido).value;
if(n=='2'){valor=document.getElementById('input'+pedido).value;}
if(n=='2' && txt=='' || txt==' '){alert('No has cancelado ninguna clave'); return -1;}
if(Obs=='' || Obs==' '){alert("Ingrese Motivo por el cual se cancela el pedido"); return -1;}
  $.ajax({
  url: '../php/cancelarPedidoPro.php',
  type: 'POST',
  async: true,
  data: 'pedidox='+pedido+'&nx='+n+'&valorx='+valor+'&obsx='+Obs+'&usuarioIDx='+usuarioID,
  dataType: "text",
  success: function Respuesta(result){//alert(result);
  if(result=='0'){enviarCorreoPedCan(pedido);}
  var arr = result.split('||'); 
  if(arr[0]=='0'){ location.reload(true);}
  //if(arr[0]=='0'){enviarCorreoPedCan(pedido);}
  if(arr[0]=='1'){alert("No se puede Cancelar el pedido por que tiene estatus "+arr[1] );}
  //if(result=='0'){enviarCorreoPedCan(pedido);}
//  if(result==''){location.reload(true);}/*document.getElementById(campo).innerHTML = result;*/
},
  error: Error
  });
}
function oculta(id,ped,con){//alert(ped+" "+con);
document.getElementById(id).style.visibility='hidden';
document.getElementById("tr"+ped+"-"+con).style.color='RED';
//document.getElementById("tr"+ped+"-"+con).style.background='RED';
}
function colocaPiezasCan(ped,ref,serie){
	var valor=	document.getElementById('input'+ped).value;
	valor=valor+"||"+ref+','+serie;
	document.getElementById('input'+ped).value=valor;
}

/*function cancelarSolOS(ped,ref,serie){
  $.ajax({
  url: 'cancelarSolOS.php',
  type: 'POST',
  async: true,
  data: 'pedidox='+ped+'&refx='+ref+'&seriex='+serie,
  dataType: "text",
  success: function Respuesta(result){},
  error: Error
  });
}*/
function enviarCorreoPedCan(pedido){//alert(pedido);
		$.ajax({
		   url: '../php/enviaCorreoPedCan.php',
		   type: 'POST',
		   async: true,
		   data: 'pedidox='+pedido,
		   dataType: "text",
		   success: function Respuesta(result){alert(result);
			   if(result=='1'){}//alert("Correo enviado correctamente");}else{alert("Error al enviar correo");}
		  /* document.getElementById('span3').innerHTML='<input type="button" style="font-size:18px" value=" Enviar " onclick="enviaCorreo(texCorreo.value)" />'*/;},
		   error: Error
		   });
}