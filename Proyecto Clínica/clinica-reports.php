<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('logo_small_icon_only_inverted.png',10,8,23);
    // Arial bold 15
    $this->SetFont('Arial','B',8);
    // Movernos a la derecha
    $this->Cell(70);
    // Título
    $this->Cell(65,10,utf8_decode('Reporte de citas y cirugías Clínica Encinas'),1,0,'C');
    // Salto de línea
    $this->Ln(30);
    // Nombre de los datos de la tabla
    $this->Cell(32, 5, 'Paciente', 1, 0, 'C', 0);
    $this->Cell(30, 5, 'Correo', 1, 0, 'C', 0);
    $this->Cell(20, 5, 'Celular', 1, 0, 'C', 0);
    $this->Cell(35, 5, utf8_decode('Médico'), 1, 0, 'C', 0);
    $this->Cell(15, 5, 'Sala', 1, 0, 'C', 0);
    $this->Cell(18, 5, 'Fecha', 1, 0, 'C', 0);
    $this->Cell(13, 5, 'Hora', 1, 0, 'C', 0);
    $this->Cell(15, 5, 'Usuario', 1, 0, 'C', 0);
    $this->Cell(15, 5, 'Tipo', 1, 1, 'C', 0);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}

require 'connect.php';
$consulta = "SELECT * FROM cita UNION ALL SELECT * FROM cirugia";
$resultado = $connect->query($consulta);

$pdf = new PDF();
$pdf-> AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7.5);

while($fila = mysqli_fetch_array($resultado)){
   $pdf->Cell(32, 10, utf8_decode($fila['nombre']), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, $fila['correo'], 1, 0, 'C', 0);
   $pdf->Cell(20, 10, $fila['celular'], 1, 0, 'C', 0);
   $pdf->Cell(35, 10, utf8_decode($fila['medico']), 1, 0, 'C', 0);
   $pdf->Cell(15, 10, utf8_decode($fila['sala']), 1, 0, 'C', 0);
   $pdf->Cell(18, 10, $fila['fecha'], 1, 0, 'C', 0);
   $pdf->Cell(13, 10, $fila['hora'], 1, 0, 'C', 0);
   $pdf->Cell(15, 10, $fila['usuario'], 1, 0, 'C', 0);
   $pdf->Cell(15, 10, utf8_decode($fila['tipo']), 1, 1, 'C', 0);
}
ob_start();
$pdf->Output();
ob_end_flush();
?>