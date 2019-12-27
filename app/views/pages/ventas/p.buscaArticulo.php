<br />
<!--
<div>
    Carrito de compras.
    <label> Productos seleccionados</label>
    <label> Monto del pedido</label>
    <label> ver </label>
</div>
-->
<form action="index.v.php" method="post">
<input type="hidden" name="descripcion" value="<?php echo $descripcion?>">
<input type="hidden" name="cotizacion" value="<?php echo $folio?>" id ="idFol">
<input type="hidden" name="cliente" value="<?php echo $cliente?>">
<?php if($detalle== 'Alta'){ ?>
<label> El producto "<?php echo $descripcion ?>", no existe, para solicitar el alta del producto dando click en "Solicitar Alta": </label> <br/>
<button name="altaProdVentas" value="enviar" type="submit" class="btn btn-info"> Solicitar Alta </button> <br/>
<?php }else{  ?>
    <label>Si el producto que buscas no existe, puedes solicitar el Alta.</label> <br/>
    <button name="altaProdVentas" value="enviar" type="submit" class="btn btn-info"> Solicitar Alta </button> <br/>
<?php 
} ?>
</form>

<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                B&uacute;squeda de art&iacute;culo.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="index.v.php" method="POST">
                    
                    
                    <div class="col-sm-1">
                        <?php
                            $cliente = $_SESSION['cliente'];
                            $folio = $_SESSION['folio_cotizacion'];
                            $partida = $_SESSION['partida_cotizacion'];
                        ?>
                        <input type="hidden" name='clave' value="<?php echo $cliente;?>" />   
                        <input type="hidden" name='folio' value="<?php echo $folio;?>" />   
                        <input type="hidden" name='partida' value="<?php echo $partida;?>" />   
                        <label for="articulo">Clave: </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" name="articulo" id="articulo" value="" class="text" maxlength="30" style="width: 100%" />
                    </div>
                    <div class="col-sm-1">
                        <label for="descripcion">Articulo: </label>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" name='descripcion' id='descripcion' value='' class="text" maxlength="90" style="width: 100%" placeholder="Se puede buscar por SKU, Descripcion, Numero de Parte...." />                    
                    </div>
                    <div class="col-sm-2">
                        <input type="button" value="Agregar" name="buscarArticulo"  onclick="agregar(descripcion.value, idFol.value)" />
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<br />



<div>
    <label>Productos precargados:</label><br/>
    <input type="radio" name="seleccion" value="res" onclick="resultados(this.value)" checked="checked">&nbsp;&nbsp;&nbsp;Edicion de Partida &nbsp;&nbsp;&nbsp;
    <input type="radio" name="seleccion" value="res" onclick="resultados(this.value)">&nbsp;&nbsp;&nbsp;Resultado de la Busquesa &nbsp;&nbsp;&nbsp;
    <input type="radio" name="seleccion" value="pxc" onclick="resultados(this.value)">&nbsp;&nbsp;&nbsp;Productos del cliente &nbsp;&nbsp;&nbsp; 
    <input type="radio" name="seleccion" value="pxv" onclick="resultados(this.value)">&nbsp;&nbsp;&nbsp;Productos del Vendedor &nbsp;&nbsp;&nbsp;
    <input type="radio" name="seleccion" value="pxrfc" onclick="resultados(this.value)">&nbsp;&nbsp;&nbsp;Productos por RFC &nbsp;&nbsp;&nbsp;
    <a href="index.v.php?action=verDetalleCotizacion&folio=<?php echo $folio?>" class="btn btn-info">Regresar a la Cotización</a>
