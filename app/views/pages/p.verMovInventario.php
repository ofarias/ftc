<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
               Movimiento al inventario del producto &nbsp;&nbsp; <?php echo $producto?>
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-recepciones">
                        <thead>
                            <tr>   
                                <th>IDProd</th>
                                <th>Descripcion</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Unidad</th>
                                <th>Fecha</th>
                                <th>Costo x Unidad</th>
                                <th>Tipo </th>
                                <th>Documento</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                                $totalCosto = 0;
                                $color= '';
                                foreach ($mi as $data): 
                                    if($data->TIPO == 'Entrada (Orden de Compra)' or $data->TIPO == 'Entrada (Ingreso Bodega)'){
                                        $entrada = $data->CANTIDAD; 
                                        $salida = 0;
                                    }else{
                                        $entrada = 0;
                                        $salida = $data->CANTIDAD;
                                    }

                                        
                            ?>
                                    <tr class="odd gradeX" <?php echo $color?>>
                                     
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PRODUCTO?>" target="_blank"><?php echo $data->PRODUCTO?></a></td>
                                        <td><?php echo $data->DESCRIPCION; ?></td>
                                        <td><?php echo $entrada?></td>
                                        <td><?php echo $salida?></td>
                                        <td><?php echo $data->UNIDAD?></td>
                                        <td><?php echo $data->FECHA; ?></td>
                                        <td><?php echo $data->COSTO?></td>
                                        <td><?php echo $data->TIPO?></td>
                                        <td><?php echo $data->DOCUMENTO?></td>
                                    </tr>                                
                                    <?php
                                endforeach;
                           
                            ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

</script>