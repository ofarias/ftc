<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestros   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Sucursales</th>
                                            <th>Cartera Revision</th>
                                            <th>Cartera Cobranza</th>
                                            <th>Centros de Compras</th>
                                            <th>Total CC</th>
                                           
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($maestro as $data): 
                                            $cvem = $data->CLAVE;
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->SUCURSALES;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td><?php echo $data->CARTERA_REVISION;?></td>
                                            <td><?php echo $data->CCS?></td>
                                            <td><?php echo '$ '.number_format($data->TOTCCS,2)?></td>
                                            
                                             
                                        </tr>
                                        </form>
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
                           CENTROS DE COMPRA <br/>   
                            <a class="btn btn-success" href="index.php?action=nuevo_cc&cvem=<?php echo $cvem ?>" class="btn btn-success"> Alta de Centro de Compras <i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Contacto</th>
                                            <th>Telefono</th>
                                            <th>Presupuesto</th>
                                            <th>Individual</th>
                                          
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($ccc as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->COMPRADOR;?></td>
                                            <td><?php echo $data->TELEFONO;?></td>
                                            <td><?php echo '$ '.number_format($data->PRESUPUESTO_MENSUAL,2);?></td>
                                            <td><?php echo $data->CLIENTE?></td>
                                        </tr>
                                        </form>
                                        <?php endforeach;?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />
