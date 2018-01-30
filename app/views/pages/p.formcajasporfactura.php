<br>
<div class="form-horizontal">

<!-- Formulario para creación de nueva caja. -->
<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel panel-heading">
    <h4>Crear nueva caja</h4>
  </div>
  <div class="panel panel-body">
    
  <?php if($validacion == 0){?>
    <form action="index.php" method="post">
     <?php foreach($datafact AS $fact):?>
      <input type="hidden" name="factucajanueva" value="<?php echo $fact->CVE_DOC;?>"/> 
    <?php endforeach; ?>
        <div class="form-group">
          <div class="col-sm-offset-1 col-sm-10"> 
              <!--<?php echo $validacion[0][0];?>-->
              <button name="nuevacaja" type="input" value="enviar" class="btn btn-primary btn-lg btn-block" 
              <?php echo ($validacion == 0)? "":"disabled";?> >  Nueva caja <i class="fa fa-plus"> </i> </button>
         </div> 
        </div>
      </form>
        <?php }?>

  </div>
</div>
</div>
</div>
<br>
<br>
<div class="<?php (empty($exec)) ? hide : nohide; ?>" >
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4>Cajas del Pedido </h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                          <th>Id Caja</th>
                                          <th>Pedido</th>
                                          <th>Fecha de creación Caja</th>
                                          <th>FACTURA / REMISION</th>
                                          <th>Status</th>
                                          <th>Fecha de Cierre</th>
                                          <th>Unidad</th>
                                          <th>Status Logistica</th>
                                          <th>Preparar</th>
                                    </thead>                                   
                                  <?php foreach($exec as $box):

                                      if ($box->REMISION == ''){
                                          $documento = $box->FACTURA;
                                      }elseif ($box->FACTURA != '' ){
                                          $documento = $box->REMISION.'--'.$box->FACTURAS;
                                      }elseif ($box->REMISION !=''){
                                        $documento = $box->REMISION;
                                      }
                                  ?>
                                  <tbody>
                                    <tr>
                                      <td><?php echo $box->ID;?></td>
                                      <td><?php echo $box->CVE_FACT;?></td>
                                      <td><?php echo $box->FECHA_CREACION;?></td>
                                      <td><?php echo $documento;?></td>
                                      <td><?php echo $box->STATUS;?></td>
                                      <td><?php echo $box->FECHA_CIERRE;?></td>
                                      <td><?php echo $box->UNIDAD;?></td>
                                      <td><?php echo $box->STATUS_LOG;?></td>
                                      <form action="index.php" method="post">
                                        <input type="hidden" name="idcaja" value="<?php echo $box->ID;?>"/>
                                        <input type="hidden" name="clavefact" value="<?php echo $box->CVE_FACT;?>"/>
                                        <td><button name="prepararmateriales" type="submit" value="enviar" class="btn btn-primary" <?php echo (($box->STATUS)=='abierto') ? "" : "disabled" ?> > Preparar <i class="fa fa-archive"></i></button></td>
                                      </form>
                                    </tr>
                                 </tbody>
                                 <?php endforeach; ?>
                                </table>
                            </div>
                </div>
      </div>
    </div>
</div>
</div>