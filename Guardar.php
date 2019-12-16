<?php
	if (isset($_GET['NombreArchivo'])) 
	{
		ob_start();
		$ruta_archivo = $_GET['NombreArchivo'] . ".asm";
		$archivo = fopen($ruta_archivo, "w");
		$Codigo= $_GET['Codigo'];
		fwrite($archivo, $Codigo);
		fclose($archivo);
		header('Location: index.html');
	}//FIN SI
?>