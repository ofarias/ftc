<br/>
<br/>
<div>
 <label>Nuevo Producto</label>
  <a href="index.php?action=altaProductoFTC&marca=<?php echo $marca?>&prov1=<?php echo $prov1?>&desc1=<?php echo $desc1?>&desc2=<?php echo $desc2?>&categoria=<?php echo $categoria?>&generico=<?php echo $generico?>&unidadmedida=<?php echo $unidadmedida?>" class="btn btn-success">Nuevo</a>
</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Cat</th>
                                            <th>Marca</th>
                                            <th>Generico / Sinonimo</th>
                                            <th>Modelo</th>
                                            <th>Proveedor <br/> Clave </th>
                                            <th>Empaque</th>
                                            <th>Clave Fabricante</th>
                                            <!--<th>Clientes</th>-->
                                            <th>Clientes</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($productos as $data): 
                                        ?>
                                        <tr>
                                            <td><?php echo $data->IDC;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->GENERICO;?> 
                                            <?php echo ($data->CALIFICATIVO == '')? '':', '.$data->CALIFICATIVO?> 
                                            <?php echo ($data->SINONIMO == '')? '':', '.$data->SINONIMO?>
                                            <?php echo ($data->MEDIDAS == '')? '':', '.$data->MEDIDAS?>
                                            <?php echo ($data->UM == '')? '':', '.$data->UM?>
                                                
                                            </td>

                                            <td><?php echo $data->CLAVE_PROD?></td>
                                            <td><?php echo $data->CLAVE_DISTRIBUIDOR?> <br/><p style="font-weight: bold; background-color: red"> <?php echo $data->CLAVE_FABRICANTE.' Precio Lista $ '.$data->PRECIO?> <p><p style="font-weight: bold; background-color: yellow">Costo Neto $ <?php echo $data->COSTO?> </p> </td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->SKU?></td>
                                            <form action="index.v.php" method="post">
                                            <td>
                                                <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                                <button  type="sutbmit" value="enviar" class="btn-xs btn-info" name="cltXprod"> Clientes </button>
                                            </td>
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


