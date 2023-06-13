
<br/>
<div class="row">
    <div class="container-fluid">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Datos del Cliente:</h3>
                </div>
                <br />
                <?php foreach ($cli as $dato):
                    $A = $dato->NOMBRE;
                    $XA = $dato->SXA;
                ?>
                <div class="panel panel-body">
                    <form action="index.php" method="post" id="formpago">
                        <div class="form-group">
                            <label> Nombre: <?php echo $A;?>---- Clave: <?php echo $dato->CLAVE?> ---- Saldo: <?php echo $dato->SALDO?> ---- Por Aplicar: <?php echo (empty($XA)? '0.00':'<?php echo $XA;?>');?> </label>
                        </div>
                        <div class="form-group">
                            <label> Direccion: <?php echo $dato->CALLE;?> No.Ext: <?php echo $dato->NUMEXT?> --- Telefono: <?php echo $dato->TELEFONO?> --- Ponderacion 1: 12 dias --- Ponderacion 2: 18 dias </label>
                        </div>
                        <div class="form-group">
                            <label> CR: <?php echo $dato->CARTERA_REVISION;?>  CC: <?php echo $dato->CARTERA_COBRANZA?> Dias de Pago:  <?php echo $dato->DIAS_PAGO;?> PLAZO: <?php echo $dato->PLAZO;?> Dias, --- PORTAL ADDENDA: <?php echo $dato->ADD_PORTAL?> </label>
                            <br>
                            <label> Linea de Credito: <?php echo $dato->LINEA_CRED;?></label>
                            <br>
                            <label> Monto en Pedidos Autorizados: <?php echo $dato->MONTO_PEDIDOS;?></label>
                            <br>
                            <label> Monto Facturado: <?php echo $dato->MONTO_FACTURADO;?> </label>
                            <br>
                            <label> Monto Vencido: <?php echo (empty($dato->VENCIDO)? '0.00':'$dato->VENCIDO');?> </label> 
                            <br>
                            <label> Credito Disponible: <?php echo $dato->DISPONIBLE;?></label>
                        </div>
            <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?php
if (empty($facturas)){
}else{ 
?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Pagos Registrados con Saldo.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>PEDIDO O REMSISION</th>
                                            <th>FACTURA</th>
                                            <th>NOTA DE CREDITO</th>
                                            <th>STATUS</th>
                                            <th>FECHA</th>
                                            <th>IMPORTE</th>
                                            <th>SALDO ACTUAL</th>
                                            <th>DIAS</th>
                                            <th>PEDIDO CLIENTE</th>
                                            <th>APLICAR PAGO</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($facturas as $datos): ?>
                                       <tr>
                                            <td><?php echo (empty($datos->DOC_ANT)? 'Factura Directa':$datos->DOC_ANT)?></td>
                                            <td><?php echo $datos->CVE_DOC?></td>
                                            <td><?php echo $datos->DOC_SIG?></td>
                                            <td><?php echo $datos->STATUS?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td><?php echo $datos->IMPORTE;?></td>
                                            <td><?php echo $datos->SALDO;?></td>
                                            <td><?php echo $datos->DIAS;?></td>
                                            <td><?php echo $datos->CVE_PEDI;?></td>
                                            <td>
                                            <button name="aplicarPagoFact" value="enviar" type="submit" class="btn btn-warning">Aplicar Pago<i class="fa fa-angle-double-right"></i></button>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php
        }
?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

  $(document).ready(function() {
    $(".fecha").datepicker({dateFormat: 'mm-dd-yy'});
  } );
  
  
  </script>