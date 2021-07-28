<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$n=$_POST["nx"];

if($n==1){$conv=0; $prefijo=''; $mueble='';
	$serie=$_POST["licenciax"];
	$datosx=mssql_query("select maquinaid,serieCompleta,licencia,modelo,mueble from cmaquinas where serieCompleta='".$serie."' ");
	$numDato=mssql_num_rows($datosx);
	if($numDato==1){
	$dato=mssql_fetch_array($datosx);
	if($dato["mueble"]!="BLACKWAVE" && $dato["mueble"]!="Blackwave"){echo"NoBlackwave"; return -1;}
	$tabla="Datos de la maquina:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
	$tabla=$tabla."<tr><td style='border: 1px solid black;' id='tdSC'>".$dato["serieCompleta"]."</td><td id='tdLI' style='border: 1px solid black;'>".$dato["licencia"]."</td>
	<td id='tdMO' style='border: 1px solid black;'>".$dato["modelo"]."</td><td id='tdMU' style='border: 1px solid black;'>".$dato["mueble"]."</td></tr>";
	$tabla=$tabla."</table>";
	
	echo $tabla."<br><br>Tipo de conversion: <select id='selectConversion' onchange='tablaConversion(this.value,\"".$dato["serieCompleta"].";".$dato["licencia"].";".$dato["modelo"].";".$dato["mueble"]."\");'>";
	if($dato["mueble"]=='Blackwave' || $dato["mueble"]=='BLACKWAVE'){echo"<option value='22a23'>de 22 a 23</option><option value='aslot'>a slot</option>"; $conv=1; $prefijo='35/'; $mueble='BLACKWAVE23';}
	if($dato["mueble"]=='Blackwave23' || $dato["mueble"]=='BLACKWAVE23'){echo"<option value='aslot'>a slot</option>"; $conv=2; $prefijo='41/';}
	echo"</select>
	&nbsp;&nbsp;&nbsp;<input style='font-size:12px; margin-top:3px' type='button' value='Convertir'
	onClick='convertirMaquina(3,selectConversion.value,\"".$dato["serieCompleta"].";".$dato["licencia"].";".$dato["modelo"].";".$dato["mueble"].";".$dato["maquinaid"]."\");' >";
	$por = explode("/", $dato["licencia"]); if($por[1]==''){$por[1]=$por[0];}
	if($mueble==''){$mueble=$dato["mueble"];}
	$tabla2="<br><br>Datos con cambios realizados:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
	$tabla2=$tabla2."<tr><td style='border: 1px solid black;'>".$dato["serieCompleta"]."</td><td style='border: 1px solid black;'>".$prefijo."".$por[1]."</td>
	<td style='border: 1px solid black;'>".$dato["modelo"]."</td><td style='border: 1px solid black;'>".$mueble."</td></tr>";
	$tabla2=$tabla2."</table>";
	echo "<div id='divTablaConversion'>$tabla2</div>";
	}
	else{
		$osx=mssql_query("select * from torden_Servicio where ordenid=".$serie." ");
		$numOS=mssql_num_rows($osx);
		if($numOS==1){
			//echo "Entra";
			$maqOSx=mssql_query("select m.serieCompleta,m.licencia,m.modelo,m.mueble from solicitudMaquinasOS s inner join cmaquinas m on (m.maquinaid=s.maquinaidfk) where s.ordenidfk=".$serie." ");
			
			$tabla="Datos de la maquina:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
			while($dato=mssql_fetch_array($maqOSx)){
	$tabla=$tabla."<tr><td style='border: 1px solid black;' id='tdSC'>".$dato["serieCompleta"]."</td><td id='tdLI' style='border: 1px solid black;'>".$dato["licencia"]."</td>
	<td id='tdMO' style='border: 1px solid black;'>".$dato["modelo"]."</td><td id='tdMU' style='border: 1px solid black;'>".$dato["mueble"]."</td></tr>";
			}
	$tabla=$tabla."</table>";
	echo $tabla."<br><br>Tipo de conversion: <select id='selectConversion' onchange='tablaConversionOS(this.value,".$serie.");'>";
	echo"<option value='0'>Elige tipo de conversion</option><option value='22a23'>de 22 a 23</option><option value='aslot'>a slot</option>";
	echo"</select>
	&nbsp;&nbsp;&nbsp;<input style='font-size:12px; margin-top:3px' type='button' value='Convertir'
	onClick='convertirMaquinaOS(5,selectConversion.value,".$serie.");' >";
	echo "<div id='divTablaConversion'>$tabla2</div>";
			}
		else{echo"datoNoValido";}
		}
	
	}
