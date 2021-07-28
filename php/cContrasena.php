<?php 
include("../../Conexion/conectaBase.php");

$sd = new conexion();
$sd->conectar();


$usuario = $_POST['usuarioIDx'];
$contrasena = $_POST['actualx'];

$ncontrasena = $_POST['nuevacx'];
$confcontrasena = $_POST['confnx'];
$confContrasena = base64_encode ( $confcontrasena ); 

	
   
      $sql = "SELECT * FROM cusuario WHERE usuarioid LIKE '$usuario'";
	  $rs=mssql_query($sql);
	  
	  while ($registro=mssql_fetch_array($rs)){
      		 $pass1=$registro['contrasena'];
	   		 $pass = base64_decode ( $pass1 ); 

	  if($contrasena==$pass && $ncontrasena==$confcontrasena){
	   		mssql_query("update cusuario set contrasena='$confContrasena' where usuarioid='$usuario'");
	   echo "1"; 
         }else{
			echo "0"; 
          }
	}



    
$sd->desconectar();
?> 
