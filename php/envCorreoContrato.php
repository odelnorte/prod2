<?php
include("../../Conexion/conectaBase.php");
include("class.phpmailer.php");
include("class.smtp.php");
$sd =new conexion();
$sd->conectar();
$cadena=$_POST["listaMsgx"];
$contrato=$_POST["contratoidx"];
$valor=$_POST["nx"];
$ordenid=$_POST["ordenidx"];

$separar = explode(',,',$cadena);
//echo".$cadena.-.$contrato."; 
//echo".$dato[0].-.$dato[1].-.$contrato."; return -1;
//Envia correo
$usuario="statusfolios@operacionesdelnorte.com";
$passw="S1sc0Mail";
$usuario2="zitro.callcenter@operacionesdelnorte.com";
$passw2="zitromexico";
$nom1="Sistema Sisco";

$varname = $_FILES['archivo']['hola.txt'];
$vartemp = $_FILES['archivo']['hola'];
$mail = new PHPMailer();// Crea objeto

/*Configura servidor SMTP (Gmail)*/
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "ssl://smtp.gmail.com";
$mail->Port = 465;
$mail->Username = $usuario;
$mail->Password = $passw;

/*Remitente*/
$mail->From = $usuario;
$mail->FromName = $nom1;



//echo".$folio. - .$sala.";}
//AddAddress  AddBCC
//$mail->AddAddress("genesis.rodriguez@operacionesdelnorte.com");
$mail->AddAddress("luis.gomez@odelnorte.com");


/*Destinatario*/
if($valor==1){$mail->Subject = "Se agregan maquinas al contrato ".$contrato."";}
if($valor==2){$mail->Subject = "Se agregan maquinas al OS ".$ordenid."";}
$cuerpo="Series: <br><p></p>";
for ($i=0; $i<=$separar[$i].length; $i++){
	$dato = explode("--", $separar[$i]);
$serieComx=mssql_query("select * from cmaquinas where maquinaid = ".$dato[0]."");
$serieCom=mssql_fetch_array($serieComx);

$cuerpo=$cuerpo." 
".$serieCom["serieCompleta"].", ";
}


$mail->Body = $cuerpo;
$mail->IsHTML(true);
if(!$mail->Send()) {
	/*Adjunta archivo*/
$mail2 = new PHPMailer();// Crea objeto

/*Configura servidor SMTP (Gmail)*/
$mail2->IsSMTP();
$mail2->SMTPAuth = true;
$mail2->SMTPSecure = "ssl";
$mail2->Host = "ssl://smtp.gmail.com";
$mail2->Port = 465;
$mail2->Username = $usuario2;
$mail2->Password = $passw2;

/*Remitente*/
$mail2->From = $usuario2;
$mail2->FromName = $nom1;
if($valor==1){$mail2->Subject = "Se agregan maquinas al contrato ".$contrato."";}
if($valor==2){$mail2->Subject = "Se agregan maquinas al OS ".$ordenid."";}
//$mail2->AddBCC("jorgeg@operacionesdelnorte.com");
//$mail2->AddAddress("genesis.rodriguez@operacionesdelnorte.com");
$mail2->AddAddress("luis.gomez@odelnorte.com");

$mail2->Body = $cuerpo;
$mail2->IsHTML(true);// le indica que el cuerpo del mensaje es HTML
    if(!$mail2->Send()) {echo"EL mensaje no ha sido enviado, rectifique los campos o informe del Error: " . $mail2->ErrorInfo."<br>";}
	else{echo "Correo enviado <br>";}
} 
else {echo "Correo enviado <br>";}

$sd->desconectar();
?>