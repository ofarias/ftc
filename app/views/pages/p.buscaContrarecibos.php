<?php if($contrarecibo != 0){ ?>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Busqueda de Recepciones para Reimpresion de Contra Recibo.
                        </div>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="campo" class="form-control" required="required" placeholder="Busqueda de Recepcion">
        </div>
          <button type="submit" value = "enviar" name = "buscarContrarecibos" class="btn btn-info">Buscar</button>
        </form>
    </div>
</div>
<br />

<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Contrarecibo.
            </div>
                <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>FECHA</th>
                                        <th>RECEPCION</th>
                                        <th>FECHA</th>
                                        <th>PROVEEDOR</th>
                                        <th>IMPORTE</th>
                                        <th>USUARIO</th>   
                                        <th>Reimprimir</th>           
                                    </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($contrarecibo as $data):
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $data->FECHA_IMPRESION;?></td>
                                            <td><?php echo $data->IDENTIFICADOR;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO_REAL,2);?></td>
                                            <td><?php echo $data->USUARIO;?></td>   
                                            <td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="identificador" value ="<?php echo $data->IDENTIFICADOR;?>" /><
                                            <input type="hidden" name="tipo" value="Recepcion">
                                            <button name="impresionContrarecibo" value = "enviar" type = "submit" class="btn btn-info"> Reimprimir</button>
                                            </form>
                                            </td>  
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<?php }else{?>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Busqueda de Contrarecibos para Reimpresion.
                        </div>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="campo" class="form-control" required="required" placeholder="Busqueda de Contrarecibo">
        </div>
          <button type="submit" value = "enviar" name="buscarContrarecibos" class="btn btn-info">Buscar</button>
        </form>
    </div>
</div>
<br />

<?php } ?>

