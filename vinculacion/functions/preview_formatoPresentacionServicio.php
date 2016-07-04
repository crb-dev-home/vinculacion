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

function Header()
{
	//Put the watermark
	$this->SetFont('Arial','B',50);
	$this->SetTextColor(255,192,203);
	$this->RotatedText(35,190,'Esta es solo vista previa',45);
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
	$pdf->Ln(52);
	
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$mesesAsunto = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$fechaInicio = strtotime($_GET['fechaInicio']);
	$fechaTermino = strtotime($_GET['fechaTermino']);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'Tijuana, B.C.,'.date('d').'/'.$mesesAsunto[date('n')-1].'/'.date('Y'),0,1,'R');
	$pdf->Cell(0,4,'Oficio No.: '.$_GET['numSolicitud'].'/GTV/'.date('Y'),0,1,'R');
	$pdf->Cell(0,4,utf8_decode('Asunto: PRESENTACIÓN DE SERVICIO SOCIAL'),0,1,'R');	
	$pdf->Ln(25);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,4,utf8_decode('MTRO. JOSÉ ERNESTO MEDINA AGUILAR,'),0,1,'L');
	$pdf->Cell(0,4,utf8_decode('COORDINADOR NACIONAL DE BECAS'),0,1,'L');
	$pdf->Cell(0,4,utf8_decode('DE EDUCACIÓN SUPERIOR,'),0,1,'L');
	$pdf->Cell(0,4,utf8_decode('PRESENTE.'),0,1,'L');
	$pdf->Ln(15);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(173,5, 'Se hace constar que el/la alumno (a): '.utf8_decode($_GET['nomAlumno']).' '.utf8_decode($_GET['apPaterno']).' '.utf8_decode($_GET['apMaterno']).' con No. Control: '.$_GET['idAlumno'].' de la carrera de '.$_GET['carrera'].utf8_decode(', se encuentra inscrito (a) en el AGO-DIC/2015 y cubre «CREDITOS» de los CRÉDITOS REQUERIDOS por esta Institución para llevar a cabo su servicio social. Así mismo, se hace constar que ha sido ACEPTADO (A) por ').utf8_decode($_GET['nomDependencia']).utf8_decode(' para llevar a cabo dicho SERVICIO SOCIAL en el periodo: ').$meses[date('m',$fechaInicio)-1].' del '.date('Y',$fechaInicio).' a '.$meses[date('m',$fechaTermino)-1].' del '.date('Y',$fechaTermino).utf8_decode(' y que reportó a esta Institución el programa de: '.$_GET['programa']),0,'J');
	

    $pdf->Ln(8);
	
	$pdf->MultiCell(177,6,utf8_decode('A petición del o la interesado(a) y para los usos legales que al mismo convengan se extiende la presente.'),0,'J');
    $pdf->Ln(15);
    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,utf8_decode('A T E N T A M E N T E.'),0,1,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(0,4,utf8_decode('"Por una Juventud Integrada al Desarrollo de México"'),0,1,'L');
	
    $pdf->SetFillColor(255); 
    
	$pdf->SetXY(17, 205);
    $pdf->Cell(70, 5, '_______________________________', 0, 1, 'C', 1); 
    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,utf8_decode('M.A. ARTEMIO LARA CHAVEZ,'),0,1,'L'); 
	$pdf->Cell(0,5,utf8_decode('JEFE DEL DEPTO. DE GESTIÓN TECNOLÓGICA. Y VINCULACIÓN.'),0,1,'L');  
	$pdf->Ln(6);
    $pdf->Cell(0,4,utf8_decode('c.c.p. Expediente.'),0,1,'L');
	$pdf->Cell(0,4,utf8_decode('JGG/ALCH/jfg.'),0,1,'L');


	$pdf->Output('Carta '.$fila['idAlumno'].'.pdf','I');
?>