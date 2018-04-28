<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Compras no gregistradas al Edo de Cuenta.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-compras">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Compra Con:</th>
                                            <th>Proveedor</th>
                                            <th>Monto</th>
                                            <th>Orden de Compra</th>
                                            <th>Recepciones SAE</th>
                                            <th>Fecha / Horas Recepcion</th>
                                            <th>Banco</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            <th>Registrar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($compras as $data): 
                                            if($data->STATUS == 'I'){
                                                $STATUS = 'IMPRESO';
                                            }
                                            if(substr($data->FOLIO, 0,2) == 'ch'){
                                                $tipo = 'Cheque';
                                            }elseif(substr($data->FOLIO, 0,2)== 'tr'){
                                                $tipo = 'Transferencia';
                                            }elseif(substr($data->FOLIO, 0,1)== 'e'){
                                                $tipo = 'Efectivo';
                                            }elseif(substr($data->FOLIO, 0,2)== 'CR'){
                                                $tipo = 'Credito';
                                            }
                                            ?>
                                        <tr>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $tipo;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td></td>
                                            <td><?php echo $data->FECHA_REC_CONTA;?></td>
                                            <td><?php echo $data->BANCO?></td>
                                            <td><?php echo $data->USUARIO_RECIBE?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input type="text" name="fecEdoCta" placeholder="Seleccione Fecha" class="datepicker" required="required">
                                            </td>
                                            <td>
                                                <button name="regCompraEdoCta" value = "enviar" type="submit" class="btn btn-danger">Registrar</button>
                                            </td>
                                            <input name="folio" type="hidden" value="<?php echo $data->FOLIO?>"/>
                                            <input type="hidden" name="doc" value = "<?php echo $data->DOCUMENTO?>">
                                            </form>      
                                        </tr>
                                        
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<script>
        
   $(document).ready(function() {
    $(".datepicker").datepicker({dateFormat:'dd.mm.yy'});
  } );

</script>