<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="doco" class="form-control" placeholder="Orden de Compra Ejemplo: OC24511">
          </div>
          <button type="submit" value = "enviar" name = "traeValidacion" class="btn btn-default">Buscar Orden de Compra</button>
          </form>
    </div>
</div>
<br />

<?php if($validacion){?>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Validaciones de la Orden de compra <?php echo $compo;?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>OC</th>
                                            <th>Recepcion</th>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad OC</th>
                                            <th>Cantidad Valida</th>
                                            <th>Monto Compra</th>
                                            <th>Saldo</th>
                                            <th>PXR</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead> 
                                    <tfoot>
                                        <th colspan="11"></th>
                                        <th><button type="submit" form="productosrecibidos" name="ImpRecepVal" class ="btn btn-info" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button></th>
                                    </tfoot>                                 
                                  <tbody>
                                        <?php 
                                        foreach ($validacion as $data): 
                                            
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->CANT_REC?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->SALDO;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->STATUS_REC;?></td>
                                            <form action="index.php" method="post" id="productosrecibidos">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
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

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Validaciones de la Orden de compra <?php echo $compo;?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>OC</th>
                                            <th>Recepcion</th>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad OC</th>
                                            <th>Cantidad Valida</th>
                                            <th>Monto Compra</th>
                                            <th>Saldo</th>
                                            <th>PXR</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead> 
                                    <tfoot>
                                        <th colspan="11"></th>
                                        <th><button type="submit" form="productosrecibidos" name="ImpRecepVal" class ="btn btn-info" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button></th>
                                    </tfoot>                                 
                                  <tbody>
                                        <?php 
                                        foreach ($validacion as $data): 
                                            
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->CANT_REC?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->SALDO;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->STATUS_REC;?></td>
                                            <form action="index.php" method="post" id="productosrecibidos">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
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
<?php }else{ }?>