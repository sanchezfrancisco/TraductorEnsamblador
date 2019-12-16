<?php
	//VARIABLES
	/*
		$registros16[16];
		$Valores16[8];
		$registros8 [8];
		$Valores8[8];
		$Segmento[4];
		$ValoresSe[4];
		$Acumuladores [3];
		$ValoresAcu[3];
	*/
	//INICIO

		$registros16= array("AX", "CX", "DX", "BX", "SP", "BP", "SI", "DI");
		$Valores16= array("000","001","010","011","100","101","110","111");
		$registros8= array("AL","CL","DL","BL","AH","CH","DH","BH");
		$Valores8= array("000","001","010","011","100","101","110","111");
		$Segmento= array("ES","CS","SS","DS");
		$ValoresSeg= array("000","001","010","011");
		$Acumulador= array("AX","AH","AL");
		$ValoresAcu= array("000","100","000");
		$NumerosHex= array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
		$NumerosHex2Bin= array("0000", "0001", "0010", "0011", "0100", "0101", "0110", "0111", "1000", "1001", "1010", "1011", "1100", "1101", "1110", "1111"); 
	//MÓDULOS 
	function BuscarRegistro16($registro)
	{
	//VARIABLES
		global $registros16, $Valores16;
		$ContadorReg;
		$ContadorVal;
	//INICIO
		$ContadorReg= 0;
		$ContadorVal= 0;

		for ($i=0; $i<8; $i++)
		{
			if ($registro == $registros16[$ContadorReg])
			{    
			    $registro= $Valores16[$ContadorVal];
			}
			
			$ContadorReg= $ContadorReg+1;
			$ContadorVal= $ContadorVal+1;
		}//FIN MIENTRAS

		return ($registro);
	}//FIN BuscarRegistros16
		
	function BuscarRegistro8($registro) 
	{
	//VARIABLES
		global $registros8, $Valores8;
		$ContadorReg;
		$ContadorVal;

	//INICIO
		$ContadorReg= 0;
		$ContadorVal= 0;

		for ($i=0; $i<8 ; $i++) 
		{
			if ($registro= $registros8[$ContadorReg])
			{
		    	$registro= $Valores8[$ContadorVal];
			}
		    else
		    {
		    	$ContadorReg1= $ContadorReg1+1;
			    $ContadorVal1= $ContadorVal1+1;
			}
		}//Fin (mientras)

		return ($registro);             
	}//FIN BuscarRegistro8

// Este módulo puede regresar uno de dos valores enteros. Regresa 1 si recibió por parámetro un registro de 16 bits, 0 en caso de que el registro recibido sea de 8 bits y -1 si se trata de un registro inválido.

	function CalcularBitsRegistro($Registro)
	{
	//VARIABLES
		$BitsRegistro;
	//INICIO
		$BitsRegistro= 0;

		if ($Registro == "AX" || $Registro == "BX" || $Registro == "CX" || $Registro == "DX" || $Registro == "SP" || $Registro == "BP" || $Registro == "SI" || $Registro == "DI")
		{
			$BitsRegistro= 1;
		}
		else
		{
			if ($Registro == "AL" || $Registro == "BL" || $Registro == "CL" || $Registro == "DL" || $Registro == "AH" || $Registro == "BH" || $Registro == "CH" || $Registro == "DH")
			{
				$BitsRegistro= 0;
			}
			else
			{
				$BitsRegistro= -1;
			}//FIN SI
		}//FIN SI
		
		return($BitsRegistro);
	}//FIN MÓDULO CalcularBitsRegistro

