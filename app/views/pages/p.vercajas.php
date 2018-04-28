<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-cajas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CP</th> 
                                            <th>Fecha Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Fecha Apertura Caja</th>
                                            <th>Embalaje Completo?</th>
                                            <th>Imprimir PreFactura</th>
                                            <th>Facturar</th>

                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->ID;?></a></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
											<td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo ($data->EMBALAJE == 'TOTAL')? 'Si':'No';?></td>
                                            <td>
                                                <input type="button" name="preFactura" value="Prefactura" onclick="impPreFact(<?php echo $data->ID?>)">
                                            </td>
                                            <td>
                                                <input type="button" value="Cerrar" onclick="facturarCaja(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>')" id="caja_<?php echo $data->ID?>">

                                            	<!--<form action="index.php" method="post">
                                            	   <input name="idcaja" type="hidden" value="<?php echo $data->ID?>" /> 
                                                   <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            	   <button name="cerrarcaja" type="submit" value="enviar" class="btn btn-warning" <?php echo ($data->EMBALAJE == 'TOTAL') ? '':'disabled';?> >Cerrar <i class="fa fa-th-large"></i></button>
                                                </form> -->
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
<form action ="index.php" method="POST" id='FORM_EXEC'>
    <input type="hidden" name="impPreFact" value="" id="val">
</form>
<script type="text/javascript">
    function facturarCaja(idcaja, docf){
        if(confirm('Desea cerrar la caja.')){
            document.getElementById('caja_'+idcaja).classList.add('hide');
            //alert('Prepara el JSon para la factura' + idcaja + docf );
            $.ajax({
                url:'index.php',
                method:'POST',
                dataType:'json',
                data:{facturar:idcaja},
                success:function(data){
                    if(data.status == 'ok'){
                        alert('Se ha creado la factura '+ data.factura);
                        $.ajax({
                            url:'index.php',
                            method:'POST',
                            dataType:'json',
                            data:{cerrarcaja:1, idcaja:idcaja, docf:docf},
                            success:function(data){
                                if(data.status == 'ok'){
                                    alert('Se ha cerrado la caja.' + mensaje);
                                }else{
                                    alert('No se ha cerrado la caja, razon:' + data.mensaje)
                                }
                            }
                        });
                    }else{
                        alert('NO se pudo crear la factura, intente nuevamente');
                    }
                }
            });
        }else{
            alert('Le recordamos que no deben de quedar Cajas sin facturar.');
        }
    }
    function impPreFact(idc){
        if(confirm('Desea Descargar la Prefactura?')){
            document.getElementById('val').value=idc;
            var form= document.getElementById('FORM_EXEC');
            form.submit();
            /*$.ajax({
                url:"index.php",
                method:"POST",
                dataType:"json",
                data:{impPreFact:idc},
                success:function(){

                }
            })*/
        }
    }


</script>