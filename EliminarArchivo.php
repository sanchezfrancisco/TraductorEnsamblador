<?php
	if (isset($_GET['NombreArchivo'])) 
	{
		ob_start();
		$ruta_archivo = $_GET['NombreArchivo']; /* se extrae el nombre del archivo ingresado en el cuadro de texto del formulario html.*/
		$ruta_archivo = $ruta_archivo . ".asm";  /*se concatena la extension .asm al nombre del archivo*/
		
		unlink($ruta_archivo); //se elimina el archivo.
		header('Location: index.html');
	}// FIN SI
?>