if($n==2){
	$conversion=$_POST["datox"];
	$cadena=$_POST["cadenax"];
	$cad = explode(";", $cadena);
	$mueble=$cad[3];
	$serie=$cad[0];
	$modelo=$cad[2];
	$por = explode("/", $serie); if($por[1]==''){$por[1]=$por[0];}
	$prefijo='';
	if($conversion=='aslot'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='40/';}
	if($mueble=='Blackwave23' || $mueble=='BLACKWAVE23'){$conv=2; $prefijo='41/';}
	}
	if($conversion=='22a23'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='35/'; $mueble='BLACKWAVE23';}
	//if($dato["mueble"]=='Blackwave23' || $dato["mueble"]=='BLACKWAVE23'){$conv=2; $prefijo='41/';}
	}
	
	$tabla2="<br><br>Datos con cambios realizados:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
	$tabla2=$tabla2."<tr><td style='border: 1px solid black;'>".$serie."</td><td style='border: 1px solid black;'>".$prefijo."".$por[1]."</td>
	<td style='border: 1px solid black;'>".$modelo."</td><td style='border: 1px solid black;'>".$mueble."</td></tr>";
	$tabla2=$tabla2."</table>";
	echo $tabla2;
	}
if($n==3){
	$conversion=$_POST["datox"];
	$cadena=$_POST["cadenax"];
	$usuarioID=$_POST["usuarioIDx"];
	$cad = explode(";", $cadena);
	$mueble=$cad[3];
	$serie=$cad[0];
	$modelo=$cad[2];
	$maquinaid=$cad[4];
	$licencia=$cad[1];
	$licenciaMod='';
	$muebleMod=$mueble;
	$bandera=0;
	$por = explode("/", $serie); if($por[1]==''){$por[1]=$por[0];}
	if($conversion=='aslot'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='40/';}
	if($mueble=='Blackwave23' || $mueble=='BLACKWAVE23'){$conv=2; $prefijo='41/';}
	}
	if($conversion=='22a23'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='35/'; $muebleMod='BLACKWAVE23'; $bandera=1;}
	}
	$licenciaMod=$prefijo.$por[1];
	$update=mssql_query("update cmaquinas set licencia='".$licenciaMod."',mueble='".$muebleMod."' where maquinaid=".$maquinaid." ");
	//echo "update cmaquinas set licencia='".$licenciaMod."',mueble='".$muebleMod."' where maquinaid=".$maquinaid." <br>";
	$his=mssql_query("insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'licencia','".$licencia."','".$licenciaMod."',NULL,NULL)");
	//echo"insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),1,'licencia','".$licencia."','".$licenciaMod."',NULL,NULL)<br>";
	if($bandera==1){
		//echo "insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),1,'mueble','".$mueble."','".$muebleMod."',NULL,NULL)<br>";
	$his2=mssql_query("insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'mueble','".$mueble."','".$muebleMod."',NULL,NULL)");
	}
}
if($n==4){
	$os=$_POST["osx"];
	$conversion=$_POST["datox"];
	
	$maqOSx=mssql_query("select m.serieCompleta,m.licencia,m.modelo,m.mueble from solicitudMaquinasOS s inner join cmaquinas m on (m.maquinaid=s.maquinaidfk) where s.ordenidfk=".$os." ");
	$tabla2="<br><br>Datos con cambios realizados:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
	while($dato=mssql_fetch_array($maqOSx)){
		$mueble=$dato["mueble"];
	$por = explode("/", $dato["serieCompleta"]);
	$prefijo='';
	
	if($conversion=='22a23'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$prefijo='35/'; $mueble='BLACKWAVE23';
	
	$tabla2=$tabla2."<tr><td style='border: 1px solid black;'>".$dato["serieCompleta"]."</td><td style='border: 1px solid black;'>".$prefijo."".$por[1]."</td>
	<td style='border: 1px solid black;'>".$dato["modelo"]."</td><td style='border: 1px solid black;'>".$mueble."</td></tr>";
	}
	}
	if($conversion=='aslot'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='40/';}
	if($mueble=='Blackwave23' || $mueble=='BLACKWAVE23'){$conv=2; $prefijo='41/';}
	$tabla2=$tabla2."<tr><td style='border: 1px solid black;'>".$dato["serieCompleta"]."</td><td style='border: 1px solid black;'>".$prefijo."".$por[1]."</td>
	<td style='border: 1px solid black;'>".$dato["modelo"]."</td><td style='border: 1px solid black;'>".$mueble."</td></tr>";
	}
	
	}//fin array
	$tabla2=$tabla2."</table>";
	echo "<div id='divTablaConversion'>$tabla2</div>";
	}
	
