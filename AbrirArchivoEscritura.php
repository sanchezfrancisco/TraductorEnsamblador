<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/Estilos.css">
	<title>Escritura</title>
</head>
<body>
	<form action="FormGuardar.php" method="get">
		<div id="header">
			<ul class="nav">
				<li><a href="index.php">Menu</a>
					<ul>
						<li><a href="">Nuevo archivo</a></li>
						<li><a href="FormGuardar.php">Guardar</a></li>
						<li><a href="GenerarTablaSimbolos.php">Generar tabla de símbolos</a></li>
						<li><a href="index.html">Salir</a></li>
					</ul>
				</li>
			</ul>
		</div>
	<!-- Barra de arriba -->
		<nav id= "Barra">
			<h1>Editor de código</h1>
		</nav>
		<br/><br/><br/>
	<?php
		$ruta_archivo = $_GET['NombreArchivo']; /* se extrae el nombre del archivo ingresado en el cuadro de texto del formulario html.*/
		$contenido = "";
		$archivo = fopen($ruta_archivo, "r") or die("Se produjo un error al crear el archivo"); // Abre el archivo para lectura.

		$contenido = fread($archivo, filesize($ruta_archivo));
	?>
	<!-- Cuadro de texto -->
	<textarea name="Codigo" rows="32" cols="190" wrap="hard"> <?php echo $contenido ?></textarea>
	<input type="submit" value="Guardar">
	</form>
</body>
</html>
