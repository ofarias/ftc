<div>
<!--
  <?php if($tipoUsuario == 'G'){?>
  <p><font size="3pxs">Total de Cartera revision </font></p>
  <p><font size="3pxs">Total de Cartera R1 </font></p>
  <p><font size="3pxs">Total de Cartera R2 </font></p>
  <p><font size="3pxs">Total de Cartera R3 </font></p> 
<?php }else{?>
  <p>Total de Cartera <?php echo $tipoUsuario?> : </p>
<?php }?>
-->
<?php 
      $facturas = $saldos['FACTURAS'];
      $remisiones = $saldos['REMISIONES'];
      $prefacturas = $saldos['PREFACTURAS'];
?>

</div>
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
              <p id="cobranza"></p>
              <p id="logistica"></p>
              <p id="liberado"></p>
              <p id="revision"></p>
              <p id="saldoCliente"></p>
              <p id="lineaComprometida"></p>

            <?php foreach($documentos as $data):
                if($tipo == 6){
                    $tipo = 62;
                }elseif($tipo == 7){
                    $tipo = 72;
                }

                ?>
               <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><?php echo $data->CARTERA?> </h4>
                    </div>
                    <div class="panel-body">
                        <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=<?php echo $tipo?>">Numero de Documentos: <font color="blue"><?php echo $data->DOCUMENTOS ?></font></a></p>
                        <p>Monto en Facturas: <font color="red"><?php echo '$ '.number_format($facturas,2)?></font></p>
                        <p>Monto en Remisiones: <font color="blue"><?php echo '$ '.number_format($remisiones,2)?></font></p>
                        <p>Monto en Prefacturas: <font color="blue"><?php echo '$ '.number_format($prefacturas,2)?></font></p>

                    </div>
                </div>
            </div>
        <?php endforeach;?>
    
    </div>  
</div>

