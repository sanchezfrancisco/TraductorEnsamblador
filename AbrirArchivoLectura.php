<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="AbrirArchivo.css">
	<link rel="stylesheet" type="text/css" href="FormEditor.css">
	<link rel="stylesheet" type="text/css" href="index.css">
	<title><?php $_GET['NombreArchivo']?></title>
</head>
<body>
<form action="index.html">
	<!-- Barra de arriba -->
	<nav id= "Barra">
		<h1>Codigo de sólo lectura</h1>
	</nav>
		<?php
			$ruta_archivo = $_GET['NombreArchivo']; /* se extrae el nombre del archivo ingresado en el cuadro de texto del formulario html.*/
			$contenido = "";
			$archivo = fopen($ruta_archivo, "r") or die("Se produjo un error al crear el archivo"); // Abre el archivo para lectura.

			$contenido = fread($archivo, filesize($ruta_archivo));
		?>
	<textarea name="Codigo" rows="32" cols="190" wrap="hard" readonly="readonly"> <?php echo $contenido ?></textarea>" 	
	<input type="submit" value="Salir">
</form>
</body>
</html>