</div>
<br/>
<div id="edicion">
<?php if($detalle != 'Alta'){?>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edicion de Partidas Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
                      <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-articulo">
                        <thead>
                            <tr>
                                <th>SEL</th>
                                <th>CATEGORIA</th>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION COMPUESTA <br/> Marca  / Medida</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD  % </th>
                                <th>DESCUENTO</th>
                                <th>MARGEN BAJO</th>
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            $i = 0;
                            foreach ($detalle as $key): 
                                $i= $i + 1;
                                $precio = number_format($key->PRECIO, 2, '.', ',');
                                $costo = $key->COSTO;
                                $precio = $costo * 1.23;
                                $ida = $key->ID;
                                $porcentaje = 0;
                            ?>
                            <tr class="odd gradeX clickable-row" title="Para editar debe deseccionar la partida">
                                <td><input type="checkbox" name="productos[]" value="<?php echo $i?>" <?php echo !empty($key->PARTIDA)? 'checked ="checked"':""?> 
                                    onclick="porcentaje(this.value, edi_porcentaje_<?php echo $i;?>.value, edi_precio_<?php echo $i;?>.value, edi_costo_<?php echo $i?>.value, 'Pre',edi_mm_<?php echo $i?>.value,'edi', edi_descuento_<?php echo $i?>.value)"
                                    id="edi_<?php echo $i?>"
                                >
                                <input type="hidden" name="producto" id="edi_producto_<?php echo $i?>" value="<?php echo $key->ID?>">
                                <input type="hidden" name="cotizacion" id="edi_folio_<?php echo $i?>" value="<?php echo $folio?>" >
                                <td><?php echo $key->CATEGORIA?></td>
                                <td><?php echo $key->ID;?></td>
                                <td><?php echo $key->NOMBRE;?>
                                <br/>Marca: <?php echo $key->MARCA?> Medida: <?php echo $key->MEDIDAS ?></td>
                                <td><?php echo $key->COSTO;?></td>
                                <input type="hidden" name="costo" id="edi_costo_<?php echo $i?>" value="<?php echo $key->COSTO?>" />

                                <td><input type="text" name="cantidad" id="edi_cantidad_<?php echo $i;?>" value="1" maxlength="6" class="text text-right text-muted"  <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>/></td>
                                <td>
                                <input type="text" name="precio" id="edi_precio_<?php echo $i;?>" value="<?php echo $precio;?>" maxlength="13" <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?> 
                                class="text text-right text-muted" 
                                onchange="porcentaje(<?php echo $i?>,edi_porcentaje_<?php echo $i;?>.value, this.value, edi_costo_<?php echo $i?>.value, 'Pre',edi_mm_<?php echo $i?>.value,'edi', edi_descuento_<?php echo $i?>.value)" />
                                </td>
                                <td>
                                    <input type="number" step="any" min="10" name="porcentaje"  <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>
                                    id="edi_porcentaje_<?php echo $i;?>" value="<?php echo $porcentaje?>" 
                                    onchange="porcentaje(<?php echo $i?>,this.value, edi_precio_<?php echo $i;?>.value, edi_costo_<?php echo $i?>.value, 'Por', edi_mm_<?php echo $i?>.value, 'edi')" class="text text-right text-muted">
                                    <?php if($key->MARGEN_BAJO =='Si'){
                                        $utilAut = $key->MARGEN_MINIMO;
                                        ?>
                                    <br/>
                                    Utilidad Solicitada: <?php echo $key->UTILIDAD?> <br/>
                                    Utilidad Autorizada: <?php echo $key->MARGEN_MINIMO?>
                                    <?php }else{
                                        $utilAut = 0;
                                        }?>
                                     <input type="hidden"  name="maut2" id ="MAUT" value="<?php echo $utilAut?>"> 
                                    <input type="hidden" name="mm" id="edi_mm_<?php echo $i?>" value=<?php echo (empty($key->MARGEN_MINIMO))? "0":"$key->MARGEN_MINIMO" ?> >
                                </td>

                                <form action="index.v.php" method="post">
                                <td><input type="text" name="descuento" id="edi_descuento_<?php echo $i;?>" value="0.00" maxlength="13" class="text text-right text-muted" <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>/></td>
                                    <input type="hidden" name="folio" value="<?php echo $folio?>">
                                    <input type="hidden" name="partida" value="<?php echo $partida?>">
                                    <input type="hidden" name="por2" value="" id="edi_por2_<?php echo $i?>">
                                    <td>
                                         <input value="Sol Margen Bajo" type="submit" name="parCotSMB"> 
                                    </td>    
                                </form>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php } ?>
