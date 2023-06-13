<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Confirmar Pagos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">                
                <div class="table-responsive">  
                    <span>Conciliaci&oacute;n de pago</span>
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>IDENTIFICADOR</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA ELABORACION</th>
                                <th>IMPORTE</th>
                                <th>FECHA</th>
                                <th>CONCILIAR</th>
                            </tr>
                        </thead>   
<!--                        <tfoot>
                            <tr>
                                <th colspan="11" style="text-align:right">Total:</th>
                                <th></th>
                            </tr>
                        </tfoot>-->
                        <tbody>
                            
                            <?php
                            if($pagos!=null){
                                $indice = 0;
                                foreach ($pagos as $data): 
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $data->TIPO; ?></td>
                                    <td><?php echo $data->IDENTIFICADOR; ?></td>
                                    <td><?php echo $data->NOMBRE; ?></td>
                                    <td><?php echo $data->FECHA_PAGO; ?></td>
                                    <td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                                    <td><input type="date" name="fecha" id="datepicker" required="required" /></td>
                                    <td><input type="button" value="Aplicar" onclick="conciliarPago('<?php echo $data->TIPO?>', '<?php echo $data->IDENTIFICADOR; ?>');" /></td>
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
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_PAGOS">
    <input name="identificador" id="identificador" type="hidden" value=""/>
    <input name="tipo" id="tipo" type="hidden" value="" />
    <input name="fecha" id="fecha" type="hidden" value=""/>
    <input name="FORM_ACTION_PAGOS_CONCILIA" type="hidden" value="FORM_ACTION_PAGOS_CONCILIA"/>
</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="/resources/demos/style.css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
 <script>
     $( function() {
       $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});      
     });  
 </script>

<script language="javascript">
    function conciliarPago(tipo, identificador) {
        document.getElementById("identificador").value = identificador;
        document.getElementById("tipo").value = tipo;
        document.getElementById("fecha").value = document.getElementById("datepicker").value;
        var form = document.getElementById("FORM_ACTION_PAGOS");
        form.submit();        
    }
</script>