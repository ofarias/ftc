<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Cartera día.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Factura</th>
                                <th>Importe Factura</th>
                                <th>Fecha Factura</th>
                                <th>Remisión</th>
                                <th>Importe Remisión</th>
                                <th>Fecha Remisión</th>
                                <th>Estatus</th>
                                <th>CR</th>
                                <th>Días</th>
                                <th>Guia Feltera</th>
                                <th>Fletera</th>
                                <th>Guardar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($acuse as $data):
                            if($data->DIAS >= 10)
                                $color = "background-color: #ff8080";
                            elseif($data->CAJA == 'Total Cliente')
                                $color = "background-color: #99d6ff";
                            else $color = "";
                        ?>
                            <tr style="<?php echo $color;?>" >

                                <td><?php echo $data->CVE_FACT;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->FACTURA;?></td>
                                <td><?php echo "$ ".number_format($data->IMPFAC,2,".",",");?></td>
                                <td><?php echo $data->FECHAFAC;?></td>
                                <td><?php echo $data->REMISION;?></td>
                                <td><?php echo "$ ".number_format($data->IMPREM,2,".",",");?></td>
                                <td><?php echo $data->FECHAREM;?></td>
                                <td><?php echo $data->STATUS_LOG;?></td>
                                <td><?php echo $data->CARTERA_REV;?></td>
                                <td><?php echo $data->DIAS;?></td>
                                  <form action="index.php" method="post">
                                      <td><input type="text" name="guia" required = "required"/></td>
                                      <input type="hidden" name="caja" value="<?php echo $data->CAJA?>" />
                                      <input type="hidden" name="doccaja" value="<?php echo $data->CVE_FACT?>"/>
                                      <input type="hidden" name="factura" value="<?php echo $data->FACTURA?>" />
                                      <input type="hidden" name="remision" value="<?php echo $data->REMISION?>" />
                                      <input type="hidden" name="cr" value="<?php echo $data->CARTERA_REV?>" />
                                      <td><input type = "text" name = "fletera" required="required" /></td>
                                      <td><button type="submit" name="info_foraneo" class="btn btn-warning">Guardar <i class="fa fa-save"></i></button></td>
                                  </form>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <div class="panel-footer text-right">
                <a class="btn btn-info" target="_blank" href="index.php?action=ImprmirCarteraDia&cr=<?php echo $cart;?>">Imprimir <i class="fa fa-print"></i></a>
            </div>
        </div>
    </div>
</div>

