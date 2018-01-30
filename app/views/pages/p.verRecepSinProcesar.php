<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Cajas para devolucion o reenviar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recmcia">
                                    <thead>
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Proveedor</th>
                                            <th>Cantidad Facturada</th>
                                            <th>Cantidad Devuelta</th>
                                            <th>Producto </th>
                                            <th>Descripcion</th>
                                            <th>Fecha <br/> Devolucion</th>
                                            <th>Folio <br/> Devolucion</th>
                                            <th>Motivo</th>
                                            <th>Recibir Documentos</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        
                                        foreach ($devoluciones as $data): 
                                            $i= $data->ID;

                                            if($data->MOTIVO == 'cancela'){
                                                $motivo = 'Cancelacion del Pedido';
                                            }elseif ($data->MOTIVO == 'noSol') {
                                                $motivo = 'Material No Solicitado';
                                            }elseif ($data->MOTIVO ==  'noExis') {
                                                $motivo = 'No Existe Orden de Compra';
                                            }elseif ($data->MOTIVO == 'malSol') {
                                                $motivo = 'Mal Solicitado';
                                            }else{
                                                $motivo = 'Sin Motivo';
                                            }
                                    ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->DEVUELTO;?></td>
                                            <td><?php echo $data->ARTICULO ?></td>
                                            <td><?php echo $data->DESCRIPCION?></td>
                                            <td><?php echo $data->FECHA_ULTIMA_DEV;?></td>
                                            <td><?php echo $data->FOLIO_DEV;?></td>
                                            <td><?php echo $motivo;?></td>
                                            <input type="hidden" name="idp1" value="<?php echo $data->ID?>" id="idp_<?php echo $i?>">
                                            <input type="hidden" name="cantDev1" value="<?php echo $data->DEVUELTO?>" id="cantDev_<?php echo $i?>">
                                            <td>
                                                <SELECT name="tipo" required="required" onchange="procesar(<?php echo $i?>)" id="resultado_<?php echo $i?>" >
                                                    <option value="">Seleccione un Valor</option>
                                                    <option value="devProv"> Devolver al Proveedor o Garantia</option>
                                                    <option value="ingresoBodega"> Ingresar a Bodega</option>
                                                    <option value="merma">Merma (Roto)</option>
                                                </SELECT>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
</div>


<form action="index.php" method="POST" id="procesarArt">
    <input type="hidden" name="idp" value="" id="idpr">
    <input type="hidden" name="cantDev" value="" id="cantDev">
    <input type="hidden" name="tipo" value="" id="tipo">
    <input type="hidden" name="procesarDev">
</form>
     
<script>
    
    function procesar(i){
        if(confirm('Desea Procesar el Producto?')){
            alert('se proceso');

            var idp = document.getElementById('idp_'+ i).value;
            var cantDev= document.getElementById('cantDev_' + i).value;
            var tipo = document.getElementById('resultado_' + i).value;

            document.getElementById('idpr').value=idp;
            document.getElementById('cantDev').value=cantDev;
            document.getElementById('tipo').value=tipo;
            
           //alert('id: ' + idp + ' Cantidad devuelta ' + cantDev + ' tipo ' + tipo);

            var form = document.getElementById('procesarArt');
            form.submit();

        }else{
            alert('No se proceso el produto');
        }
    }

</script>