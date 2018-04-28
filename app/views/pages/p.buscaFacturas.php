<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Rastreador de Factuas.
                        </div>
                        <!-- /.panel-heading -->
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="docf" class="form-control" required="required" placeholder="Numero de la Factura ">
        </div>
          <button type="submit" value = "enviar" name = "rastreadorFacturas" class="btn btn-default">Buscar Factura</button>
        </form>
    </div>
</div>
<br />

<?php if($val == '1'){
    ?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Facturas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Factura</th>
                                            <th>Cliente</th>
                                            <th>Importe</th>
                                            <th>Saldo</th>
                                            <th>Status</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Logistica</th>
                                            <th>Fecha Revision</th>
                                            <th>Fecha Cobranza</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($factura as $data): 
                                            $color = "style='background-color:white;'";
                                            if($data->STATUS == 'C'){
                                                $color = "style='background-color:red;'"; 
                                            }
                                             
                                        ?>
                                       <tr class='odd gradex' <?php echo $color?>>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2)?></td>
                                            <td><?php echo '$ '.number_format($data->SALDOFINAL,2)?></td>
                                            <td><?php echo $data->STATUS?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA?></td>
                                            <td><?php echo $data->FECHA_REV;?></td>
                                            <td><?php echo $data->FECHA_REC_COBRANZA;?></td>
                                            
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php }
?>






