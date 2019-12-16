<?php

	function BuscarEnTabla($Operador, $OperandoDestino, $OperandoFuente, $NombreArchivoCodigo)
	{
	//TIPOS
		//Como en PHP no existen los registros, ya que se usan bases de datos o clases en lugar de ello, se usaran variables y RegTabla pasará a ser una cadena que se alacenará en un archivo de texto en lugar de uno estructurado.

		$RegTabla;
		//RegTabla = REGISTRO
			$Etiqueta;
			$Operador;
			$Operandos;
		//FIN REGISTRO

	//VARIABLES
		$ArchivoTabla;
		$OperadorArchivo;
		$OperandoDestinoArchivo;
		$OperandoFuenteArchivo;
		$InstruccionTabla;
		$InstruccionEncontrada;
		$AuxOperandos;
		$AuxEtiqueta;
		$RutaArchivoTabla;

	//INICIO
		$Etiqueta= 0;
		$Operador= "";
		$Operandos= "";
		$AuxOperador= "";
		$AuxOperandos= "";
		$InstruccionEncontrada= false;
		$AuxEtiqueta= 0;
		$RutaArchivoTabla= "";

		echo "Entro a BuscarEnTabla<br/>";
		$Operandos= $OperandoDestino . ',' . $OperandoFuente;
		
		$RutaArchivoTabla= "Tabla de simbolos " . $NombreArchivoCodigo;
		$ArchivoTabla= fopen($RutaArchivoTabla, "x");

		while (!feof($ArchivoTabla))
		{
			$InstruccionTabla= fgets($ArchivoTabla);
			while ($Etiqueta != null )
			{
				if ($Operador == $AuxOperador && $Operandos == $AuxOperandos)
				{
					$InstruccionEncontrada = true;
				}//FIN SI
			}//FIN MIENTRAS
			$Etiqueta = $Etiqueta + 1;
		}//FIN MIENTRAS

		if ($InstruccionEncontrada == false)
		{
			$Etiqueta= $AuxEtiqueta;
			$Operador= $AuxOperador;
			$Operandos= $AuxOperandos;
			fwrite($ArchivoTabla, $InstruccionTabla);
		}//FIN SI

		fclose($ArchivoTabla);
	}//FIN MODULO BuscarEnTabla*/

	function GenerarTablaSimbolos()
	{
	//TIPOS

	//VARIABLES
		$ArchivoCodigo;
		$RutaArchivo;
		$LineaCodigo;
		$Contador;
		$Etiqueta;
		$Operador;
		$OperandoDestino;
		$OperandoFuente;
		$EspacioEncontrado;
		$ComaEncontrada;
		$ExisteInstruccion;

	//INICIO
		LineaCodigo: "";
		$Contador= 0;
		$Etiqueta= 0;
		$Operador= "";
		$OperandoDestino= "";
		$OperandoFuente= "";
		$RutaArchivo= "";
		$EspacioEncontrado= false;
		$ComaEncontrada= false;
		$ExisteInstruccion= false;

		if (isset($_GET['NombreDelArchivo'])) 
		{
			$RutaArchivo= $_GET['NombreDelArchivo'];
			$ArchivoCodigo = fopen($RutaArchivo, "r");

			while (!feof($ArchivoCodigo))
			{
				$LineaCodigo= fgets($ArchivoCodigo);
				for ($i=0; $i<strlen($LineaCodigo); $i++)
				{
					//echo "i: " . $i . "<br/>";
					//echo "LineaCodigo: " . $LineaCodigo . "<br>";
					//echo "LineaCodigo[$i]: " . $LineaCodigo[$i] . "<br/>";
					if ($LineaCodigo[$i] != ' ' && $EspacioEncontrado != true)
					{
						$Operador= $Operador . $LineaCodigo[$i];
					}
					else
					{
						if ($LineaCodigo[$i] == ' ')
						{
							$EspacioEncontrado= true;
						}
						else
						{
							if ($LineaCodigo[$i] != ' ')
							{
								$EspacioEncontrado= false;
							}//FIN SI
						}//FIN SI
					}//FIN SI

					if ($LineaCodigo != ',' && $EspacioEncontrado == true && $ComaEncontrada != true)
					{
						$OperandoDestino= $OperandoDestino . $LineaCodigo[$i];
					}
					else
					{
						if ($LineaCodigo[$i] == ',')
						{
							$ComaEncontrada= true;
						}//FIN SI
					}//FIN SI

					if ($EspacioEncontrado == true && $ComaEncontrada == true)
					{
						$OperandoFuente= $OperandoFuente . $LineaCodigo[$i];
					}//FIN SI
				}//FIN PARA
				
				//echo "$Operador $OperandoDestino $OperandoFuente<br/>";
				//$ExisteInstruccion = BuscarEnTabla($Operador, $OperandoDestino, $OperandoFuente, $RutaArchivo);
					
				if ($ExisteInstruccion == false)
				{
					//AgregarEnTabla($Operador, $OperandoDestino, $OperandoFuente);
				}//FIN SI
			}//FIN MIENTRAS
			fclose($ArchivoCodigo);
		}//FIN SI
	}//FIN MODULO GenerarTablaSimbolos
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/Estilos.css">
	<title>Generar tabla de simbolos</title>
</head>
<body>
	<div class="testbox">
		<form action="" method="get">
			<h1>---GENERAR TABLA DE SIMBOLOS---<br><h1/>
			<h7>El archivo debe de estar guardado.<br></h7>
			<h7>Nombre del archivo: </h7>
			<input type="text" name="NombreDelArchivo" placeholder="Ejemplo: Hola.asm" required/> <!-- usar if isset()-->
			<input type="submit" value="Generar">
			<?php GenerarTablaSimbolos() ?>
		</form>
	</div>
</body>
</html>