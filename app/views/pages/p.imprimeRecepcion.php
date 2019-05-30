<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                        <div class="panel-heading">
                           Teclee en numero de Recepcion a Imprimir.
                        </div>
        <div class="row">
            <br />
        </div>
        <div class="row">
                <div class="col-md-6">
                    <form action="index.php" method="post">
                    <div class="form-group">
                        <input type="text" name="doco" class="form-control" required="required" placeholder="Buscar Numero de Recepcion"> <br/>
                        <label> Ejemplo: para encontrar la Recepcion 1, puede buscar por 1</label>
                    </div>
                      <button type="submit" value = "enviar" name = "impresionRecepcion" class="btn btn-info">Imprimir Recepcion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br />


<?php if($ho <> 'a'){
    ?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Informacion la Orden de compra <?php echo $doco?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Orden de <br/> Compra</th>
                                            <th>Fecha Documento</th>
                                            <th>Importe</th>
                                            <th>Folio Pago</th>
                                            <th>Monto Pago </th>
                                            <th>Status Recepcion.</th>
                                            <th>No. de Recepcion.</th>
                                            <th>Usuario Recepcion.</th>
                                            <th>Imprimir <br/> Recepcion </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($ho as $data):  

                                            if($data->STATUS_RECEPCION == 2){
                                                $status = 'Recepcion Finalizada';
                                            }elseif ($data->STATUS_RECEPCION == 9) {
                                                $status = 'En proceso  por, '.$data->USUARIO_RECIBE;
                                            }elseif (empty($data->STATUS_RECEPCION) and $data->STATUS_LOG == 'Total') {
                                                $status = 'Pendiente';
                                            }elseif (empty($data->STATUS_RECEPCION) and $data->STATUS_LOG <> 'Total') {
                                                $status = 'En logistica';
                                            }

                                            if(empty($data->ID_RECEPCION)){
                                                $norecep = 'No Existe';
                                            }else{
                                                $norecep = $data->ID_RECEPCION;
                                            }
                                        ?>
                                       <tr>
                                            <td>
                                                 <?php echo $data->NOMBRE;?>
                                            </td>
                                            <td><?php echo $data->CVE_DOC;?><br/> <a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" >Ver Original</a></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo $data->TP_TES?></td>
                                            <td><?php echo $data->PAGO_TES?></td>
                                            <td><?php echo $status;?></td>
                                            <td><?php echo $norecep?></td>
                                            <td><?php echo $data->USUARIO_RECIBE?></td>
                                            <td>
                                                <?php if(strtoupper(substr($doco, 0,1)) == 'I'){?>
                                                    <input class="btn btn-success" type="button" name="impAsignacion" value="Impresion Asignacion" onclick="impAsignacion()">
                                                <?php }else{?>
                                                <form action="index.php" method="post">
                                                <input type="hidden" name="doco" value="<?php echo $data->CVE_DOC?>">
                                                <input type="hidden" name="idr" value="<?php echo $data->ID_RECEPCION?>">
                                                <button class="btn btn-success" value="enviar" type="submit" name="imprimeRecep" <?php echo (!empty($data->ID_RECEPCION))? "":"disabled='disabled'" ?> > <?php echo ($data->IMPRESION > 0)? 'Re-Imprimir':'Impresion' ?></button>
                                                </form>
                                                <?php }?>
                                            </td>
                                        </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<form action="index.php" method="POST" id="formulario">
    <input type="hidden" name="doco" value="<?php echo $doco ?>" id="folioImp" >
    <input type="hidden" name="impFolioReciboBodega" >
</form>

<script type="text/javascript">
    
    function impAsignacion(){
        var doco = document.getElementById('folioImp').value;
        if(confirm('Se imprimiran todos la recepcion del folio de impresion' + doco)){
            var form = document.getElementById('formulario');
            form.submit();
        }  

    }

</script>