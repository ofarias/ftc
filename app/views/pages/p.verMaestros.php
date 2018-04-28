<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Saldo General de la Cartera de clientes .
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr> 
                                <th>Saldo Global 2015</th>
                                <th>Saldo Globla 2016</th>
                                <th>Saldo Globla 2017</th>
                                <th>Total Acreedores <br/> Identificado / Por Identificar</th>                                
                                <th>Total Cartera de Clientes</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach ($saldoAcumulado as $d):
                            
                            $s15=$d->SA15;
                            $s16=$d->SA16;
                            $s17=$d->SA17;
                            $ac = $d->SAC;
                            $pa = $d->PORAPLICAR;
                            $TA = ( $s16 + $s17) - $ac - $pa;
                        ?>
                            <tr>
                                <td align="center"> <a href="index.php?action=verFolio2015">Consultar 2015</a></td>
                                <td align="center" ><?php echo '$ '.number_format($d->SA16,2);?></td>
                                <td align="center"><?php echo '$ '.number_format($d->SA17,2,".",",");?></td>
                                <td align="center"><?php echo '$ '.number_format($d->PORAPLICAR,2)?>  <br/> 
                                <?php echo '$ '.number_format($d->IDENTIFICADO,2).' / $ '?><a href="index.php?action=verCPNoIdentificados" target='_blank'><?php echo number_format($d->NOIDENTIFICADO,2)?></a>

                                </td>
                                <td align="center" ><?php echo '$ '.number_format($TA,2)?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>   
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestros   
                            <a class="btn btn-success" href="index.php?action=nuevo_maestro" class="btn btn-success"> Crear Maestro <i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Cartera</th>
                                            <th>Sucursales</th>
                                            <th>Linea de Credito <br/> Otorgada </th>
                                            <th>Linea de Credito <br/> Comprometida </th>
                                            <th>Acreedores</th>
                                            <th>Deuda Estimada</th>
                                            <th>Pedidos Pendientes</th>
                                            <th>Facturas / Remisiones <br/> En Transito </th>   <!-- En Logistica  -->
                                            <th>Facturas / Remisiones <br/> Por Revisionar </th> <!-- En Revision -->
                                            <th>Facturas en CxC </th>  <!-- En Cobranza -->
                                            <th>Editar</th>
                                            <th>CCC</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($maestros as $data):

                                            if($data->ID < 206){
                                                $color = "style='background-color:grey'";
                                            }else{
                                                $color = '';
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td><?php echo $data->SUCURSALES;?></td>
                                            <td align="right" style="font-size:15px "><b><?php echo '$ '.number_format($data->LIMITE_GLOBAL,2);?></b></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->REVISION + $data->COBRANZA + $data->LOGISTICA),2)?></td>
                                            <td align="right"><font color="#F7FE2E"><?php echo '$ '.number_format($data->ACREEDOR,2)?></font></td>
                                            <td align="right" style="font-size:15px"><b><?php echo '$ '.number_format(($data->REVISION + $data->COBRANZA + $data->LOGISTICA)-$data->ACREEDOR,2)?></b></td>
                                            <td> Pedidos Pendientes </td>
                                            <td align="right"><?php echo '$ '.number_format($data->LOGISTICA,2);?></td>  <!-- En Logistica -->
                                            <td align="right"><?php echo '$ '.number_format($data->REVISION,2);?></td>  <!-- En Revision -->
                                            <td align="right"><font color="#58FA58"><?php echo '$ '.number_format($data->COBRANZA,2);?></font></td> <!-- En Cobranza -->
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idm" value="<?php echo $data->ID?>" >
                                                <input type="hidden" name="cvem" value="<?php echo $data->CLAVE?>">
                                                <button name="editarMaestro" value="enviar" type="submit" class="btn btn-info"> Editar </button>
                                            </td>
                                            <td>
                                                <button type="submit" value="enviar" name="verCCC" class="btn btn-success"> CCC </button>
                                            </td>
                                            <td>
                                                <button type="submit" values="enviar" name="detalleMaestro" class="btn btn-info"> ver Detalle</button>
                                            </td>
                                             
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