</div>
<div class="hide" id="RES">
<?php if($detalle != 'Alta'){?>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Resultados de la Busqueda de Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
                      <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-articulos">
                        <thead>
                            <tr>
                                <th>SEL</th>
                                <th>CATEGORIA</th>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION COMPUESTA <br/> Marca  / Medida</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD  % </th>
                                <th>DESCUENTO</th>
                                
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            $i = 0;
                            foreach ($detalle as $key): 
                                $i= $i + 1;
                                $precio = number_format($key->PRECIO, 2, '.', ',');
                                $costo = $key->COSTO;
                                $precio = $costo * 1.23;
                                $ida = $key->ID;
                                $porcentaje = 0;
                            ?>
                            <?php if(empty($key->PARTIDA)){?>
                            <tr class="odd gradeX clickable-row" title="Para editar debe deseccionar la partida">
                                <td><input type="checkbox" name="productos[]" value="<?php echo $i?>" <?php echo !empty($key->PARTIDA)? 'checked ="checked"':""?> 
                                    onclick="porcentaje(this.value, res_porcentaje_<?php echo $i;?>.value, res_precio_<?php echo $i;?>.value, res_costo_<?php echo $i?>.value, 'Pre',res_mm_<?php echo $i?>.value,'res', res_descuento_<?php echo $i?>.value)"
                                    id="res_<?php echo $i?>"
                                >
                                <input type="hidden" name="producto" id="res_producto_<?php echo $i?>" value="<?php echo $key->ID?>">
                                <input type="hidden" name="cotizacion" id="res_folio_<?php echo $i?>" value="<?php echo $folio?>" >
                                <td><?php echo $key->CATEGORIA?></td>
                                <td><?php echo $key->ID;?></td>
                                <td><?php echo $key->NOMBRE;?>
                                <br/>Marca: <?php echo $key->MARCA?> Medida: <?php echo $key->MEDIDAS ?></td>
                                <td><?php echo $key->COSTO;?></td>
                                <input type="hidden" name="costo" id="res_costo_<?php echo $i?>" value="<?php echo $key->COSTO?>" />

                                <td><input type="text" name="cantidad" id="res_cantidad_<?php echo $i;?>" value="1" maxlength="6" class="text text-right text-muted"  <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>/></td>
                                <td>
                                <input type="text" name="precio" id="res_precio_<?php echo $i;?>" value="<?php echo $precio;?>" maxlength="13" <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?> 
                                class="text text-right text-muted" 
                                onchange="porcentaje(<?php echo $i?>,pxc_porcentaje_<?php echo $i;?>.value, this.value, pxc_costo_<?php echo $i?>.value, 'Pre',pxc_mm_<?php echo $i?>.value,'res', pxc_descuento_<?php echo $i?>.value)" />
                                </td>
                                <td>
                                    <input type="number" step="any" min="10" name="porcentaje"  <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>
                                    id="res_porcentaje_<?php echo $i;?>" value="<?php echo $porcentaje?>" 
                                    onchange="porcentaje(<?php echo $i?>,this.value, res_precio_<?php echo $i;?>.value, res_costo_<?php echo $i?>.value, 'Por', res_mm_<?php echo $i?>.value, 'res')" class="text text-right text-muted">
                                    <?php if($key->MARGEN_BAJO =='Si'){
                                        $utilAut = $key->MARGEN_MINIMO;
                                        ?>
                                    <br/>
                                    Utilidad Solicitada: <?php echo $key->UTILIDAD?> <br/>
                                    Utilidad Autorizada: <?php echo $key->MARGEN_MINIMO?>
                                    <?php }else{
                                        $utilAut = 0;
                                        }?>
                                     <input type="hidden"  name="maut2" id ="MAUT" value="<?php echo $utilAut?>"> 
                                    <input type="hidden" name="mm" id="res_mm_<?php echo $i?>" value=<?php echo (empty($key->MARGEN_MINIMO))? "0":"$key->MARGEN_MINIMO" ?> >
                                </td>

                                <form action="index.v.php" method="post">
                                <td><input type="text" name="descuento" id="res_descuento_<?php echo $i;?>" value="0.00" maxlength="13" class="text text-right text-muted" <?php echo !empty($key->PARTIDA)? "readOnly='readOnly'":""?>/></td>
                                    <input type="hidden" name="folio" value="<?php echo $folio?>">
                                    <input type="hidden" name="partida" value="<?php echo $partida?>">
                                    <input type="hidden" name="por2" value="" id="res_por2_<?php echo $i?>">
                                </form>
                                
                            </tr>
                            <?php }?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<form action="index.v.php" method="POST" id="FORM_ACTION">
                        <input type="hidden" name="actualizaCotizacionPartida" value="true" />
                        <input type="hidden" name="cotizacion" value="<?php echo $_SESSION['folio_cotizacion'];?>" />
                        <input type="hidden" name="partida" value="<?php echo $_SESSION['partida_cotizacion'];?>" />
                        <input type="hidden" name="articulo" id="producto" value="" />
                        <input type="hidden" name="precio" id="precio" value="" />
                        <input type="hidden" name="descuento" id="descuento" value="" />
                        <input type="hidden" name="cantidad" id="cantidad" value="" />
                        <input type="hidden" name="ida" id="ida" value="">
                    </form>
   <!--                   
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="panel-body">
                <div class="col-sm-9">
                    
                </div>
              <div class="col-sm-1"><a href="index.v.php?action=verDetalleCotizacion&folio=<?php echo $_SESSION['folio_cotizacion'];?>">Cancelar</a></div>
                <div class="col-sm-2"><input type="button" id="seleccionar" value="Seleccionar" class="button" /><
            </div>
        </div>
    </div>
</div>
/div>-->
<?php } ?>
</div>

