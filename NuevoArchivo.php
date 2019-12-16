<?php
	ob_start(); // permite la funcion header.
	$ruta_archivo = $_GET['NombreArchivo']; /* se extrae el nombre del archivo ingresado en el cuadro de texto del formulario html.*/
	$ruta_archivo = $ruta_archivo . ".asm";  /*se concatena la extension .asm al nombre del archivo*/

	$archivo = fopen($ruta_archivo, "w+") or die("Se produjo un error al crear el archivo"); // Abre el archivo para lectura/escritura. Si no existe intenta crearlo.
	fclose($archivo); //cierra el archivo.
	Header("Location: FormEditor.html"); //Regresa a la pagina principal.
?>