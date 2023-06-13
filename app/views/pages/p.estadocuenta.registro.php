<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Estado de cuenta
            </div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <p>
                    <span style="font-weight: bolder;padding: 5px;margin: 10px;">Registro de detalle <?php echo "$banco - $cuenta";?></span>
                    </p>
                    <?php
                    $fecha = $dia;
                    //echo "dia: $dia";
                    ?>
                   
                    <form action="index.php"  id="FORM_ACTION_ESTADOCUENTA" method="POST">
                        <input type="hidden" name="idcuenta" value="<?php echo $identificador;?>" />
                        <input type="hidden" name="banco" value="<?php echo $banco;?>" />
                        <input type="hidden" name="numero_cuenta" value="<?php echo $cuenta;?>" />   
                        <label for="fecha">Fecha</label>
                        <input type="text" id="datepicker" name="fecha" value="<?php echo $fecha; ?>" style="width: 90px" />
                        <label for="descripcion">Descripci&oacute;n</label>
                        <input type="text" id="descripcion" name="descripcion" maxlength="60" required="required" />
                        <label for="monto">Importe</label>
                        <input type="text" id="monto" name="monto" max="14" required="rquiered" style="width: 110px;text-align: right" />
                        <input type="reset" id="cancelar" name="cancelar" value="Cancelar" />
                        <input type="submit" id="guardar" name="FORM_ACTION_EDOCTA_REGISTRAR" value="Guardar" />
                    </form>
                    
                    <?php 
                    if(empty($exec)){
                      echo "<!- - NO HAY DATOS - ->";
                    } else {
                      ?>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>DESCRIPCI&Oacute;N</th> 
                                <th>MONTO</th> 
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php 
                            foreach ($exec as $data): 
                                $identificador = $data->IDENTIFICADOR;
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $data->FEREGISTRO; ?></td>
                                    <td><?php echo $data->DSREGISTRO; ?></td>
                                    <td><?php echo "$ " . number_format($data->DCREGISTRO, 2, '.', ','); ?></td>
                                    <td><input type="button" id="eliminar" value="Eliminar" identificador="<?php echo $data->IDREGISTRO?>" /></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right">
                                    <input type="button" id="registrar" onclick="registrar('<?php echo $identificador;?>')">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- /.table-responsive -->
                    <?php 
                  }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
    $( function() {
      $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});      
    });  
</script>