//Este modulo permite generar aleatoriamente una direccion de memoria ficticia en hexadecimal, la cual tendra una longitud de 8 digitos y la devolvera en una cadena de caracteres.

	function GenerarDirMemoria()
	{
	//VARIABLES
		global $NumerosHex;
		$DirMemoria;
		$NumAleatorio;

	//INICIO
		$DirMemoria= "";
		$NumAleatorio= 0;

		for ($i=0; $i<8; $i++) 
		{ 
			$NumAleatorio= rand(0, 15);
			$DirMemoria= $DirMemoria . $NumerosHex[$NumAleatorio];
		}//FIN PARA

		return ($DirMemoria);
	}//FIN MODULO GenerarDirMemoria

	function ConvertirHex2Bin($Hexadecimal)//INT 4C00H
	{
	//VARIABLES
		global $NumerosHex;
		global $NumerosHex2Bin;
		$Contador;
		$Binario;
		$NumerosHex2Bin;
		$ContadorBytes;
		$ArregloBytes= array();

	//INICIO
		$Contador= strlen($Hexadecimal)-1;
		$Binario= "";
		$ContadorBytes= 0;
		$ArregloBytes[0]= "";
		$ByteLleno= false;
		
		if ($Hexadecimal[$Contador] == 'H')
		{
			$Contador= $Contador - 1; // si el numero tiene la H se le quita.
		}//FIN SI

		do
		{
			for ($i=0; $i<16; $i++)
			{
				if ($Hexadecimal[$Contador] == $NumerosHex[$i])
				{
					$Binario= $Binario . $NumerosHex2Bin[$i];
					$ArregloBytes[$ContadorBytes]= $NumerosHex2Bin[$i];

					if (strlen($Binario) == 8)
					{
						$ArregloBytes[$ContadorBytes-1]= $ArregloBytes[$ContadorBytes] . $ArregloBytes[$ContadorBytes-1];
						$ArregloBytes[$ContadorBytes]= "";
					}

					$ContadorBytes= $ContadorBytes + 1;
				}//FIN SI
			}//FIN PARA
			
			$Contador= $Contador - 1;
		}while($Contador >= 0);

		return ($ArregloBytes); // regresa el arreglo sin reacomodar.
	}//FIN MODULO ConvertirHex2Bin

	function InvertirBytes($ArregloBytes)
	{
	//VARIABLES
		$RegBinario;
		$Contador;
	//INICIO
		$Contador= 0;
		$RegBinario= "";

		while ($ArregloBytes[$Contador+1] != null) 
		{
			$RegBinario= $RegBinario . $ArregloBytes[$Contador+1] . $ArregloBytes[$Contador];
		}

		$RegBinario= $RegBinario . $ArregloBytes[$Contador];
		return ($RegBinario);
	}//FIN MODULO InvertirBytes

	function MOVmemreg($mem,$reg) 
	{
	//Constantes
		define('MOV', "100010");
		define('d', "0");
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorMov;
		$ValorReg;
		$ValorMem= array();
		$ArregloBytes= array();
        $w;
        $BitsReg;

	//Inicio
		$w= 0;
		$BitsReg= 0;
		$ValorMov= 0;
		$ValorReg= "";
		$ValorMem[0]= "";
		$ArregloBytes[0]= "";

		$BitsReg= CalcularBitsRegistro($reg);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($reg);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($reg);
			$w= 0;
		}

		if ($BitsReg == -1)
		{
			echo "Error: el registro destino no es correcto" . "<br/>";
		}//FIN SI

		$ValorMov= MOV . d . $w . mod;
		$mem= GenerarDirMemoria();
		$ArregloBytes= ConvertirHex2Bin($mem);
		$ValorMem[]= InvertirBytes($ArregloBytes);
		$mem= $ValorMem[1];
		$ValorMov= $ValorMov . $mem . $ValorReg . rm;

		return ($ValorMov);
	}//FIN MOVmemreg
	

	function MOVregmem ($reg,$mem)// DE DONDE SACO LA DIRECCION DE LA MEMORIA EN HEXADECIMAL?, SE SUPONE QUE ES UNA VARIABLE NO?
	{
	//Constantes
		define ('MOV', "100010");
		define('d', "1");
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorMov;
		$ValorReg;
	    $w;
	    $BitsReg;
	    $ValorMem= array();
	    $ArregloBytes= array();
	    $Ccontador;

	//Inicio
		$w= 0;
		$ValorMov= 0;
		$BitsReg= "";
		$ValorMem[0]= "";
		$ArregloBytes[0]= "";
		$Contador= 0;

		$BitsReg= CalcularBitsRegistro($reg);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($reg);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($reg);
			$w= 0;
		}//FIN SI

		if ($BitsReg == -1)
		{
			echo "Error: el registro no es correcto." . "<br/>";
		}//FIN SI

		$ValorMov= $ValorMov . MOV . d . $w . mod . $ValorReg;
		$mem= GenerarDirMemoria($mem);
		$ArregloBytes= ConvertirHex2Bin($mem);
		$ValorMem[]= InvertirBytes($ArregloBytes);
		$ValorMov= $ValorMov . " " . $ValorMem[1] . rm;
		
		return ($ValorMov);
	}//Fin modulo MOVregmem 

	function MOVreginmoinmreg ($reg,$inm)
	{
	//Constantes
		define('MOV', "1011");

	//Variables
		$ValorMov;
		$ValorReg;
	    $w;
	    $BitsReg;
	    $ArregloBytes= array();
	    $ValorInm= array();

	//Inicio
		$BitsReg= 0;
		$w= 0;
		$ValorMov= 0;

		$BitsReg= CalcularBitsRegistro($reg);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($reg);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($reg);
			$w= 0;
		}//FIN SI

		if ($BitsReg == -1)
		{
			echo "Error: el registro no es correcto." . "<br/>";
		}//FIN SI

		$inm= base_convert($inm, 16, 2);
		//$ArregloBytes= ConvertirHex2Bin($inm);
		//$ValorInm[]= InvertirBytes($ArregloBytes);
		$ValorMov= $ValorMov . MOV . $w . $ValorReg . $inm;

		return($ValorMov); 
	}//FIN MODULO MOVreginmoinmreg

	function MOVmeminmoinmmem($mem,$inm)
	{
	//Constantes
		define('MOV', "1100011");	
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorMov;
		$ValorReg;
		$w;

	//Inicio
		$w= 0;
		$ValorMov= 0;
		$ValorReg= "";
		$BitsReg= 0;

		/*$BitsReg= CalcularBitsRegistro($reg);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($reg);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($reg);
			$w= 0;
		}//FIN SI

		if ($BitsReg == -1)
		{
			echo "Error: el registro no es correcto." . "<br/>";
		}//FIN SI*/

		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		$ValorMov= MOV . $w  . mod /*. $ValorReg*/ . rm . $mem;
		
		return ($ValorMov);
	}//FIN MODULO MOVmeminmoinmmem

	function MOVmemacu($acu,$mem)
	{
	//Constantes
		define('MOV', "101000");
		define('d', "0");

	//Variables
		$ValorMov;
		$ValorReg;
		$BitsReg;
	    $w;
	
	//Inicio
		$w= 0;
		$ValorMov= "";
		$ValorReg= "";
		$BitsReg= 0;

		$BitsReg= CalcularBitsRegistro($acu);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($acu);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($acu);
			$w= 0;
		}//FIN SI

		if ($BitsReg == -1)
		{
			echo "Error: el registro no es correcto." . "<br/>";
		}//FIN SI

		$mem= GenerarDirMemoria();
		//$mem= ConvertirHexadecimalBinario($mem);
		$mem= base_convert($mem, 16, 2);

		$ValorMov= MOV  . d . $w . $mem;
		
		return ($ValorMov); 
	}//FIN MODULO MOVmemacu

	function MOVacumem($mem,$acu)
	{
	//Constantes
		define('MOV', "101000");
		define('d', "1");

	//Variables
		$ValorMov;
		$ValorReg;
		$BitsReg;
	    $w;
	
	//Inicio
		$w= 0;
		$ValorMov= "";
		$ValorReg= "";
		$BitsReg= 0;

		$BitsReg= CalcularBitsRegistro($acu);

		if ($BitsReg == 1) 
		{
			$ValorReg= BuscarRegistro16($acu);
			$w= 1;
		}//FIN SI

		if ($BitsReg == 0)
		{
			$ValorReg= BuscarRegistro8($acu);
			$w= 0;
		}//FIN SI

		if ($BitsReg == -1)
		{
			echo "Error: el registro no es correcto." . "<br/>";
		}//FIN SI 
		
		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		//$mem= ConvertirHex2Bin();
		$ValorMov= MOV . d . $w . $mem;

		return ($ValorMov);
	}//FIN MODULO MOVacumem

	//aquí ya tienen que llegar convertidos los de reg y seg 
	function MOVregseg($reg,$seg)
	{
	//Constantes
		define('MOV', "100011");
		define('d', "0");
		define('mod', "00");

	//Variables
		$ValorMov;
	//Inicio
		$ValorMov= 0;

		$ValorMov= MOV . d . "0" . mod . $seg . $reg;
		return ($ValorMov); 
	}//FIN MODULO MOVregseg

	function MOVsegreg ($seg,$reg)
	{
	//Constantes
		define('MOV', "100011");
		define('d', "0");
		define('mod', "00");

	//Variables
		$ValorMov;
	
	//Inicio
		$ValorMov= "";

		$ValorMov= MOV . d . "0" . mod . $seg . $reg;

		return ($ValorMov);
	}//FIN MODULO MOVsegreg

	function MOVsegmem($seg,$mem)
	{
	//Constantes
		define('MOV', "100011");
		define('d', "0");
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorMov;
	//Inicio
		$ValorMov= "";
		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		$ValorMov= MOV . d . "0" . mod . $seg . rm . $mem;

		return ($ValorMov); 
	}//FIN MODULO MOVsegmem

	function MOVmemseg($mem,$seg)
	{
	//Constantes
		define('MOV', "100011");
		define('d', "1");
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorMov;
	//Inicio
		$ValorMov= "";
		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		$ValorMov= MOV . d . "0" . mod . $seg . rm . $mem;
	
		return ($ValorMov); 
	}// FIN MODULO MOVmemseg

	function LEAregmem($reg,$mem)
	{
	//Constantes
		define('LEA', "10001101");
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorLea;

	//Inicio
		$ValorLea= "";
		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		$ValorLea= LEA . mod . $reg . rm;
		
		return ($ValorLea);
	}//FIN MODULO LEAregmem

	function Loop($Valor)
	{
	//Constantes
		define('LOOP', "11100010");

	//Variables
		$ValorLoop;

	//Inicio
		$ValorLoop= "";
		
		$VAlor= GenerarDirMemoria();
		$Valor= base_convert($Valor, 16, 2);
		$ValorLoop= LOOP . $Valor;
		
		return ($ValorLoop);
	}//FIN MODULO Loop

	function Pushreg($Reg)
	{
	//Constantes
		define('PUSH', "01010");

	//Variables
		ValorPush;
	
	//Inicio
		$ValorPush= "";
		
		$ValorPush= PUSH . $Reg;
		
		return ($ValorPush);
	}//FIN MODULO Pushreg

	function Pushmem($Reg,$mem)
	{
	//Constantes
		define('PUSH', "11111111"); 
		define('mod', "00");
		define('rm', "110");

	//Variables
		$ValorPush;
	
	//Inicio
		$ValorPush= "";

		$mem= GenerarDirMemoria();
		$mem= base_convert($mem, 16, 2);
		$ValorPush= PUSH . $Reg . $mem;
		
		return ($ValorPush);
	}//FIN MODULO Pushmem

	function Int($Valor)
	{
	//Constantes
		define('Int', "11001101");

	//Variables
		$ValorInt;
		$ValorIntBinario;

	//Inicio
		$ValorIntBinario= "";
		$ValorInt= "";
		$ValorIntBinario[0]= "";

		$ValorIntBinario= ConvertirHex2Bin($Valor);
		$ValorInt= Int . " " . $ValorIntBinario[0];

		return ($ValorInt);
	}//Fin 
	
	function MOVregreg($RegDestino, $RegFuente)
	{
	//CONSTANTES
	 	define('MOV', "10010");
		define('d', "1");
		define('mod', "11");

	//VARIABLES
		$ValorInstruccion;
		$w;
		$ValorRegDestino;
		$ValorRegFuente;
		$BitsRegDestino;
		$BitsRegFuente;
		$Validar;
		$RegDestino;
		$RegFuente;
	
	//INICIO
		$ValorRegDestino= "";
		$ValorInstruccion= "";
		$BitsRegDestino= 0;
		$BitsRegFuente= 0;
		$w= 0;

		$ValorInstruccion= MOV . d;
		$BitsRegDestino= CalcularBitsRegistro($RegDestino);

		if ($BitsRegDestino == -1) 
		{
			echo "Error: el registro destino no es correcto" . "<br/>";
		}//FIN SI

		$BitsRegFuente= CalcularBitsRegistro($RegFuente);

		if ($BitsRegFuente == -1) 
		{
			echo "Error: el registro fuente no es correcto" . "<br/>";
		}//FIN SI

		if ($BitsRegDestino == 1 && $BitsRegFuente == 1) 
		{
			$ValorRegDestino= BuscarRegistro16($RegDestino);
			$ValorRegFuente= BuscarRegistro16($RegFuente);
			$w= 1;
		}
		else
		{
			if ($BitsRegDestino == 0 && $BitsRegFuente == 0) 
			{
				$ValorRegDestino= BuscarRegistro8($RegDestino);
				$ValorRegFuente= BuscarRegistro8($RegFuente);
				$w= 0;
			}
			else
			{
				$w= -1;
				echo "Error de sintaxis: los Registros son diferentes" . "<br/>";
			}//FIN SI
		}//FIN SI

		if ($w == 1 || $w == 0) 
		{
		 	$ValorInstruccion= $ValorInstruccion . $w;
		}//FIN SI

		$ValorInstruccion= $ValorInstruccion . mod . $ValorRegDestino . $ValorRegFuente;

		return($ValorInstruccion);
	}//FIN MOVregreg

	function PRINCIPAL()
	{
	//VARIABLES
		$Instruccion;
		$ValorInstruccion;
		$RegDestino;
		$RegFuente;

	//Inicio
		$Instruccion= "";
		$ValorInstruccion= "";
		$RegDestino= "";
		$RegFuente= "";

		if (isset($_POST['ok'])) 
		{
			$Instruccion= $_POST['instruccion'];
			echo "Instruccion: " . $Instruccion . "<br/>";
			$RegDestino= $Instruccion[4] . $Instruccion[5] . $Instruccion[6];
			$RegFuente= $Instruccion[8] . $Instruccion[9];
			echo "Acumulador: " . $RegFuente . "<br/>";
			echo "Memoria: " . $RegDestino . "<br/>";
		
			$ValorInstruccion= MOVacumem($RegDestino, $RegFuente);
			/*switch (intval($Valores)) 
			{
			 	case 1:
			 		$ValorInstruccion= MOVregreg($Instruccion);
			 		//break;
			 	case 2:
			 		//MOVregmem();
			 		break;
			 	case 3:
			 		break;
			 	case 4:
			 		break;
			 	default:
			 		echo "Ingrese el un caso.";
			 		break;
			 }//Fin caso*/
			echo "Valor binario de la instruccion: " . $ValorInstruccion . "<br/>";
		}//FIN SI
	}//FIN PRINCIPAL

	//PROGRAMA PRINCIPAL
	//INICIO
		PRINCIPAL();
	//FIN
?>