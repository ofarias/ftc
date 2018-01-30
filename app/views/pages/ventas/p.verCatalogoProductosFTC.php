
<br/>
<br/>
<div>
<form action="index.php" method="post">
<input type="hidden" name="descripcion" value="">
 <label>Nuevo Producto</label>
  <a href="index.php?action=altaProductoFTC&marca=<?php echo $marca?>&prov1=<?php echo $prov1?>&desc1=<?php echo $desc1?>&desc2=<?php echo $desc2?>&categoria=<?php echo $categoria?>&generico=<?php echo $generico?>&unidadmedida=<?php echo $unidadmedida?>" class="btn btn-success">Nuevo</a> &nbsp;&nbsp; &nbsp;&nbsp;  <input type="text" name='descripcion' id='descripcion' value='' class="text" maxlength="40" style="width: 50%" />  <button  name="buscarArticuloCatalogo" class="btn btn-info" >Buscar Articulo</button>
</form>
<!--<input type="text" class="form-control" id="prov1" name="prov1" placeholder ="Codigo proveedor1" value="<?php echo $data->CLAVE_DISTRIBUIDOR?>"/><br> -->
</div>
<br/>
<div class="row" >
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
                                            <th>Modelo / Medida</th>
                                            <th>Proveedor <br/> Clave </th>
                                            <th>Empaque</th>
                                            <th>Clave Fabricante</th>
                                            <th>Seleccionar</th>
                                            <!--<th>Clientes</th>-->
                                            <!--<th>Proveedores</th>-->
                                            <?php if($user=='gcompras'){?>
                                                <th>Dar de Baja</th>
                                            <?php }?>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($catProductos as $data): 
                                        ?>
                                        <tr>
                                            <td><?php echo $data->IDC;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->GENERICO;?> <?php echo ($data->CALIFICATIVO == '')? '':', '.$data->CALIFICATIVO?> <?php echo ($data->SINONIMO == '')? '':', '.$data->SINONIMO?></td>
                                            <td><?php echo $data->CLAVE_PROD?> <br/>
                                            <?php echo $data->MEDIDAS.' '.$data->UM?>  </td>
                                            <td><?php echo $data->CLAVE_DISTRIBUIDOR?> <br/><p style="font-weight: bold; background-color: red"> <?php echo $data->CLAVE_FABRICANTE.' Precio Lista $ '.$data->PRECIO?> <p><p style="font-weight: bold; background-color: yellow">Costo Neto $ <?php echo $data->COSTO?> </p> </td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->SKU?></td>
                                            <form action="index.php" method="post">
                                            <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                            <td>

                                             <a href="index.php?action=editaFTCART&ids=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class = "btn btn-warning"> Editar </a>
                                            </td>
                                               <!-- <button name="editaFTCART" type="submit" value="enviar" class="btn btn-info"> Editar </button> -->
                                              
                                            </form>
                                            <!--
                                            <form action="index.v.php" method="post">
                                            <td>
                                                <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                                <button  type="sutbmit" value="enviar" class="btn-xs btn-info" name="cltprovXprod"> Proveedores </button>
                                            </td>
                                            </form> 
                                            -->
                                            <?php if($user == 'gcomprassssss'){?>
                                                <form action="index.php" method="post">
                                                    <input type="hidden" name="ids" value="<?php echo $data->ID?>">
                                                    <td>
                                                        <button name='bajaFTCArticualo' class="btn btn-danger">Baja</button>
                                                    </td>    
                                                </form>
                                            <?php }?>    

                                        </tr>
                                        
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<br />

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
     $("#descripcion").autocomplete({
        source: "index.v.php?descAuto=1",
        minLength: 3,
        select: function(event, ui){
        }
    })
</script>



