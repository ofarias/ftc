
<?php if($oc!=1)
{
    ?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Ordenes de compra:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Linea<br/>Documento</th>
                                            <th>Fecha de Orden</th>
                                            <th>Crea la OC: </th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Folio de Pago</th>
                                            <th>Fecha Pago</th>
                                            <th>Estatus</th>
                                            <th>Monto Final</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($oc as $data):
                                        $i++;

                                        ?>
                                       <tr>  
                                       <form action = "index.php" method="post" >
                                            <td><?php echo $i.'<br/>'.$data->OC;?></td>
                                            <td><?php echo $data->FECHA_OC;?></td>
                                            <td><?php echo $data->USUARIO_OC ?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO_TOTAL,2);?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO?></td>
                                            <td><?php echo $data->STATUS == 'ORDEN'? 'SIN PAGO':$data->STATUS ?></td>
                                            <td><?php echo $data->UNIDAD.'<br/><font color="#07d36d"><b>'.$data->STATUS_LOG.'</b></font>'?></td>
                                            <td>
                                            </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>

                      </div>
            </div>
        </div>
</div>
</div>
<?php }
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
  } );

</script>

