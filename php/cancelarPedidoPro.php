<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();  

$pedido=$_POST["pedidox"];
$n=$_POST["nx"];
$valor=$_POST["valorx"];
$obs=$_POST["obsx"];
$usuario=$_POST["usuarioIDx"];
$serie=$_POST["seriex"];
$cont=0;
//echo".$pedido. - .$n. - .$valor. - .$obs."; return -1;
if($n=='1'){$estatusx=mssql_query("select t.estatusidfk,e.nombre estatus from tsolicitud_refaccion t
inner join cestatus e on (e.estatusid=t.estatusidfk) where solicitud_refaccionid=".$pedido." ");
$estatus = mssql_fetch_array($estatusx);//10942
if($estatus["estatusidfk"]==30){
	$update=mssql_query("update tsolicitud_refaccion set estatusidfk=31,fecha_cancelacion=GETDATE(),observaciones='".$obs."',usuarioCancelaidfk=".$usuario." where solicitud_refaccionid= ".$pedido." ");echo'0';
	$updateDos=mssql_query("update dsolicitud_refaccion set estatusidfk=31 where solicitud_refaccionidfk=".$pedido."");
	}
	else{echo"1||".$estatus["estatus"];}
	
}

if($n=='2'){$estatusx=mssql_query("select * from tsolicitud_refaccion where solicitud_refaccionid=".$pedido." ");
$estatus = mssql_fetch_array($estatusx);
$fecIniciox=mssql_query("select *,CONVERT (char(10), fecha, 103)+' '+CONVERT(VARCHAR(8), fecha, 108) fecha2 from registros_impresion where solicitud_refaccionid=".$pedido." ");
$canFecInicio = mssql_num_rows($fecIniciox);
$fecInicio = mssql_fetch_array($fecIniciox);


//$insert2=mssql_query("insert into registros_impresion values(2,'2','".$fecInicio["fecha2"]."')");

if($estatus["estatusidfk"]==30 || $estatus["estatusidfk"]==103){
$separar = explode('||',$valor);
for ($i=0; $i<=$separar[$i].length; $i++){
		if($separar[$i]!=''){ $separar2 = explode(',',$separar[$i]);
		$update=mssql_query("update dsolicitud_refaccion set estatusidfk=31 where solicitud_refaccionidfk=".$pedido." and refaccionidfk=".$separar2[0]." and serie='".$separar2[1]."'");
		}
}
}
$update=mssql_query("update tsolicitud_refaccion set estatusidfk=31,fecha_cancelacion=GETDATE(),observaciones='".$obs."',usuarioCancelaidfk=".$usuario." where solicitud_refaccionid= ".$pedido." ");
echo"0";
$datosx=mssql_query("select * from tsolicitud_refaccion where solicitud_refaccionid=".$pedido." ");
$dato = mssql_fetch_array($datosx);
if($estatus["estatusidfk"]==30){
	$piPenx=mssql_query("select refaccionidfk,cantidad,serie,29 estatus,descripcion,50 from dsolicitud_refaccion where solicitud_refaccionidfk=".$pedido." and estatusidfk!=31");
	$PiPen = mssql_num_rows($piPenx);
	if($PiPen>0){
mssql_query("insert into tsolicitud_refaccion(folio_solicitudidfk,estatusidfk,fecha_creacion,observaciones,usuarioidfk,tecnicoidfk,fechaStock,impresion,departamentoidfk,pedidoRelacionado,paqueteria,numero_guia)
values('".$dato["folio_solicitudidfk"]."',30,GETDATE(),'".$dato["descripcion"]."',".$dato["usuarioidfk"].",".$dato["tecnicoidfk"].",GETDATE(),'0',".$dato["departamentoidfk"].",".$pedido.",'','')");
$pedNuevox=mssql_query("select top(1)* from tsolicitud_refaccion where folio_solicitudidfk='".$dato["folio_solicitudidfk"]."' order by fecha_creacion desc,solicitud_refaccionid desc");
$pedNuevo = mssql_fetch_array($pedNuevox);
mssql_query("insert into dsolicitud_refaccion(solicitud_refaccionidfk,refaccionidfk,cantidad,serie,estatusidfk,descripcion,juegoidfk)
select ".$pedNuevo["solicitud_refaccionid"]." solicitud, refaccionidfk,cantidad,serie,29 estatus,descripcion,50
from dsolicitud_refaccion
where solicitud_refaccionidfk=".$pedido." and estatusidfk!=31");
	}
  }//fin estatusidfk=30
if($estatus["estatusidfk"]==103){ $update=mssql_query("update tsolicitud_refaccion set estatusidfk=42,usuarioCancelaidfk=".$usuario." where solicitud_refaccionid= ".$pedido." ");
  $estatusx=mssql_query("select * from dsolicitud_refaccion where solicitud_refaccionidfk=".$pedido." and isnull(enviado,'0')='0' and estatusidfk!=31 ");
  $PiePen = mssql_num_rows($estatusx);
  if($PiePen>0){mssql_query("insert into tsolicitud_refaccion(folio_solicitudidfk,estatusidfk,fecha_creacion,observaciones,usuarioidfk,tecnicoidfk,fechaStock,impresion,departamentoidfk,pedidoRelacionado,paqueteria,numero_guia)
values('".$dato["folio_solicitudidfk"]."',30,GETDATE(),'".$dato["descripcion"]."',".$dato["usuarioidfk"].",".$dato["tecnicoidfk"].",GETDATE(),'0',".$dato["departamentoidfk"].",".$pedido.",'','')");
$pedNuevox=mssql_query("select top(1)* from tsolicitud_refaccion where folio_solicitudidfk='".$dato["folio_solicitudidfk"]."' order by fecha_creacion desc,solicitud_refaccionid desc");
$pedNuevo = mssql_fetch_array($pedNuevox);
mssql_query("insert into dsolicitud_refaccion(solicitud_refaccionidfk,refaccionidfk,cantidad,serie,estatusidfk,descripcion,juegoidfk)
select ".$pedNuevo["solicitud_refaccionid"]." solicitud, refaccionidfk,cantidad,serie,29 estatus,descripcion,50
from dsolicitud_refaccion
where solicitud_refaccionidfk=".$pedido." and estatusidfk!=31 and isnull(enviado,'0')='0'");
}
  //else{
	  mssql_query("insert into tsolicitud_refaccion(folio_solicitudidfk,estatusidfk,fecha_creacion,observaciones,usuarioidfk,tecnicoidfk,fechaStock,impresion,departamentoidfk,pedidoRelacionado,paqueteria,numero_guia,fecha_cancelacion,usuarioCancelaidfk)
values('".$dato["folio_solicitudidfk"]."',31,GETDATE(),'".$obs."',".$dato["usuarioidfk"].",".$dato["tecnicoidfk"].",GETDATE(),'0',".$dato["departamentoidfk"].",".$pedido.",'','',GETDATE(),".$usuario.")");
$pedNuevox=mssql_query("select top(1)* from tsolicitud_refaccion where folio_solicitudidfk='".$dato["folio_solicitudidfk"]."' order by fecha_creacion desc,solicitud_refaccionid desc");
$pedNuevo = mssql_fetch_array($pedNuevox);
mssql_query("insert into dsolicitud_refaccion(solicitud_refaccionidfk,refaccionidfk,cantidad,serie,estatusidfk,descripcion,juegoidfk)
select ".$pedNuevo["solicitud_refaccionid"]." solicitud, refaccionidfk,cantidad,serie,31 estatus,descripcion,50
from dsolicitud_refaccion
where solicitud_refaccionidfk=".$pedido." and estatusidfk=31");
if($canFecInicio>0){
$insert2=mssql_query("insert into registros_impresion values(".$pedNuevo["solicitud_refaccionid"].",'".$dato["folio_solicitudidfk"]."','".$fecInicio["fecha2"]."')");
}
  //   }//fin else PirPen==0
  }//fin estatusidfk=103
}
if($n==2){$dsolicitudRefx=mssql_query("select * from dsolicitud_refaccion where solicitud_refaccionidfk = ".$pedido."");
$dsolicitudRef=mssql_fetch_array($dsolicitudRefx);
//if($dsolicitudRef["estatusidfk"]==30 || $dsolicitudRef["estatusidfk"]==103 || $dsolicitudRef["estatusidfk"]==31){
	$updateDos=mssql_query("update dsolicitud_refaccion set estatusidfk=31 where solicitud_refaccionidfk=".$pedido." and estatusidfk in (29,43)");
	//}
//echo"correo";
}
$sd->desconectar();
?>