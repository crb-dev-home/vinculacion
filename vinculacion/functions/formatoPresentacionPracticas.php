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
        `s`.`idAlumno` AS `idAlumno`,
        `a`.`nomAlumno` AS `nomAlumno`,
        `a`.`apPaterno` AS `apPaterno`,
        `a`.`apMaterno` AS `apMaterno`,
        `a`.`domicilio` AS `domicilio`,
        `a`.`colonia` AS `colonia`,
        `a`.`codigo` AS `codigo`,
        `a`.`nss` AS `nss`,
        `a`.`curp` AS `curp`,
        `e`.`nomCarreraLargo` AS `carrera`,
        `a`.`email` AS `emailAlumno`,
        `a`.`telefono` AS `telAlumno`,
        `d`.`nomDependencia` AS `nomDependencia`,
        `d`.`tipo` AS `tipo`,
        `d`.`sector` AS `sector`,
        `s`.`responsableDependencia` AS `responsableDependencia`,
        `s`.`tituloResponsable` AS `tituloResponsable`,
        `s`.`puestoResponsable` AS `puestoResponsable`,
        UPPER(`s`.`conAtencionA`) AS `conAtencionA`,
        `s`.`telDependencia` AS `telDependencia`,
        `s`.`emailDependencia` AS `emailDependencia`,
        `s`.`programa` AS `programa`,
        `s`.`fechaInicio` AS `fechaInicio`,
        `s`.`fechaTermino` AS `fechaTermino`,
        `s`.`horas` AS `horas`,
        `s`.`usuario` AS `usuario`
    FROM
        ((`tblsolicitudes` `s`
        JOIN `tblalumnos` `a` ON ((`a`.`idAlumno` = `s`.`idAlumno`)))
        JOIN `tbldependencias` `d` ON ((`d`.`idDependencia` = `s`.`idDependencia`))
		JOIN `tblcarreras` `e` ON ((`a`.`carrera` = `e`.`idCarrera`))) WHERE numRegistro =  '$num'";
	$solicitud = mysqli_query($conexion,$strConsulta);
	$fila = mysqli_fetch_array($solicitud);

	//crb01
	$queryLeyenda = sprintf("SELECT * FROM tblconfiguraciones WHERE id='LEYENDA_ANUAL_FORMATOS'");
	$solicitudLeyenda = mysqli_query($conexion,$queryLeyenda);
	$filaLeyenda = mysqli_fetch_array($solicitudLeyenda);

	$queryAseguradora = sprintf("SELECT * FROM tblconfiguraciones WHERE id='POLIZA_ASEGURADORA' OR id='NOMBRE_ASEGURADORA'");
	$datosAseguradora = mysqli_query($conexion,$queryAseguradora) or die(mysqli_error($conexion));

	$polizaAseguradora = '';
	$nombreAseguradora = '';
	while($filaAseguradora = mysqli_fetch_array($datosAseguradora,MYSQLI_ASSOC))
	{
		if($filaAseguradora['id'] == 'POLIZA_ASEGURADORA' ){
			$polizaAseguradora = $filaAseguradora['valor'];
		}else if($filaAseguradora['id'] == 'NOMBRE_ASEGURADORA' ){
			$nombreAseguradora = $filaAseguradora['valor'];
		}
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
	$pdf->setSourceFile("../templates/plantilla.pdf");
	// import page 1
	$tplIdx = $pdf->importPage(1);
	// use the imported page and place it at point 10,10 with a width of 100 mm
	$pdf->useTemplate($tplIdx, 0, 0, 216);
	
	$pdf->SetMargins(20,20,20);
	//$pdf->Ln(47);
	
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","SÃ¡bado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$mesesAsunto = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$fechaSolicitud = strtotime($fila['fechaSolicitud']);

	//crb01
	$pdf->SetMargins(20,20,23);
	$pdf->Ln(39);
	$pdf->SetFont('Times','B',9);
	$pdf->SetTextColor(132,130,130);
	$pdf->Cell(0,4,utf8_decode($filaLeyenda['valor']) ,0,1,'C');
	$pdf->Ln(5);

	$pdf->SetTextColor(0,0,0);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,4,utf8_decode('Oficina de PrÃ¡cticas y PromociÃ³n Profesional'),0,1,'R');
	$pdf->Cell(0,4,'Oficio No.: GTV-'.$num.'/OPPP/'.date('y',$fechaSolicitud),0,1,'R');
	$pdf->Ln(3);
	$pdf->Cell(0,4,utf8_decode('Asunto: PresentaciÃ³n del Estudiante y Agradecimientos'),0,1,'R');	
	$pdf->Cell(0,4,utf8_decode('Para Desarrollo de PrÃ¡cticas Profesionales'),0,1,'R');
	$pdf->Ln(3);
	$pdf->Cell(0,4,'Tijuana, B.C.,'.date('d').'/'.$mesesAsunto[date('n')-1].'/'.date('Y'),0,1,'R');
	$pdf->Ln(3);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,4,utf8_decode(strtoupper($fila['tituloResponsable']).' '.strtoupper($fila['responsableDependencia']).','),0,1,'L');
	$pdf->Cell(0,4,utf8_decode(strtoupper($fila['puestoResponsable'])),0,1,'L');
	$pdf->Cell(0,4,utf8_decode(strtoupper($fila['nomDependencia'])),0,1,'L');
	$pdf->Cell(0,4,utf8_decode('PRESENTE.'),0,1,'L');
	if(!empty($fila['conAtencionA'])) {
		$pdf->Cell(0, 4, utf8_decode('Con atenciÃ³n a: '.$fila['conAtencionA']), 0, 1, 'R');
	}

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
//	$pdf->MultiCell(173,5, utf8_decode('El Instituto TecnolÃ³gico de Tijuana, tiene bien a presentar a sus finas atenciones al (la) estudiante ').$fila['nomAlumno'].' '.$fila['apPaterno'].' '.$fila['apMaterno'].', con número de control '.$fila['idAlumno'].' de la carrera de '.$fila['carrera'].', quien desea realizar sus Practicas Profesionales en la empresa que usted representa, cubriendo un total de 640 horas.',0,'J');
//	$pdf->Ln(4);