if($n==5){
	$os=$_POST["cadenax"];
	$conversion=$_POST["datox"];
	$usuarioID=$_POST["usuarioIDx"];
	echo "OS: ".$os." --  conversion".$conversion; 
	$maqOSx=mssql_query("select m.maquinaid,m.serieCompleta,m.licencia,m.modelo,m.mueble from solicitudMaquinasOS s inner join cmaquinas m on (m.maquinaid=s.maquinaidfk) where s.ordenidfk=".$os." ");
	$tabla2="<br><br>Datos con cambios realizados:<br><table ><tr><th style='border: 1px solid black;'>Serie Completa</th><th style='border: 1px solid black;'>Licencia</th><th style='border: 1px solid black;'>Modelo</th><th style='border: 1px solid black;'>Mueble</th></tr>";
	while($dato=mssql_fetch_array($maqOSx)){
		$mueble=$dato["mueble"];
		$muebleMod=$mueble;
		$maquinaid=$dato["maquinaid"];
		$licencia=$dato["licencia"];
	
	$bandera=0;
	$por = explode("/", $dato["licencia"]); if($por[1]==''){$por[1]=$por[0];}
	if($conversion=='aslot'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='40/';}
	if($mueble=='Blackwave23' || $mueble=='BLACKWAVE23'){$conv=2; $prefijo='41/';}
	}
	if($conversion=='22a23'){
	if($mueble=='Blackwave' || $mueble=='BLACKWAVE'){$conv=1; $prefijo='35/'; $muebleMod='BLACKWAVE23'; $bandera=1;}
	}
	$licenciaMod=$prefijo.$por[1];
	//$update=mssql_query("update cmaquinas set licencia='".$licenciaMod."',mueble='".$muebleMod."' where maquinaid=".$maquinaid." ");
	echo "update cmaquinas set licencia='".$licenciaMod."',mueble='".$muebleMod."' where maquinaid=".$maquinaid." <br>";
	//$his=mssql_query("insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'licencia','".$licencia."','".$licenciaMod."',NULL,NULL)");
	echo"insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'licencia','".$licencia."','".$licenciaMod."',NULL,NULL)<br>";
	if($bandera==1){
	echo "insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'mueble','".$mueble."','".$muebleMod."',NULL,NULL)<br>";
	//$his2=mssql_query("insert into cambiosMaquinas values(".$maquinaid.",GETDATE(),".$usuarioID.",'mueble','".$mueble."','".$muebleMod."',NULL,NULL)");
	}
	
	}//fin array
}
$sd->desconectar();
?>