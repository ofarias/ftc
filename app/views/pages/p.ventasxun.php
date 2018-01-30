<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de CUERO.
                            <p id="totalcuero"></p>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
									<tfoot>

										<tr>
											<th colspan="11" style="text-align:right">Total:</th>
											<th></th>
										</tr>
									</tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($cu as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                       	<tr>	                                        
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td class="subtotalcuero"><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                  
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
                                             </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
    <script>
        tc = document.getEmentById("totalcuero");
        stc = document.getElementsByClassName("subtotalcuero");
        object.addEventListener("load", TotalizaCuero);
        
        function TotalizaCuero(){
          var i;
          var total;
          for(i = 0; i < stc.length; i++){
              total += stc[i];
          }
          tc.innerHTML = total;
        }
    </script>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de Textil.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($te as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                      
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de PN.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($pn as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                    
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de SR.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($sr as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                     
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de ALF.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($alf as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                   
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de CEF.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($cef as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                    
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de CE.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($ce as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                      
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de JUF.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($juf as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                    
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ventas de JU.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Estado</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>UN</th>
                                            <th>Lote</th>                   
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Moneda</th>
                                            <th>TC</th>
                                            <th>USD</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>   

                                        </tr>
                                    </thead>   
                                    <tfoot>

                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($ju as $data): 
                                       /*
                                               $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            } */ 
                                        ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                        <tr>                                            
                                            <td><?php echo $data->FECHA_FACTURA;?></td>
                                            <td><?php echo $data->ELABORADA_EL;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CLAVE_ART;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->UN;?></td>
                                            <td><?php echo $data->LOTE;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_MN,2.,'.',',');?></td>
                                            <td><?php echo $data->MONEDA;?></td>
                                            <td><?php echo "$ ".number_format($data->TC,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->PRECIO_USD,2.,'.',',');?></td>    
                                            <td><?php echo "$ ".number_format($data->SUBTOTAL,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->IVA,2.,'.',',');?></td>
                                            <td><?php echo "$ ".number_format($data->TOTAL,2.,'.',',');?></td>                                   
                                            <!--<td><?php echo "$ " . number_format($data->TOTAL,2,'.',',');?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>-->
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
