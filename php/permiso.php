<?php
//Inicio la sesión
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTICADO

if ($_SESSION["autenticado"] == "si") { }

else{ 
		//si el usuario no está autenticado redirigirlo a la página de inicio de sesión
		header("Location: ../index.html");
		//salimos de este script
		exit();
	}


?> 