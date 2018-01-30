<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Busqueda de Ordenes de Compra para colocar en Edo de Cuenta.
                        </div>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="campo" class="form-control" required="required" placeholder="Buscar Numero u Orden de compra"> <br/>
            <input type="hidden" name="fechaedo" value = "<?php echo $fechaedo?>">
            <label> Ejemplo: para encontrar la Orden de compra OC1010, puede buscar por 1010 o OC o OC1010 o oc1010.</label>
        </div>
          <button type="submit" value = "enviar" name = "traeOC" class="btn btn-info" >Buscar OC</button>
        </form>
    </div>
</div>
<br />


<?php if($oc!=1)
{
    ?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Ordenes de compra:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Folio de Pago</th>
                                            <th>Forma de Pago</th>
                                            <th>Banco </th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto Final</th>
                                            <th>Factura Proveedor</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($oc as $data):
                                        ?>
                                       <tr>  
                                       <form action = "index.php" method="post" >
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td>
                                                <select name = "tpf" required="required">
                                                       <option value="0">-Seleccionar-</option>
                                                       <option value="tr"> Transferencia</option>
                                                       <option value="ch"> Cheques </option>
                                                       <option value="e"> Efectivo</option>
                                                     
                                                </select>
                                            </td>
                                            <td>
                                                <select name = "banco" required="required">
                                                        <option value = "0" > --- Seleccione Banco --- </option>
                                                        <?php foreach ($banco as $datos):?>
                                                            <option value = "<?php echo $datos->BANCO?>"> <?php echo $datos->BANCO?></option> 
                                                        <?php endforeach?>
                                                     </select>
                                            </td>

                                            <td>
                                                <input type="text" name="fechaedo" class="fecha" placeholder="Seleccione Fecha" required="required" value="<?php echo $fechaedo?>" >
                                            </td>
                                            <td>
                                                <input type="number" step = "any" name="montof" value ="<?php echo $data->IMPORTE?>" required="required"/>
                                            </td>
                                            <td>
                                                <input type="text" name="factura" required="required" placeholder ="Factura Proveedor" />
                                            </td>

                                           
                                                <input type="hidden" name="doco" value ="<?php echo $data->CVE_DOC?>" />
                                            <td>
                                                <button name="procesarOC" value="enviar" type ="submit" 
                                                <?php echo ($data->STATUS =='C')? 'class= "btn btn-danger"':'class= "btn btn-success"'?>  
                                                <?php echo ($data->STATUS == 'C' or (!empty($data->EDOCTA_FECHA)))? 'disabled= "disabled"':'' ?>
                                                > 
                                                <?php echo ($data->STATUS =='C')? 'Cancelado':(!empty($data->EDOCTA_FECHA)? 'Procesado':'Procesar') ?> </button>
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
<?php }
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
  } );

</script>

