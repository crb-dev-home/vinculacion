<?php
function validarLongitud($valor)
{
	//NO cumple longitud minima
	if(strlen($valor) != 8)
		return false;
	// SI longitud, SI números 0-9
	else
		return true;	
}

function validaRequerido($valor)
{
	if(trim($valor) == '')
	{
       return false;
    }
	else
	{
       return true;
	}
}

function validaNumerico($valor)
{
	//SI longitud pero NO solo números
	if(!preg_match("/^[0-9]+$/", $valor))
		return false;
	// SI longitud, SI números 0-9
	else
		return true;	
}
?>