<div class="hide" id="PXC">
        <label>Productos del Cliente </label>
        <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
                      <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-articulo">
                        <thead>
                            <tr>
                                <th>SEL</th>
                                <th>CATEGORIA</th>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION COMPUESTA <br/> Marca  / Medida</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD  % </th>
                                <th>DESCUENTO</th>
                               
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            $i = 0;
                            foreach ($pxc as $key): 
                                $i= $i + 1;
                                $precio = number_format($key->PRECIO, 2, '.', ',');
                                $costo = $key->COSTO;
                                $precio = $costo * 1.23;
                                $ida = $key->ID;
                                $porcentaje = 0;
                            ?>
                            <tr class="odd gradeX clickable-row">
                                <!--<td><input type="checkbox" name="productos[]" value="<?php echo $key->ID?>" onclick="guardaPartida(this.value, 'pxv_<?php echo $i?>', <?php echo $folio?>)" id="pxv_<?php echo $i?>"></td>-->
                                <td><input type="checkbox" name="productos[]" value="<?php echo $i?>" 
                                    onclick="porcentaje(this.value, pxc_porcentaje_<?php echo $i;?>.value, pxc_precio_<?php echo $i;?>.value, pxc_costo_<?php echo $i?>.value, 'Pre',pxc_mm_<?php echo $i?>.value,'pxc', pxc_descuento_<?php echo $i?>.value)"
                                    id="pxc_<?php echo $i?>"
                                >
                                <input type="hidden" name="producto" id="pxc_producto_<?php echo $i?>" value="<?php echo $key->ID?>">
                                <input type="hidden" name="cotizacion" id="pxc_folio_<?php echo $i?>" value="<?php echo $folio?>" >

                                <td><?php echo $key->CATEGORIA?></td>
                                <td><?php echo $key->ID;?></td>
                                <td><?php echo $key->NOMBRE;?>
                                <br/>Marca: <?php echo $key->MARCA?> Medida: <?php echo $key->MEDIDAS ?></td>
                                <td><?php echo $key->COSTO;?></td>
                                <input type="hidden" name="costo" id="pxc_costo_<?php echo $i?>" value="<?php echo $key->COSTO?>" />

                                <td><input type="text" name="cantidad" id="pxc_cantidad_<?php echo $i;?>" value="1" maxlength="6" class="text text-right text-muted" /></td>
                                <td>
                                <input type="text" name="precio" id="pxc_precio_<?php echo $i;?>" value="<?php echo $precio;?>" maxlength="13" 
                                class="text text-right text-muted" 
                                onchange="porcentaje(<?php echo $i?>,pxc_porcentaje_<?php echo $i;?>.value, this.value, pxc_costo_<?php echo $i?>.value, 'Pre',pxc_mm_<?php echo $i?>.value,'pxc', pxc_descuento_<?php echo $i?>.value)" />
                                </td>
                                <td>
                                    <input type="number" step="any" min="10" name="porcentaje" 
                                    id="pxc_porcentaje_<?php echo $i;?>" value="<?php echo $porcentaje?>" 
                                    onchange="porcentaje(<?php echo $i?>,this.value, pxc_precio_<?php echo $i;?>.value, pxc_costo_<?php echo $i?>.value, 'Por', pxc_mm_<?php echo $i?>.value, 'pxc')" class="text text-right text-muted">
                                    <?php if($key->MARGEN_BAJO =='Si'){
                                        $utilAut = $key->MARGEN_MINIMO;
                                        ?>
                                    <br/>
                                    Utilidad Solicitada: <?php echo $key->UTILIDAD?> <br/>
                                    Utilidad Autorizada: <?php echo $key->MARGEN_MINIMO?>
                                    <?php }else{
                                        $utilAut = 0;
                                        }?>
                                     <input type="hidden"  name="maut2" id ="MAUT" value="<?php echo $utilAut?>"> 
                                    <input type="hidden" name="mm" id="pxc_mm_<?php echo $i?>" value=<?php echo (empty($key->MARGEN_MINIMO))? "0":"$key->MARGEN_MINIMO" ?> >
                                </td>

                                <form action="index.v.php" method="post">
                                <td><input type="text" name="descuento" id="pxc_descuento_<?php echo $i;?>" value="0.00" maxlength="13" class="text text-right text-muted" /></td>
                                    <input type="hidden" name="folio" value="<?php echo $folio?>">
                                    <input type="hidden" name="partida" value="<?php echo $partida?>">
                                    <input type="hidden" name="por2" value="" id="pxc_por2_<?php echo $i?>">
                                    
                                </form>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="hide" id="PXV">
        <label> Presentamos los productos del vendedor</label>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-articulo">
                        <thead>
                            <tr>
                                <th>SEL</th>
                                <th>SKU</th>
                                <th>CATEGORIA</th>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION COMPUESTA <br/> Marca  / Medida</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD  % </th>
                                <th>DESCUENTO</th>
                                
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            $i = 0;
                            foreach ($pxv as $key): 
                                $i= $i + 1;
                                $precio = number_format($key->PRECIO, 2, '.', ',');
                                $costo = $key->COSTO;
                                $precio = $costo * 1.23;
                                $ida = $key->ID;
                                $porcentaje = 0;
                            ?>
                            <tr class="odd gradeX clickable-row">
                                <!--<td><input type="checkbox" name="productos[]" value="<?php echo $key->ID?>" onclick="guardaPartida(this.value, 'pxv_<?php echo $i?>', <?php echo $folio?>)" id="pxv_<?php echo $i?>"></td>-->
                                <td><input type="checkbox" name="productos[]" value="<?php echo $i?>" 
                                    onclick="porcentaje(this.value, pxv_porcentaje_<?php echo $i;?>.value, pxv_precio_<?php echo $i;?>.value,pxv_costo_<?php echo $i?>.value, 'Pre',pxv_mm_<?php echo $i?>.value,'pxv', pxv_descuento_<?php echo $i?>.value)"
                                    id="pxv_<?php echo $i?>"
                                >
                                <input type="hidden" name="producto" id="pxv_producto_<?php echo $i?>" value="<?php echo $key->ID?>">
                                <input type="hidden" name="cotizacion" id="pxv_folio_<?php echo $i?>" value="<?php echo $folio?>" >
                                <td><?php echo $key->SKU?></td>
                                <td><?php echo $key->CATEGORIA?></td>
                                <td><?php echo $key->ID;?></td>
                                <td><?php echo $key->NOMBRE;?>
                                <br/>Marca: <?php echo $key->MARCA?> Medida: <?php echo $key->MEDIDAS ?></td>
                                <td><?php echo $key->COSTO;?></td>
                                <input type="hidden" name="costo" id="pxv_costo_<?php echo $i?>" value="<?php echo $key->COSTO?>" />

                                <td><input type="text" name="cantidad" id="pxv_cantidad_<?php echo $i;?>" value="1" maxlength="6" class="text text-right text-muted" /></td>
                                <td>
                                <input type="text" name="precio" id="pxv_precio_<?php echo $i;?>" value="<?php echo $precio;?>" maxlength="13" 
                                class="text text-right text-muted" 
                                onchange="porcentaje(<?php echo $i?>,pxv_porcentaje_<?php echo $i;?>.value, this.value, pxv_costo_<?php echo $i?>.value, 'Pre',pxv_mm_<?php echo $i?>.value,'pxv', pxv_descuento_<?php echo $i?>.value)" />
                                </td>
                                <td>
                                    <input type="number" step="any" min="10" name="porcentaje" 
                                    id="pxv_porcentaje_<?php echo $i;?>" value="<?php echo $porcentaje?>" 
                                    onchange="porcentaje(<?php echo $i?>,this.value, pxv_precio_<?php echo $i;?>.value, pxv_costo_<?php echo $i?>.value, 'Por', pxv_mm_<?php echo $i?>.value, 'pxv')" class="text text-right text-muted">
                                    <?php if($key->MARGEN_BAJO =='Si'){
                                        $utilAut = $key->MARGEN_MINIMO;
                                        ?>
                                    <br/>
                                    Utilidad Solicitada: <?php echo $key->UTILIDAD?> <br/>
                                    Utilidad Autorizada: <?php echo $key->MARGEN_MINIMO?>
                                    <?php }else{
                                        $utilAut = 0;
                                        }?>
                                     <input type="hidden"  name="maut2" id ="MAUT" value="<?php echo $utilAut?>"> 
                                    <input type="hidden" name="mm" id="pxv_mm_<?php echo $i?>" value=<?php echo (empty($key->MARGEN_MINIMO))? "0":"$key->MARGEN_MINIMO" ?> >
                                </td>

                                <form action="index.v.php" method="post">
                                <td><input type="text" name="descuento" id="pxv_descuento_<?php echo $i;?>" value="0.00" maxlength="13" class="text text-right text-muted" /></td>
                                    <input type="hidden" name="folio" value="<?php echo $folio?>">
                                    <input type="hidden" name="partida" value="<?php echo $partida?>">
                                    <input type="hidden" name="por2" value="" id="pxv_por2_<?php echo $i?>">
                                   
                                </form>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="hide" id="PXRFC">
        <label> Presentamos los productos del RFC</label>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-buscaArt">
                        <thead>
                            <tr>
                                <th>SEL</th>
                                <th>SKU <br/> SKU CLIENTE <br/> SKU OTRO</th> 
                                <th>CATEGORIA</th>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION COMPUESTA <br/> Marca  / Medida</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD  % </th>
                                <th>DESCUENTO</th>
                                
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            $i = 0;
                            foreach ($pxrfc as $key): 
                                $i= $i + 1;
                                $precio = number_format($key->PRECIO, 2, '.', ',');
                                $costo = $key->COSTO;
                                $precio = $costo * 1.23;
                                $ida = $key->ID;
                                $porcentaje = 0;
                            ?>
                            <tr class="odd gradeX clickable-row">
                                <!--<td><input type="checkbox" name="productos[]" value="<?php echo $key->ID?>" onclick="guardaPartida(this.value, 'pxv_<?php echo $i?>', <?php echo $folio?>)" id="pxv_<?php echo $i?>"></td>-->
                                <td><input type="checkbox" name="productos[]" value="<?php echo $i?>" 
                                    onclick="porcentaje(this.value, pxrfc_porcentaje_<?php echo $i;?>.value, pxrfc_precio_<?php echo $i;?>.value, pxrfc_costo_<?php echo $i?>.value, 'Pre',pxrfc_mm_<?php echo $i?>.value,'pxrfc', pxrfc_descuento_<?php echo $i?>.value)"
                                    id="pxrfc_<?php echo $i?>"
                                >
                                <input type="hidden" name="producto" id="pxrfc_producto_<?php echo $i?>" value="<?php echo $key->ID?>">
                                <input type="hidden" name="cotizacion" id="pxrfc_folio_<?php echo $i?>" value="<?php echo $folio?>" >
                                <td><?php echo $key->SKU?> <br/> <?php echo $key->SKU_CLIENTE?> <br/> <?php echo $key->SKU_OTRO?> </td>
                                <td><?php echo $key->CATEGORIA?></td>
                                <td><?php echo $key->ID;?></td>
                                <td><?php echo $key->NOMBRE;?>
                                <br/>Marca: <?php echo $key->MARCA?> Medida: <?php echo $key->MEDIDAS ?></td>
                                <td><?php echo $key->COSTO;?></td>
                                <input type="hidden" name="costo" id="pxrfc_costo_<?php echo $i?>" value="<?php echo $key->COSTO?>" />

                                <td><input type="text" name="cantidad" id="pxrfc_cantidad_<?php echo $i;?>" value="1" maxlength="6" class="text text-right text-muted" /></td>
                                <td>
                                <input type="text" name="precio" id="pxrfc_precio_<?php echo $i;?>" value="<?php echo $precio;?>" maxlength="13" 
                                class="text text-right text-muted" 
                                onchange="porcentaje(<?php echo $i?>,pxrfc_porcentaje_<?php echo $i;?>.value, this.value, pxrfc_costo_<?php echo $i?>.value, 'Pre',pxrfc_mm_<?php echo $i?>.value,'pxrfc', pxrfc_descuento_<?php echo $i?>.value)" />
                                </td>
                                <td>
                                    <input type="number" step="any" min="10" name="porcentaje" 
                                    id="pxrfc_porcentaje_<?php echo $i;?>" value="<?php echo $porcentaje?>" 
                                    onchange="porcentaje(<?php echo $i?>,this.value, pxrfc_precio_<?php echo $i;?>.value, pxrfc_costo_<?php echo $i?>.value, 'Por', pxrfc_mm_<?php echo $i?>.value, 'pxrfc')" class="text text-right text-muted">
                                    <?php if($key->MARGEN_BAJO =='Si'){
                                        $utilAut = $key->MARGEN_MINIMO;
                                        ?>
                                    <br/>
                                    Utilidad Solicitada: <?php echo $key->UTILIDAD?> <br/>
                                    Utilidad Autorizada: <?php echo $key->MARGEN_MINIMO?>
                                    <?php }else{
                                        $utilAut = 0;
                                        }?>
                                     <input type="hidden"  name="maut2" id ="MAUT" value="<?php echo $utilAut?>"> 
                                    <input type="hidden" name="mm" id="pxrfc_mm_<?php echo $i?>" value=<?php echo (empty($key->MARGEN_MINIMO))? "0":"$key->MARGEN_MINIMO" ?> >
                                </td>

                                <form action="index.v.php" method="post">
                                <td><input type="text" name="descuento" id="pxrfc_descuento_<?php echo $i;?>" value="0.00" maxlength="13" class="text text-right text-muted" /></td>
                                    <input type="hidden" name="folio" value="<?php echo $folio?>">
                                    <input type="hidden" name="partida" value="<?php echo $partida?>">
                                    <input type="hidden" name="por2" value="" id="pxrfc_por2_<?php echo $i?>">
                                   
                                </form>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">


    function agregar(art, fol){
        //alert('Se Agregara el articulo' + art + ' a la cotizacion :' + fol);
         $.ajax({
            type:"POST",
            url:"index.v.php",
            dataType:"json",
            data:{guardaPartida:art, folio:fol, tipo:'gd', cantidad:1, precio:1, descuento:0, mb:1, mm:1, costo:1},
            success: function(data){
                if(data.status == 'ok'){
                    alert('Se agrego la partida');  
                    document.getElementById('descripcion').value = '';  
                }else if (data.status =='no'){
                    alert('No se logro insertar por que la cotizacion ya ha sido finalizada');
                }
            }
            });    
    }


    function porcentaje(id, porc, precio, costo, tipo, mm, tipo2, desc){

       //alert('Llegan las variables' + id +' , ' + porc  + ', ' + precio + ', ' + costo +  ', ' +  tipo +  ', '+ mm + ', ' + desc + ', ' + tipo2);
        
       var porcentaje = 5;
        if(mm != 0){
            porcentaje = mm;
        }

        if(tipo == 'Por'){
            //alert('tipo' + tipo);
            var nuevoprecio = costo * ((porc/100) +1)    
            document.getElementById(tipo2+'_precio_'+ id).value = nuevoprecio.toFixed(2);
        }else{
            //alert('tipo' + tipo);
            var nuevoporcentaje = ((precio / costo)-1) * 100;
            document.getElementById(tipo2+'_porcentaje_'+ id).value = nuevoporcentaje.toFixed(2);
            porc = parseFloat(nuevoporcentaje); 
        }

        porc = parseFloat(porc);
        //alert('Porc' + porc);
            document.getElementById(tipo2+'_por2_'+id).value = porc;
        //alert('Ya sabes');
        if(porc < porcentaje){
            //alert('Porcentaje Bajo');
            document.getElementById(tipo2+'_porcentaje_'+ id).focus();
            document.getElementById(tipo2+'_'+ id).checked=false;

            alert("La utilidad no debe de ser menor al 23% favor de revisar. " + porc + ', debe solicitar Margen Bajo');
        }else{
        //    alert ('Porcetaje OK');
            var producto = document.getElementById(tipo2+'_producto_' + id).value;
        //    alert('producto' + producto); 
            var folio = document.getElementById(tipo2+'_folio_'+id).value;
        //    alert('Folio'+folio);
            document.getElementById(tipo2+'_cantidad_'+id).readOnly=true;
            document.getElementById(tipo2+'_precio_'+id).readOnly=true;
            document.getElementById(tipo2+'_porcentaje_'+id).readOnly=true;
            document.getElementById(tipo2+'_descuento_'+id).readOnly=true;
        //    alert('Enviamos ' + producto + ' id '+ id + ' folio ' + folio);
            
            var guardar= guardaPartida(producto, id, folio, 'g', tipo2, precio, costo, mm, desc, 1);
        }

        alert('Se Agrego el Producto a la cotizacion.');
        
    }

    function guardaPartida(prod, i, folio, tipo, tipo2, precio, costo, mm, descuento, mb){
        var sel = document.getElementById(tipo2+'_'+i);
        //alert('id: ' + tipo2 + '_' + i)
        var cantidad = document.getElementById(tipo2+'_cantidad_'+i).value;
        //alert('Se agregara el producto:' + prod + ' a la cotizacion ' +  folio +  'Se marco el consecutivo ' + i + ' el tipo: '+ tipo + ' valor de precio ' + precio + ' Costo: ' + costo  );
        if(sel.checked == true){
            //alert('entra al seleccionado, tratara de guardar');
            var tipo = 'g';
            $.ajax({
            type:"POST",
            url:"index.v.php",
            dataType:"json",
            data:{guardaPartida:prod, folio:folio, tipo:tipo, cantidad:cantidad, precio:precio, descuento:descuento, mb:mb, mm:mm, costo:costo},
            success: function(data){
                if(data.status == 'ok'){
                    alert('Se agrego la partida');    
                }else{
                    alert('No se logro insertar');
                }
            }
            });    
        }else{
            document.getElementById(tipo2+'_cantidad_'+i).readOnly=false;
            document.getElementById(tipo2+'_precio_'+i).readOnly=false;
            document.getElementById(tipo2+'_porcentaje_'+i).readOnly=false;
            document.getElementById(tipo2+'_descuento_'+i).readOnly=false;
            //alert('entra al NO seleccionado, tratara de borrar');
            var tipo = 'e';
            $.ajax({
            type:"POST",
            url:"index.v.php",
            dataType:"json",
            data:{guardaPartida:prod, folio:folio, tipo:tipo, cantidad:cantidad, precio:precio, descuento:descuento, mb:mb, mm:mm, costo:costo},
            success: function(data){
                if(data.status == 'ok'){
                    alert('Se elimino la partida correctamente');    
                }else{
                    alert('No se logro eliminar');
                }
            }
            });   
        }
    }

    function resultados(tipo){
        //alert('Se Selecciono el tipo ' + tipo);

        if(tipo == 'pxc'){
            document.getElementById("edicion").classList.add('hide')
            document.getElementById("PXC").classList.remove('hide');
            document.getElementById("PXV").classList.add('hide');
            document.getElementById("RES").classList.add('hide');
            document.getElementById("PXRFC").classList.add('hide');
        }else if(tipo == 'pxv'){
            document.getElementById("edicion").classList.add('hide')
            document.getElementById("PXC").classList.add('hide');
            document.getElementById("PXV").classList.remove('hide');
            document.getElementById("RES").classList.add('hide');
            document.getElementById("PXRFC").classList.add('hide');
        }else if(tipo == 'res'){
            document.getElementById("edicion").classList.add('hide')
            document.getElementById("PXC").classList.add('hide');
            document.getElementById("PXV").classList.add('hide');
            document.getElementById("RES").classList.remove('hide');
            document.getElementById("PXRFC").classList.add('hide');
        }else if(tipo == 'pxrfc'){
            document.getElementById("edicion").classList.add('hide')
            document.getElementById("PXC").classList.add('hide');
            document.getElementById("PXV").classList.add('hide');
            document.getElementById("RES").classList.add('hide');
            document.getElementById("PXRFC").classList.remove('hide');
        }else if (tipo == 'edicion'){
            document.getElementById("edicion").classList.remove('hide')
            document.getElementById("PXC").classList.add('hide');
            document.getElementById("PXV").classList.add('hide');
            document.getElementById("RES").classList.add('hide');
            document.getElementById("PXRFC").classList.add('hide');
        }


    }

    



    var clave, costo, precio, descuento, cantidad;
    $('#dataTables-articulos').on('click', '.clickable-row', function(event) {
        console.log(event);
        console.log(event.currentTarget.cells[1].innerHTML);
        console.log(event.currentTarget.cells[3].innerHTML);
        console.log(event.currentTarget.cells[4].firstElementChild.id);
        console.log(event.currentTarget.cells[5].firstElementChild.id);
        console.log(event.currentTarget.cells[6].firstElementChild.id);
        clave = event.currentTarget.cells[1].innerHTML;
        costo = event.currentTarget.cells[3].innerHTML;
        cantidad = $("#"+event.currentTarget.cells[4].firstElementChild.id);
        precio = $("#"+event.currentTarget.cells[5].firstElementChild.id);
        descuento = $("#"+event.currentTarget.cells[7].firstElementChild.id);        
        $(this).addClass('active').siblings().removeClass('active');
    });



    $("#seleccionar").click(function (event){
        valorPrecio = precio.val();
        valorCosto = costo;
        valorPrecioMinimo = (valorCosto * 1.23).toFixed(2);
        valorDescuento = descuento.val();
        valorCantidad = cantidad.val();
        valorPrecioMinino = parseFloat(valorPrecioMinimo);
        valorPrecio = parseFloat(valorPrecio);
        var a = document.getElementById('MAUT').value;
        if(a != 0){
            a = (a / 100) + 1; // Lo convertimos en  porcentaje;  1.19
            valorPrecioMinimo = parseFloat(valorCosto * a).toFixed(2); /// Sacamos el nuevo costo.   
        }
        if (valorPrecioMinimo > valorPrecio){
            OpenWarning("El precio mínimo para este artículo es de "+valorPrecioMinimo + 'precio = '+ valorPrecio + 'Valor autorizado' + a);
        } else {
            $("#ida").val(clave);            
            $("#precio").val(valorPrecio);
            $("#descuento").val(valorDescuento);
            $("#cantidad").val(valorCantidad);
            $("#FORM_ACTION").submit();
        }
    });



     $("#descripcion").autocomplete({
        source: "index.v.php?descAuto=1",
        minLength: 3,
        select: function(event, ui){
        }
    })

     /*     
    $("#prov1").autocomplete({
        source: "index.v.php?proveedor=1",
        minLength: 2,
        select: function(event, ui){
        }
    })

     */

    function OpenWarning(mensaje) {
        var mensaje = mensaje || "Algo no salió como se esperaba...";
        bootbox.dialog({
            message: mensaje,
            title: "<i class=\"fa fa-warning warning\"></i>",
            className: "modal modal-message modal-warning fade",
            buttons: {
                "OK": {
                    className: "btn btn-warning",
                    callback: function () {}
                }
            }
        });
    }


</script>
