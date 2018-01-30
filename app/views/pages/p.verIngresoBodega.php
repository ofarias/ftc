<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Recepciones de &oacute;rdenes de compra
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-recepciones">
                        <thead>
                            <tr>   
                                <th>IDProd</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Costo x Unidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($ingresos != null) {
                                $totalCosto = 0;
                                foreach ($ingresos as $data):
                                    $totalCosto = $totalCosto + ($data->COSTO * $data->CANT);
                                    $color= '';
                                    
                            ?>
                                    <tr class="odd gradeX" <?php echo $color?>>
                                     <form action ="index.php" method="post">
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PRODUCTO?>" target="_blank"><?php echo $data->PRODUCTO?></a></td>
                                        <td><?php echo $data->DESCRIPCION; ?></td>
                                        <td><input name= "cantidad" type="number" step="any" value="<?php echo $data->CANT;?>" disabled="disabled" </td>
                                        <td><input type="text" name="unidad" placeholder="Unidad de Medida" value="<?php echo $data->UNIDAD;?>" disabled="disabled"></td>
                                        <td><?php echo $data->FECHA; ?></td>
                                        <td><input type = "text" name="proveedor" placeholder="Proveedor" value="<?php echo $data->PROVEEDOR?>" disabled="disabled" />
                                        </td>
                                        <td align="right"><input type="number" step="any" name="costo" placeholder="<?php echo $data->COSTO?>" value="<?php echo (empty($data->COSTO))? '0':$data->COSTO; ?>"  disabled="disabled" /> </td>
                                        <input type="hidden" name="idi" value="<?php echo $data->ID;?>" />
                                        </form>
                                    </tr>                                
                                    <?php
                                endforeach;
                            } else {
                                ?>                               
                                <tr class="odd gradeX">
                                    <td colspan="6">No hay datos</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <label><font size="12px">Total de Costo en Bodega </font> <font size="10px" color="red">$ &nbsp; <?php echo number_format($totalCosto,2)?></font></label>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

</script>