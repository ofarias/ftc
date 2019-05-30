<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Recepciones de &oacute;rdenes de compra
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-inventarioBodega">
                        <thead>
                            <tr>   
                                <th>Producto</th>
                                <th>Descripcion</th>
                                <th>Pedido</th>
                                <th>Proveedor</th>
                                <th>Recibido</th>
                                <th>Empacado</th>
                                <th>En Bodega</th>
                                <th>Unidad</th>
                                <th>Costo Unitario</th>
                                <th>Costo Total</th>
                                <th>Validar</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                $total=0;
                                foreach ($inventario as $data):
                                    if($data->PROCESADO > 0 ){
                                        $color = "style='background-color:green;'";
                                    }else{
                                        $color = '';
                                    }
                                    $i++;
                                    if(empty($data->RECEPCION)){
                                        $CANTIDAD = $data->ENBODEGA;
                                    }else{
                                        $CANTIDAD = $data->RECEPCION - $data->EMPACADO;    
                                    }
                                    $total = $total + (($data->COSTO * $CANTIDAD) * 1.16);
                            ?>
                                    <tr class="odd gradeX"  id="tr_<?php echo $i?>" <?php echo $color?>>
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PROD?>" target="_blank"><?php echo $data->PROD.'<br/>'.$data->ID?></a></td>
                                        <input type="hidden" name="idpreo" id="idpreoc_<?php echo $i?>" value="<?php echo $data->ID?>" >
                                        <input type="hidden" name="canto" id="canto_<?php echo $i?>" value="<?php echo $data->RECEPCION?>">
                                        <input type="hidden" name="prod" id="prod_<?php echo $i?>" value="<?php echo $data->PROD?>">
                                        <td><?php echo $data->NOMPROD; ?></td>
                                        <td><?php echo $data->COTIZA?></td>
                                        <td><?php echo $data->NOM_PROV?></td>
                                        <td><?php echo $data->RECEPCION?></td>
                                        <td><?php echo $data->EMPACADO?></td>
                                        <td><?php echo $CANTIDAD?></td>
                                        <td><?php echo $data->UM?></td>
                                        <td><?php echo $data->COSTO?></td>
                                        <td align="right"><?php echo '$ '.number_format($data->COSTO * $CANTIDAD,2)?> <br/> <?php echo '$ '.number_format((($data->COSTO * $CANTIDAD) * .16),2)?> <br/> <font color="red"><?php echo '$ '.number_format((($data->COSTO * $CANTIDAD) * 1.16),2)?> </font></td>
                                    </tr>
                                <?php endforeach?>
                           </tbody>
                          <h1> <label> SubTota: <?php echo '$ '.number_format($total/1.16,2);?> IVA: <?php echo '$ '.number_format(($total/1.16)*.16,2);?> Total : <?php echo '$ '.number_format($total,2);?></label></h1>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <br/>
    <a href="index.php?action=invPatioGral&opcion=guardar" class="btn btn-success" > Guardar Inventario </a>     
</div>

