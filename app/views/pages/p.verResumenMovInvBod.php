<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Movimientos del Inventario Fisico.
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-inventarioBodega">
                        <thead>
                            <tr>   
                                <th>Clave</th>
                                <th>Descripcion</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Proveedor</th>
                                <th>UM</th>
                                <th>Cantidad Original</th>
                                <th>Cantidad Nueva</th>
                                <th>Fecha Captura</th>
                                <th>Usuario Captura</th>
                                <th>Fecha Ejecucion</th>
                                <th>Usuario Ejecucion</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                foreach ($mov as $data):
                                    $color = '';
                                   
                                    $i++;
                            ?>
                                    <tr class="odd gradeX" <?php echo $color?> id="tr_<?php echo $i?>">
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PRODUCTO?>" target="_blank"><?php echo $data->PRODUCTO?></a></td>
                                        <td><?php echo $data->NOMBRE; ?></td>
                                        <td><?php echo $data->MARCA?></td>
                                        <td><?php echo $data->CATEGORIA?></td>
                                        <td><?php echo $data->PROVEEDOR?></td>
                                        <td><?php echo $data->UM?></td>
                                        <td><?php echo $data->ORIGINAL?></td>
                                        <td><?php echo $data->NUEVA?></td>
                                        <td><?php echo $data->USUARIO?></td>
                                        <td><?php echo $data->FECHA?></td>
                                        <td><?php echo $data->USR_CIERRE; ?></td>
                                        <td><?php echo $data->FECHA_CIERRE?></td>
                                    </tr>
                                <?php endforeach?>
                           </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>