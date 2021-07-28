<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$serie=$_POST["seriex"];
$ubi=$_POST["ubix"];
$ped=$_POST["pedx"];  if($ped=='' || $ped==' '){$ped='%';}
$fac=$_POST["facx"];  if($fac=='' || $fac==' '){$fac='%';}
$color='#E8F3FF';
$local='';
$consulta="select m.serie,prefijo,sufijo,serieCompleta sc,m.modelo,mueble,fabricante,lugarUbi,s.OfficeID
,u.bodega,u.rack,u.nivel,u.fila,u.columna,coordenadas,'#'+licencia licencia,Posicion,
j.modelo modJuego,j.acronimo juego,version,IP,film,cpuPlaca,s.cliente,s.nombre sala,x = SUBSTRING(U.bodega, 8,10),m.estatus estMaq
from cmaquinas m left join csala s on (s.salaid=m.salaidfk)
left join cjuego j on (j.juegoid=m.juegoidfk)
left join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)";
if($serie!=''){
$bus = mssql_query("".$consulta." where serieCompleta='".$serie."' ");
$lub = mssql_query("".$consulta." where serieCompleta='".$serie."' ");
$reg = mssql_fetch_array($lub);
$ubi= $reg["lugarUbi"];

}else{

if($ubi=='%'){//$sala=$_POST["salax"];
$bus=mssql_query("".$consulta." ");
}
if($ubi=='Sala'){$sala=$_POST["salax"]; $region=$_POST["regionx"];
$bus=mssql_query("".$consulta." where lugarUbi='Sala' and regionidfk like '".$region."' and salaidfk like '".$sala."' ");}

if($ubi=='Transito'){//$sala=$_POST["salax"];
$bus=mssql_query("select m.serie,prefijo,sufijo,serieCompleta sc,modelo,mueble,fabricante,lugarUbi,s.OfficeID
,film,cpuPlaca,s.cliente,s.nombre sala,s2.nombre sala2,m.estatusidfk,m.estatus estMaq from cmaquinas m left join csala s on (s.salaid=m.salaidfk)
left join csala s2 on (s2.salaid=m.salaidfkObodegaidfk) where (m.lugarUbi='bodega' or m.lugarUbi='sala') and (m.estatusidfk=96 or m.estatusidfk=94) 
order by salaidfk");}

if($ubi=='Bodega'){$bodega=$_POST["bodegax"];
	$rack=$_POST["rackx"];  if($rack==''){$rack='%';}
$nivel=$_POST["nivelx"];  if($nivel==''){$nivel='%';}
	$bus=mssql_query("select m.serie,prefijo,sufijo,serieCompleta sc,modelo,mueble,fabricante,lugarUbi
,u.bodega,u.rack,u.nivel,u.fila,u.columna,film,local = SUBSTRING(U.bodega, 8,10),m.estatus estMaq
from cmaquinas m left join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)
where lugarUbi='Bodega' and u.bodega like '".$bodega."' and u.rack like'".$rack."' and u.nivel like'".$nivel."' ");}

if($ubi=='A DESTRUIR'){//$bodega=$_POST["bodegax"];
	$bus=mssql_query("select *,estatus estMaq from cmaquinas where lugarUbi='".$ubi."' ");}
	
if($ubi=='varias'){//$bodega=$_POST["bodegax"];
	$bus=mssql_query("select *,estatus estMaq from cmaquinas where lugarUbi='Espana' or lugarUbi='Las vegas' or lugarUbi='robadas'");}

if($serie!='' && $serie!=' '){$maqx=mssql_query("select *,estatus estMaq from cmaquinas where serie='".$serie."' "); $maq = mssql_fetch_array($maqx);
if($maq["lugarUbi"]=='Sala'){echo"entra";$bus=mssql_query("select m.*,s.nombre,m.estatus estMaq ubi from cmaquinas m inner join csala s on (s.salaid=m.salaidfk) where m.serie='".$serie."'");}
if($maq["lugarUbi"]=='Bodega'){echo"entra2";$bus=mssql_query("select *,u.bodega+' R:'+u.rack+' N:'+u.nivel+' FC:'+u.fila+'-'+columna ubi,m.estatus estMaq from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)
where where m.serie='".$serie."'");}
}}
//if($ubi=='%' || $ubi=='Sala' || $serie!=''){
if($ubi=='%' || $ubi=='Sala'){
echo "<table ><tr style='background:#FFF;'>";
				  echo "<th align='center'>SERIE
                       <th align='center'>PREFIJO
                       <th align='center'>SUFIJO
                       <th align='center'>SERIE COMPLETA
                       <th align='center'>MODELO
                       <th align='center'>MUEBLE
                       <th align='center'>FABRICANTE
					   <th align='center'>ESTATUS
                       <th align='center'>ALMACEN
                       <th align='center'>LOCAL
                       
                       <th align='center'>COORDENADAS
                       <th align='center'>LICENCIA
                       <th align='center'>POSICION
                       <th align='center'>MODELO JUEGO
                       <th align='center'>JUEGO
                       <th align='center'>VERSION
                       <th align='center'>IP
					   <th align='center'>FILM
					   <th align='center'>CPU PLACA
					   <th align='center'>CLIENTE
					   <th align='center'>SALA</tr>";
						   
				  while($row = mssql_fetch_array($bus)){$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["x"];}else{$local=$row["OfficeID"];$row["rack"]='';}
					echo"<tr style='font-size:11px; background:".$color.";'>";
				    echo "<td style='text-align:center;'>" . $row["serie"] . "</td>
						  <td style='text-align:center;'>" . $row["prefijo"] . "</td>
					      <td style='text-align:center;'>" . $row["sufijo"] . "</td>
						  <td style='text-align:center;'>" . $row["sc"] . "</td>
						  <td style='text-align:center;'>" . $row["modelo"] . "</td>
						  <td style='text-align:center;'>" . $row["mueble"] . "</td>
						  <td style='text-align:center;'>" . $row["fabricante"] . "</td>
						  <td style='text-align:center;'>" . $row["estMaq"] . "</td>
						  <td>".$row["lugarUbi"]."</td>
                               <td>".$local."</td>
                               
                               <td>".$row["coordenadas"]."</td>
                               <td>".$row["licencia"]."</td>
                               <td>".$row["Posicion"]."</td>
                               <td>".$row["modJuego"]."</td>
                               <td>".$row["juego"]."</td>
                               <td>".$row["version"]."</td>
                               <td>".$row["ip"]."</td>
							   <td>".$row["film"]."</td>
							   <td>".$row["cpuPlaca"]."</td>
							   <td>".$row["cliente"]."</td>
							   <td>".$row["sala"]."</td>";
						  						  
				  echo"</tr>"; $ub=''; $nomOri='';
				  if($color=='#FFF'){$color='#E8F3FF';}else{$color='#FFF';}
				  }
}//fin if ubi== % o sala
if($ubi=='Transito' || $ubi=='Bodega' || $ubi=='varias' || $ubi=='A DESTRUIR'){
echo "<table ><tr style='background:#FFF;'>";
				  echo "<th align='center'>SERIE
                       <th align='center'>PREFIJO
                       <th align='center'>SUFIJO
                       <th align='center'>SERIE COMPLETA
                       <th align='center'>MODELO
                       <th align='center'>MUEBLE
                       <th align='center'>FABRICANTE
					    <th align='center'>ESTATUS
                       <th align='center'>ALMACEN
                       <th align='center'>LOCAL
					   <th align='center'>RACK
					   <th align='center'>NIVEL
					   <th align='center'>FILA
					   <th align='center'>COLUMNA
					   <th align='center'>FILM
					   <th align='center'>CLIENTE
					   <th align='center'>SALA</tr>";

				  while($row = mssql_fetch_array($bus)){$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["bodega"];}else{$local=$row["OfficeID"];$row["rack"]='';}
if($row["estatusidfk"]==94){$ub='BODEGA A '.$row["sala"];}if($row["estatusidfk"]==96){$ub='A BODEGA'; $nomOri=$row["sala2"];}
					echo"<tr style='font-size:11px; background:".$color.";'>";
				    echo "<td style='text-align:center;'>" . $row["serie"] . "</td>
						  <td style='text-align:center;'>" . $row["prefijo"] . "</td>
					      <td style='text-align:center;'>" . $row["sufijo"] . "</td>
						  <td style='text-align:center;'>" . $row["sc"] . "</td>
						  <td style='text-align:center;'>" . $row["modelo"] . "</td>
						  <td style='text-align:center;'>" . $row["mueble"] . "</td>
						  <td style='text-align:center;'>" . $row["fabricante"] . "</td>
						  <td style='text-align:center;'>" . $row["estMaq"] . "</td>";
						  if($ubi=='Transito'){echo"<td>TRANSITO - ".$nomOri." ".$ub."</td>";}
						  if($ubi=='Bodega'){echo"<td>Bodega</td>";}
						  if($ubi=='varias' || $ubi=='A DESTRUIR'){echo"<td>".$row["lugarUbi"]."</td>";}
						       echo"<td>".$local."</td>
							   <td>".$row["rack"]."</td>
							   <td>".$row["nivel"]."</td>
							   <td>".$row["fila"]."</td>
							   <td>".$row["columna"]."</td>
							   <td>".$row["film"]."</td>
							   <td>".$row["cliente"]."</td>
							   <td>".$row["sala"]."</td>";
						  						  
				  echo"</tr>"; $ub=''; $nomOri='';
				  if($color=='#FFF'){$color='#E8F3FF';}else{$color='#FFF';}
				  }
}//fin if ubi== % o sala
	  echo "</table>|@|"; if($ubi=='Sala'){echo"Total en Salas:".$salas."";} if($ubi=='Bodega'){echo"Total en Bodegas:".$salas."";} 
				  if($ubi=='%'){echo"Total de Maquinas: ".$salas." ";} if($ubi=='Transito'){echo"Total en Transito: ".$salas." ";} 
$sd->desconectar();
?>