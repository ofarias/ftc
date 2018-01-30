<?php
 session_start();
 require_once('../fpdf/fpdf.php');
 $folio = $_SESSION['folio']; 
 $exec = $_SESSION['exec'];
 $titulo = $_SESSION['titulo'];


 foreach ($exec as $data):

     $pdf = new FPDF('P', 'mm', 'Letter');
     $pdf->AddPage();
     $pdf->Image('../views/images/headerContraReciboCompra.jpg', 10, 15, 205, 55);
     $pdf->SetFont('Arial', 'I', 12);
     $pdf->SetTextColor(14, 3, 3);
     $pdf->Ln(60);
     $pdf->Cell(10, 10, 'Tipo de documento : ' . $data->TIPO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Folio : CRP-' . $folio);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Recepcion : ' . $data->RECEPCION);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Orde de Compra : ' . $data->OC);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Factura Proveedor : ' . $data->FACTURA);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Beneficiario : ' . $data->BENEFICIARIO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Fecha documento : ' . $data->FECHA_DOC);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Vencimiento : ' . $data->VENCIMIENTO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Fecha Promesa de pago : ' . $data->PROMESA_PAGO);
     $pdf->Ln(10);
     $pdf->Cell(10, 10, 'Monto : $ ' . number_format($data->MONTOR, 2, '.', ','));
     $pdf->Ln(45);
     $pdf->Cell(10, 10, '________________________');
     $pdf->Ln(5);
     $pdf->Cell(10, 10, 'Firma de Recibido');
     $pdf->Output("$titulo".trim($data->ID).".pdf", 'i');
 endforeach;
 