$pdf->Write(5, utf8_decode('El Instituto TecnolÃ³gico de Tijuana, tiene bien a presentar a sus finas atenciones al (la) estudiante '));
$pdf->SetFont('Arial', 'B', 10);
$pdf->Write(5, ' '.$fila['nomAlumno'].' '.$fila['apPaterno'].'   '.$fila['apMaterno']);
$pdf->SetFont('Arial', '', 10);
$pdf->Write(5, ', con número de control ');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Write(5, $fila['idAlumno']);
$pdf->SetFont('Arial', '', 10);
$pdf->Write(5, ' de la carrera de '.$fila['carrera'].', quien desea realizar sus Practicas Profesionales en la empresa que usted representa, cubriendo un tiempo mínimo de cuatro a seis meses como tiempo máximo.');
$pdf->Ln(7);
//	$pdf->MultiCell(173,5, 'Es importante hacer de su conocimiento que todos los estudiantes que se encuentran inscritos en esta institución cuentan con un seguro contra accidentes personales con la empresa ASEGURADORA Royal & SunAliance Seguros México S.A. de C.V., según póliza No. 5632 e inscripción en el IMSS con Número de Seguro Social '.$fila['nss'].'.',0,'J');
	if(empty($fila['nss'])) {
		$pdf->Write(5, 'Es importante hacer de su conocimiento que todos los estudiantes que se encuentran inscritos en esta institución cuentan con un seguro facultativo, así como un seguro contra accidentes mayores con la empresa ');
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Write(5,utf8_decode($nombreAseguradora).', según póliza No. '.$polizaAseguradora.'.  ');
		$pdf->Ln(7);
		$pdf->SetFont('Arial', '', 10);

	}else{
//		$pdf->Write(5, 'Es importante hacer de su conocimiento que todos los estudiantes que se encuentran inscritos en esta institución cuentan con un seguro contra accidentes personales con la empresa ASEGURADORA Royal & SunAliance Seguros México S.A. de C.V., según póliza No. 5632 e inscripción en el IMSS con Número de Seguro Social '.$fila['nss'].'.',0,'J');
		$pdf->Write(5, 'Es importante hacer de su conocimiento que todos los estudiantes que se encuentran inscritos en esta institución cuentan con un seguro contra accidentes personales con la empresa ');
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Write(5,utf8_decode($nombreAseguradora).', según póliza No. '.$polizaAseguradora.'.  ');
//		$pdf->Ln(7);
		$pdf->SetFont('Arial', '', 10);
		$pdf->Write(5, 'e inscripción en el IMSS con Número de Seguro Social  '.$fila['nss'].'.',0,'J');
		$pdf->Ln(7);
	}

	$pdf->Ln(4);
	$pdf->MultiCell(173,5, 'Así mismo, hacemos patente nuestro sincero agradecimiento por su buena disposición y colaboración para que nuestros estudiantes, aun estando en proceso de formación, desarrollen, un proyecto de trabajo profesional, donde puedan aplicar el conocimiento y el trabajo en el campo de acción en el que se desenvolverán como futuros profesionistas.',0,'J');
	$pdf->Ln(4);
	$pdf->MultiCell(173,5, 'Al vernos favorecidos con su participación en nuestro objetivo, solo nos resta manifestarle la seguridad de nuestra más atenta y distinguida consideración.',0,'J');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,utf8_decode('A T E N T A M E N T E.'),0,1,'L');
	$pdf->SetFont('Arial','I',8);
	$pdf->Cell(0,4,utf8_decode('"Por una Juventud Integrada al Desarrollo de MÃ©xico"'),0,1,'L');



$firma = "../images/firmas/jefe-vinculacion.jpg";
$pdf->Cell( 0, 0, $pdf->Image($firma, $pdf->GetX(), $pdf->GetY(),25), 0, 0, 'L', false );
$pdf->Ln(25);

    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,utf8_decode('MTRO. ARTEMIO LARA CHAVEZ'),0,1,'L');
	$pdf->Cell(0,5,utf8_decode('JEFE DEPTO. DE GESTIÃ“N TECNOLÃ“GICA. Y VINCULACIÃ“N'),0,1,'L');

	$pdf->Output('Carta '.$fila['idAlumno'].'.pdf','I');
?>