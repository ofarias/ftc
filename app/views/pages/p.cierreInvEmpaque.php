<div>
    <label>Selecciona el mes a cerrar :</label>
    
        <select name="fecha" required="required" id="fecha">
            <option value="no"> Seleccionar un Mes / año</option>
            <option value="12:2017">Diciembre / 2017</option>
            <option value="01:2018">Enero / 2018</option>
        </select>
        <br/>
        <br/>
        <input class="btn btn-info"  type="button"  value="Cierre Empaque"  onclick="ejecuta(this.value)">
        <input class="btn btn-success" type="button" value="Cierre Bodega"  onclick="ejecuta(this.value)" >
        <input class="btn btn-info"    type="button" value="Cierre Remisiones" onclick="ejecuta(this.value)" >
        <input class="btn btn-warning" type="button" value="Cierre Consignacion" onclick="ejecuta(this.value)" > 
        <input type="hidden" name="cierreInvEmpaque" value="123"  >
</div>
<?php if(count($cierre) > 0 ){?>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Cajas para devolucion o reenviar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Entradas</th>
                                            <th>Salidas</th>
                                            <th>Cantidad Empaque</th>
                                            <th>Costo</th>
                                            <th>SubTotal</th>
                                            <th>IVA <br/> </th>
                                            <th>Total <br/> </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($cierre as $data): 
                                            $i++;
                                            $empaque = $data->ENTRADAS - $data->SALIDAS;
                                            $SubTotal = $data->COSTO * $empaque;
                                            $iva = ($data->COSTO * $empaque) * 0.16;
                                            $Total = ($data->COSTO * $empaque)* 1.16;

                                        ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->ENTRADAS;?></td>
                                            <td><?php echo $data->SALIDAS;?></td>
                                            <td><?php echo $empaque;?></td>
                                            <td><?php echo $data->COSTO ?></td>
                                            <td><?php echo $SubTotal?></td>
                                            <td><?php echo $iva;?></td>
                                            <td><?php echo $Total;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
</div>
<?php }?>

<form action="index.php" method="POST" id="formEjecuta">
    <input type="hidden" name="fecha" value="" id="tipo_send">
    <input type="hidden" name="tipo" value="" id="fecha_send">
    <input type="hidden" name="cierreInvEmpaque" value="cierreInvEmpaque">
</form>

<script type="text/javascript">
    
    function ejecuta(tipo){

        var fecha = document.getElementById('fecha').value;
        //alert('Valor de fecha: ' + fecha);
        if(fecha=='no'){
            alert('Debe de seleecionar una fecha.');
        }else{

            document.getElementById('tipo_send').value=tipo;
            document.getElementById('fecha_send').value=fecha;
            var form = document.getElementById('formEjecuta');

            form.submit();
        }


    }

</script>