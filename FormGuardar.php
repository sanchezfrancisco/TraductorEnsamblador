<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/Estilos.css">
	<title>Escritura</title>
</head>
<body>
	<div class="testbox">
		<form action="FormGuardar.php" method="get">
			<h1>Guardar como...</h1>
			<input type="text" name="NombreArchivo" placeholder="Ejemplo: Hola (sin el .asm)" required/>
			<input type="submit" name="Guardar">
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
		</form>
	</div>
</body>
</html>