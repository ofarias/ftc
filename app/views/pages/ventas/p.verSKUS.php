<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Solicitudes Pendientes.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>CLIENTE</th>
                                            <th>PRODUCTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>SKU_ADDENDA</th>
                                            <th>SKU_CLIENTE</th>
                                            <th>OTRO_CODIGO</th>
                                            <th>GUARDAR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                       foreach ($skus as $data): 
                                        ?>
                                       <tr>
                                         <td><?php echo '('.$data->CLIENTE.') '.$data->NOMBRE;?></td>
                                            <td><?php echo 'PGS'.$data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                        
                                            <form action="index.v.php" method="post">
                                            <td><input type ="text" name="sku" value="<?php echo $data->SKU?>" required="required"> </td>
                                            <td><input type="text" name="sku_cliente" value="<?php echo $data->SKU_CLIENTE?>" ></td>
                                            <td><input type="text" name="sku_otro" value="<?php echo $data->SKU_OTRO?>"></td>
                                            <input type="hidden" name="producto" value="<?php echo 'PGS'.$data->CVE_ART?>">
                                            <input type="hidden" name="cdfolio" value="<?php echo $data->FOLIO?>">
                                            <input type="hidden" name="cliente" value="<?php echo $data->CLIENTE?>">
                                            <input type="hidden" name="nombre" value="<?php echo $data->NOMBRE?>">
                                            <input type="hidden" name="descripcion" value="<?php echo $data->DESCRIPCION?>">
                                            <input type="hidden" name="cotizacion" value="<?php echo $data->COTIZA?>">
                                            </td>
                                            <td>
                                             <button name="guardaSKU" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Guardar </button>
                                             </td> 
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                           <!-- /.table-responsive -->
                   
            </div>
        </div>
    </div>
</div>

<div>
    <input type="button" name="Finalizar" value="Finaliza" onclick="cerrarVentana()">
</div>

<script type="text/javascript">
    
    function cerrarVentana(){
        window.close();
    }

</script>