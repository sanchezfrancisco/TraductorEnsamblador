<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
</head>
<body>
	<form method="post" action="Traductor.php">
		<label>Registro: </label>
		<input type="text" name="Registro">
		<input type="submit" name="ok">
<?php 
// Este módulo puede regresar uno de dos valores enteros. Regresa 1 si recibió por parámetro un registro de 16 bits, 0 en caso de que el registro recibido sea de 8 bits y -1 si se trata de un registro inválido.

	function CalcularBitsRegistro($Registro)
	{
	//VARIABLES
		$BitsRegistro;
	//INICIO
		$BitsRegistro= 0;
		echo "<label>Entro al modulo</label>";

		if ($Registro = "AX" || $Registro = "BX" || $Registro = "CX" || $Registro = "DX" || $Registro = "SP" || $Registro = "BP" || $Registro = "SI" || $Registro = "DI")
		{
			echo "<label>Entro al de 16 bits</label>";
			$BitsRegistro= 1;
		}
		else
		{
			if ($Registro = "AL" || $Registro = "BL" || $Registro = "CL" || $Registro = "DL" || $Registro = "AH" || $Registro = "BH" || $Registro = "CH" || $Registro = "DH")
			{
				echo "<label>Entro al if de 8 bits</label>";
				$BitsRegistro= 0;
			}
			else
			{
				echo "<label>Entro al if de cualquier otro caso</label>";
				$BitsRegistro= -1;
			}//FIN SI
		}//FIN SI
		
		echo "<label>Va a salir del modulo</label>";
		return($BitsRegistro);
	}//FIN MÓDULO CalcularBitsRegistro

	//PROGRAMA PRINCIPAL
	//VARIABLES
		$RegistroIngresado;
		$w;
	//INICIO
		$w= 0;
		$RegistroIngresado= 0;

		$w= CalcularBitsRegistro($RegistroIngresado);
		echo "<label>$w</label>";
	//FIN
?>
	</form>
</body>
</html>