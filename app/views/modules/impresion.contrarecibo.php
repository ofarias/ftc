<?php
 session_start();
 //session_cache_limiter('private_no_expire');
 require_once('app/model/pegaso.model.php');
 require_once('app/fpdf/fpdf.php');
 
 $exec = $_SESSION['exec'];
 $titulo = $_SESSION['titulo'];
 
 //echo "titulo ".$titulo;
 //echo " exec ".$exec;
 
 foreach ($exec as $data):
     $pdf = new FPDF('P', 'mm', 'Letter');
     $pdf->AddPage();
     $pdf->Image('app/views/images/headerpdf_PagoGasto.jpg', 10, 15, 205, 55);
     $pdf->SetFont('Arial', 'I', 12);
     $pdf->SetTextColor(14, 3, 3);
     $pdf->Ln(60);
     $pdf->Cell(10, 10, 'Tipo de documento : ' . $data->TIPO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Documento : ' . $data->DOCUMENTO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Beneficiario : ' . $data->BENEFICIARIO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Fecha documento : ' . $data->FECHA_DOC);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Vencimiento : ' . $data->VENCIMIENTO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Fecha Promesa de pago : ' . $data->PROMESA_PAGO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Monto : ' . number_format($data->MONTO, 2, '.', ','));
     $pdf->Ln(45);
     $pdf->Cell(10, 10, '________________________');
     $pdf->Ln(5);
     $pdf->Cell(10, 10, 'Firma de Recibido');
     $pdf->Output("$titulo".trim($data->ID).".pdf", 'i');
 endforeach;
 