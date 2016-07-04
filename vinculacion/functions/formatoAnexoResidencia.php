<?php
require('fpdf/rotation.php');
require_once '../connections/conexion.php';
require_once('fpdf/fpdi.php');

class PDF extends PDF_Rotate
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

}

	$num = $_GET['numSolicitud'];
	$strConsulta = "SELECT 
        `s`.`numRegistro` AS `numRegistro`,
        `s`.`tipoSolicitud` AS `tipoSolicitud`,
        `s`.`fechaSolicitud` AS `fechaSolicitud`,
        `s`.`fechaImpresion` AS `fechaImpresion`,
        `s`.`fechaEntregado` AS `fechaEntregado`,
        `s`.`status` AS `status`,
        UPPER(`s`.`idAlumno`) AS `idAlumno`,
        UPPER(`a`.`nomAlumno`) AS `nomAlumno`,
        UPPER(`a`.`apPaterno`) AS `apPaterno`,
        UPPER(`a`.`apMaterno`) AS `apMaterno`,
        UPPER(`a`.`domicilio`) AS `domicilio`,
        UPPER(`a`.`colonia`) AS `colonia`,
        UPPER(`a`.`ciudad`) AS `ciudad`,
        `a`.`codigo` AS `codigo`,
        UPPER(`a`.`curp`) AS `curp`,
        UPPER(`c`.`nomCarreraCorto`) AS `carrera`,
        UPPER(`a`.`email`) AS `emailAlumno`,
        `a`.`telefono` AS `telAlumno`,        
        UPPER(`d`.`nomDependencia`) AS `nomDependencia`,
        UPPER(`d`.`cortoDependencia`) AS `nombreCorto`,
        UPPER(`d`.`tipo`) AS `tipo`,
        UPPER(`d`.`sector`) AS `sector`,
        UPPER(`d`.`giro`) AS `giro`,
        UPPER(`d`.`RFC`) AS `rfc`,
        UPPER(`d`.`domicilio`) AS `domicilioDep`,
        UPPER(`d`.`colonia`) AS `coloniaDep`,
        `d`.`codigo` AS `codigoDep`,
        UPPER(`d`.`ciudad`) AS `ciudadDep`,
        UPPER(`s`.`responsableDependencia`) AS `responsableDependencia`,
        UPPER(`s`.`tituloResponsable`) AS `tituloResponsable`,
        UPPER(`s`.`puestoResponsable`) AS `puestoResponsable`,
        `s`.`telDependencia` AS `telDependencia`,
        `s`.`extension` AS `extension`,
        UPPER(`s`.`emailDependencia`) AS `emailDependencia`,
        UPPER(`s`.`programa`) AS `programa`,
        `s`.`fechaInicio` AS `fechaInicio`,
        `s`.`fechaTermino` AS `fechaTermino`,
        `s`.`horas` AS `horas`,
        UPPER(`s`.`usuario`) AS `usuario`,
        UPPER(`a`.`sexo`) AS `sexo`,
        `a`.`semestre` AS `semestre`,
        TIMESTAMPDIFF(YEAR, `a`.fechaNacimiento,CURRENT_DATE) as `edad`
        
    FROM
        (((`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON (`a`.`idAlumno` = `s`.`idAlumno`))
        JOIN `tbldependencias` `d` ON (`d`.`idDependencia` = `s`.`idDependencia`)
		JOIN `tblcarreras` `c` ON (`c`.`idCarrera` = `a`.`carrera`))) WHERE numRegistro = '$num'";
	$solicitud = mysqli_query($conexion,$strConsulta);
	$fila = mysqli_fetch_array($solicitud);
	
	$strAnexo = "SELECT * FROM tblanexo WHERE idSolicitud = '$num'";
	$anexo = mysqli_query($conexion,$strAnexo);
	$filaAnexo = mysqli_fetch_array($anexo);
	
	$sexoF = "";
	$sexoM = "";
	
	if ($fila['sexo'] == "F")
	{
		$sexoF = "X";
	}
	else
	{
		$sexoM = "X";
	}
	
	$giroInd = "";
	$giroSer = "";
	$giroOtro = "";
	
	if ($fila['giro'] == "Servicios")
	{
		$giroSer = "X";
	}
	else if ($fila['giro'] == "Industrial")
	{
		$giroInd = "X";
	}
	else 
	{
		$giroOtro = "X";
	}
	
	$sectorPriv = "";
	$sectorPubl = "";
	
	if ($fila['sector'] == "Publico")
	{
		$sectorPubl = "X";
	}
	else
	{
		$sectorPriv = "X";
	}
	
	$opcionBanco = "";
	$opcionPropio = "";
	$opcionTrabajador = "";
	if ($filaAnexo['opcionEle'] == "1")
	{
		$opcionBanco = "X";
	}
	else if ($filaAnexo['opcionEle'] == "2")
	{
		$opcionPropio = "X";
	}
	else
	{
		$opcionTrabajador = "X";
	}

	$acudirEmergenciasIMSS = "";
	$acudirEmergenciasISSTE ="";
	$acudirEmergenciasOTRO ="";

	if($filaAnexo['acudirEmergencias'] == "1"){
		$acudirEmergenciasIMSS = "X";
	}else if($filaAnexo['acudirEmergencias'] == "2"){
		$acudirEmergenciasISSTE	= "X";
	}else{
		$acudirEmergenciasOTRO = "X";
	}
	
	// initiate FPDI
	$pdf = new FPDI('P','mm','Letter');
	$pdf->Addfont('soberanasansregular','');
	$pdf->Addfont('soberanasanslight','');
	$pdf->Addfont('soberanasansi','');
	$pdf->Addfont('soberanasansbi','');
	$pdf->Addfont('soberanasansb','');
	// add a page
	$pdf->AddPage();
	// set the source file
	$pdf->setSourceFile("../templates/anexo.pdf");
	// import page 1
	$tplIdx = $pdf->importPage(1);
	// use the imported page and place it at point 10,10 with a width of 100 mm
	$pdf->useTemplate($tplIdx, 0, 0, 216);
	
	$pdf->SetMargins(20,20,20);
	
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$mesesAsunto = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$fechaInicio = strtotime($fila['fechaInicio']);
	$fechaTermino = strtotime($fila['fechaTermino']);
	$fechaImpresion = strtotime($fila['fechaImpresion']);
	$fechaEntrega = strtotime($filaAnexo['fechaReporte']);
	
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY(24, 55);
	$pdf->Cell(85,4,$fila['nomAlumno'].' '.$fila['apPaterno'].' '.$fila['apMaterno'],0,1,'C');	
	
	$pdf->SetXY(114, 55);
	$pdf->Cell(30,4,$fila['idAlumno'],0,1,'C');	
	
	$pdf->SetXY(155, 55);
	$pdf->Cell(30,4,$fila['carrera'],0,1,'L');	
	
	$pdf->SetXY(177, 55);
	$pdf->Cell(20,4,$fila['semestre'],0,1,'C');
	
	$pdf->SetXY(24, 63);
	$pdf->Cell(85,4,$fila['domicilio'],0,1,'C');
	
	$pdf->SetXY(114, 63);
	$pdf->Cell(85,4,$fila['colonia'],0,1,'C');
	
	$pdf->SetXY(24, 70);
	$pdf->Cell(20,4,$fila['codigo'],0,1,'C');
	
	$pdf->SetXY(48, 70);
	$pdf->Cell(35,4,$fila['ciudad'],0,1,'C');
	
	$pdf->SetXY(90, 70);
	$pdf->Cell(35,4,$fila['telAlumno'],0,1,'C');
	
	$pdf->SetXY(140, 70);
	$pdf->Cell(35,4,$fila['edad'],0,1,'C');
	
	$pdf->SetXY(30, 78);
	$pdf->Cell(110,4,$fila['emailAlumno'],0,1,'C');
	
	$pdf->SetXY(163, 78);
	$pdf->Cell(15,4,$sexoF,0,1,'C');
	
	$pdf->SetXY(183, 78);
	$pdf->Cell(15,4,$sexoM,0,1,'C');
	
	$pdf->SetXY(25, 96);
	$pdf->Cell(120,4,$fila['nomDependencia'],0,1,'C');
	
	$pdf->SetXY(149, 96);
	$pdf->Cell(50,4,$fila['nombreCorto'],0,1,'C');
	
	$pdf->SetXY(23, 104);
	$pdf->Cell(35,4,$fila['rfc'],0,1,'C');

	$pdf->SetXY(83.5, 100);
	$pdf->Cell(4,4,$giroInd,0,1,'C');

	$pdf->SetXY(100, 100);
	$pdf->Cell(4,4,$giroSer,0,1,'C');
	
	$pdf->SetXY(110, 100);
	$pdf->Cell(4,4,$giroOtro,0,1,'C');

	$pdf->SetXY(166, 100);
	$pdf->Cell(4,4,$sectorPubl,0,1,'C');

	$pdf->SetXY(180, 100);
	$pdf->Cell(4,4,$sectorPriv,0,1,'C');
	
	$pdf->SetXY(23, 111);
	$pdf->Cell(45,4,$fila['telDependencia'].' Ext.'.$fila['extension'],0,1,'C');
	
	$pdf->SetXY(72, 111);
	$pdf->Cell(87,4,$fila['domicilioDep'],0,1,'C');
	
	$pdf->SetXY(163, 111);
	$pdf->Cell(38,4,$fila['coloniaDep'],0,1,'C');

	$pdf->SetXY(23, 119);
	$pdf->Cell(57,4,$fila['ciudad'],0,1,'C');
	
	$pdf->SetXY(83, 119);
	$pdf->Cell(33,4,$fila['codigo'],0,1,'C');
	
	$pdf->SetXY(118, 119);
	$pdf->Cell(83,4,$filaAnexo['area'],0,1,'C');
	
	$pdf->SetXY(23, 128);
	$pdf->Cell(137,4,$fila['responsableDependencia'],0,1,'C');
	
	$pdf->SetXY(163, 128);
	$pdf->Cell(38,4,$fila['puestoResponsable'],0,1,'C');
	
	$pdf->SetXY(23, 135.5);
	$pdf->Cell(137,4,$filaAnexo['nomPersona'],0,1,'C');
	
	$pdf->SetXY(163, 135.5);
	$pdf->Cell(38,4,$filaAnexo['puestoPersona'],0,1,'C');
	
	$pdf->SetXY(35, 143);
	$pdf->Cell(155,4,$fila['emailDependencia'],0,1,'C');
	
	$pdf->SetXY(25, 150);
	$pdf->Cell(175,4,$filaAnexo['mision'],0,1,'C');

	$pdf->SetXY(25, 159);
	$pdf->Cell(105,4,strtoupper($filaAnexo['nomAsesorExt']),0,1,'C');

	$pdf->SetXY(116, 159);
	$pdf->Cell(105,4,strtoupper($filaAnexo['puestoAsesorExt']),0,1,'C');

	$pdf->SetXY(25, 178);
	$pdf->Cell(105,4,$filaAnexo['nomProyecto'],0,1,'C');

	$pdf->SetXY(136, 178);
	$pdf->Cell(65,4,$filaAnexo['periodo'],0,1,'C');
	
	$pdf->SetXY(136, 186);
	$pdf->Cell(65,4,$filaAnexo['numReside'],0,1,'C');
	
	$pdf->SetXY(58, 186);
	$pdf->Cell(4,4,$opcionBanco,0,1,'C');
	
	$pdf->SetXY(98, 186);
	$pdf->Cell(4,4,$opcionPropio,0,1,'C');
	
	$pdf->SetXY(125, 186);
	$pdf->Cell(4,4,$opcionTrabajador,0,1,'C');
	
	$pdf->SetXY(25, 195);
	$pdf->Cell(40,4,date('d',$fechaInicio).' de '.$meses[date('m',$fechaInicio)-1].' del '.date('Y',$fechaInicio),0,1,'C');
	
	$pdf->SetXY(85, 195);
	$pdf->Cell(50,4,date('d',$fechaTermino).' de '.$meses[date('m',$fechaTermino)-1].' del '.date('Y',$fechaTermino),0,1,'C');
	
	$pdf->SetXY(25, 208);
	$pdf->Cell(52,4,$filaAnexo['horario'],0,1,'C');
	
	$pdf->SetXY(80, 208);
	$pdf->Cell(52,4,$filaAnexo['dias'],0,1,'C');
	
	$pdf->SetXY(137, 208);
	$pdf->Cell(65,4,date('d',$fechaEntrega).' de '.$meses[date('m',$fechaEntrega)-1].' del '.date('Y',$fechaEntrega),0,1,'C');
	
	$pdf->SetXY(45, 217);
	$pdf->Cell(65,4,'$ '.$filaAnexo['apoyoEconomico'],0,1,'C');
	
	$pdf->SetXY(136, 217);
	$pdf->Cell(65,4,$filaAnexo['importeLetra'],0,1,'C');

	$pdf->SetXY(58, 222);
	$pdf->Cell(65,4,$acudirEmergenciasIMSS,0,1,'C');

	$pdf->SetXY(112.5, 221.5);
	$pdf->Cell(65,4,$acudirEmergenciasISSTE,0,1,'C');

	$pdf->SetXY(115, 226);
	$pdf->Cell(65,4,$acudirEmergenciasOTRO,0,1,'C');

	$firma = "../images/firmas/jefe-vinculacion.jpg";
	$pdf->SetXY(155, 234);
	$pdf->Cell( 0, 0, $pdf->Image($firma, $pdf->GetX(), $pdf->GetY(),15), 0, 0, 'L', false );


	$pdf->SetXY(85, 259);
	$pdf->Cell(15,0,date('d',$fechaImpresion),0,1,'C');
	
	$pdf->SetXY(117, 259);
	$pdf->Cell(25,0,$meses[date('m',$fechaImpresion)-1],0,1,'C');
	
	$pdf->SetXY(155, 259);
	$pdf->Cell(25,0,date('y',$fechaImpresion),0,1,'C');

	$pdf->Output('Carta '.$fila['idAlumno'].'.pdf','I');
?>