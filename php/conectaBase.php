<?php
class conexion{



public function conectar(){
$s = @mssql_connect("MXDF-SVRPRUEBAS", "sa", "Op3r@c10n3s") 
or die("Couldn't connect to SQL Server on $myServer"); 
 
$d = @mssql_select_db("consultasPrbs", $s) 
or die("Couldnt open database $myServer"); 
}
public function desconectar(){
@mssql_close("MXDF-SVRPRUEBAS", "sa", "Op3r@c10n3s");
}
}

?>